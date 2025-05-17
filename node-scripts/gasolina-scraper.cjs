const puppeteer = require('puppeteer');
const fs = require('fs');

const ufs = [
  "BR", "AL", "AM", "AP", "BA", "CE", "DF", "ES", "GO", "MA", "MT",
  "MG", "PR", "PB", "PA", "PE", "RS", "RJ", "SC", "SP", "TO"
];

const resultados = {};

(async () => {
  const browser = await puppeteer.launch({
    headless: true,
    defaultViewport: { width: 1280, height: 800 }
  });

  for (const uf of ufs) {
    const page = await browser.newPage();
    const url = `https://precos.petrobras.com.br/w/gasolina/${uf.toLowerCase()}`;

    console.log(`🔍 Buscando preço para ${uf}...`);

    try {
      await page.goto(url, { waitUntil: 'networkidle2', timeout: 60000 });

      try {
        await page.waitForSelector('#onetrust-accept-btn-handler', { timeout: 5000 });
        await page.click('#onetrust-accept-btn-handler');
        console.log(`🍪 ${uf}: Cookies aceitos`);
      } catch {}

      try {
        await page.waitForSelector('#botao-finalizador', { timeout: 10000 });
        await page.click('#botao-finalizador');
      } catch {
        console.log(`❌ ${uf}: Botão "Ver formação de preço" não encontrado`);
        resultados[uf] = "Erro";
        await page.close();
        continue;
      }

      await page.waitForSelector('#telafinal-precofinal', { timeout: 15000 });

      const preco = await page.$eval('#telafinal-precofinal', el => el.textContent.trim());

      resultados[uf] = parseFloat(preco.replace(',', '.'));
      console.log(`✅ ${uf}: Preço encontrado = ${resultados[uf]}`);
    } catch (err) {
      console.log(`❌ ${uf}: Erro ao capturar preço`);
      resultados[uf] = "Erro";
    }

    await page.close();
  }

  await browser.close();

  fs.writeFileSync('public/precos.json', JSON.stringify(resultados, null, 2), 'utf8');
  console.log('\n✅ Arquivo "precos.json" salvo com os resultados finais');
})();
