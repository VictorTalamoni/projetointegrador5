@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Preços') }}</div>
                <div class="card-body">

                @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Boa!</strong> {!! session('success_message') !!}
                    </div>
                @endif

                <!-- Botões adicionais -->
                <div class="mb-3 d-flex justify-content-between">
                    <div>
                        @auth
                        @if(Auth::user()->email === 'bababa@ba.com')
                        <a href="{{ route('posts.importar') }}" class="btn btn-outline-success">
                            ⬇️ Importar JSON para MongoDB
                        </a>
                        @endif
                        @endauth
                    </div>

                    @auth
                    @if(Auth::user()->email === 'bababa@ba.com')
                        <a href="{{ route('posts.create') }}" class="btn btn-success">
                            + Adicionar novo preço
                        </a>
                    @endif
                    @endauth
                </div>

                <table id="posts" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Estado</th>
                            <th>Preço</th>
                            @auth
                            @if(Auth::user()->email === 'bababa@ba.com')
                            <th class="text-center" style="min-width: 150px;">Ações</th>
                            @endif
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>{{ $post['titulo'] }}</td>
                            <td>{{ $post['estado'] }}</td>
                            <td>R$ {{ number_format((float) $post['preco'], 2, ',', '.') }}</td>
                            @auth
                            @if(Auth::user()->email === 'bababa@ba.com')
                            <td class="text-center">
                                @if(isset($post['_id']))
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
                                @else
                                <span class="text-muted">--</span>
                                @endif
                            </td>
                            @endif
                            @endauth
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
