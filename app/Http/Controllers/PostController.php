<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->email === 'bababa@ba.com') {
                return $next($request);
            }
            abort(403, 'Acesso não autorizado.');
        })->only(['create', 'store', 'edit', 'update', 'destroy', 'importarJsonParaMongo', 'showPrecosJson']);
    }

    public function index()
    {
        $posts = Post::all();
        return view('posts.show', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $data['preco'] = floatval(str_replace(',', '.', $data['preco']));

            $post = new Post;
            $post->titulo = $data['titulo'];
            $post->estado = $data['estado'];
            $post->preco = $data['preco'];
            $post->status = 1;
            $post->save();

            return redirect('/posts')->with('success_message', 'Você adicionou um novo valor com sucesso');
        }
    }

    public function edit(Post $post)
    {
        $postDetails = Post::find($post['id']);
        return view('posts.edit')->with(compact('postDetails'));
    }

    public function update(Request $request, Post $post)
    {
        if ($request->isMethod('put')) {
            $data = $request->all();
            $data['preco'] = floatval(str_replace(',', '.', $data['preco']));

            Post::where('_id', $post->_id)->update([
                'titulo' => $data['titulo'],
                'estado' => $data['estado'],
                'preco'  => $data['preco'],
            ]);

            return redirect('/posts')->with('success_message', 'Você alterou os valores com sucesso');
        }
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->with('success_message', 'Registro excluído com sucesso.');
    }

    public function showPrecosJson()
    {
        $jsonPath = public_path('precos.json');

        if (!file_exists($jsonPath)) {
            return back()->with('error_message', 'Arquivo de preços não encontrado.');
        }

        $dados = json_decode(file_get_contents($jsonPath), true);

        $posts = [];

        foreach ($dados as $estado => $preco) {
            $posts[] = [
                '_id' => $estado,
                'titulo' => 'Preço Médio',
                'estado' => $estado,
                'preco' => $preco
            ];
        }

        return view('posts.show', compact('posts'));
    }

    public function importarJsonParaMongo()
    {
        $jsonPath = public_path('precos.json');

        if (!File::exists($jsonPath)) {
            return back()->with('error_message', 'Arquivo de preços não encontrado.');
        }

        $dados = json_decode(file_get_contents($jsonPath), true);

        foreach ($dados as $estado => $preco) {
            Post::updateOrCreate(
                ['estado' => $estado],
                [
                    'titulo' => 'Preço Médio',
                    'preco' => floatval(str_replace(',', '.', $preco)),
                    'status' => 1
                ]
            );
        }

        return redirect('/posts')->with('success_message', 'Dados do JSON importados para o banco com sucesso.');
    }
}
