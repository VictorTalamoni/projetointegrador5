<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class GasolinaController extends Controller
{
    public function getPrecos()
    {
        $estados = ['AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA',
                    'MG', 'MS', 'MT', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN',
                    'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO'];

        $valores = [];
        $client = new Client();

        foreach ($estados as $uf) {
            $url = "https://precos.petrobras.com.br/w/gasolina/" . strtolower($uf);

            try {
                $html = $client->get($url)->getBody()->getContents();
                $crawler = new Crawler($html);

                // Localiza a div e o SEGUNDO <h3> dentro dela
                $preco = $crawler->filter('div.texto-comb h3')->eq(1)->text();

                // Formata
                $preco = trim(str_replace(',', '.', $preco));
                $valores[$uf] = $preco;

            } catch (\Exception $e) {
                $valores[$uf] = 'Erro';
            }
        }

        return response()->json($valores);
    }
}
