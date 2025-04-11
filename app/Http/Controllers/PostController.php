<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.show', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
    
            $post = new Post;
            $post->titulo = $data['titulo'];
            $post->estado = $data['estado'];
            $post->preco = $data['preco'];
            $post->status = 1;
            $post->save();
    
            return redirect('/posts')->with('success_message', 'Você adicionou um novo valor com sucesso');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $postDetails = Post::find($post['id']);
        return view('posts.edit')->with(compact('postDetails'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($request->isMethod('put')) {
            $data = $request->all();
    
            Post::where('_id', $post->_id)->update([
                'titulo' => $data['titulo'],
                'estado' => $data['estado'],
                'preco'  => $data['preco'],
            ]);
    
            return redirect('/posts')->with('success_message', 'Você alterou os valores com sucesso');
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
    
        return redirect()->back()->with('success_message', 'Registro excluído com sucesso.');
    }
    
}
