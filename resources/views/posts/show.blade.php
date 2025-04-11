@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Preços') }}</div>
                <div class="card-body">
                @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Boa!</strong> {!! session('success_message') !!}
                    </div>
                @endif

                <!-- Botão para criar novo -->
                <a href="{{ route('posts.create') }}" class="btn btn-success mb-3">
                    Adicionar novo preço
                </a>

                <table id="posts" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Estado</th>
                            <th>Preço</th>
                            <th style="min-width: 150px;" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>{{ $post['titulo'] }}</td>
                            <td>{{ $post['estado'] }}</td>
                            <td>{{ $post['preco'] }}</td>
                            <td class="text-center">
                                <a href="{{ route('posts.edit', (string) $post['_id']) }}" class="btn btn-sm btn-primary me-1">
                                    Atualizar
                                </a>
                                <form action="{{ route('posts.destroy', (string) $post['_id']) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Tem certeza que deseja excluir este registro?')">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
