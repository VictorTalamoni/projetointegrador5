@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar preço') }}</div>
                <div class="card-body">
                @if(Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Boa!</strong> {!!session('success_message')!!}
                </div>
                @endif
                    <form method="POST" action="{{ route('posts.update', $postDetails['_id']) }}">
                        @csrf
                        @if(isset($postDetails['_id']))
                        @method('PUT')
                        @endif

                        <div class="row mb-3">
                            <label for="titulo" class="col-md-4 col-form-label text-md-end">{{ __('titulo') }}</label>

                            <div class="col-md-6">
                                <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" value="{{ $postDetails['titulo'] }}" required autocomplete="titulo" autofocus>

                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="estado" class="col-md-4 col-form-label text-md-end">{{ __('estado') }}</label>

                            <div class="col-md-6">
                                <input id="estado" type="text" class="form-control @error('estado') is-invalid @enderror" name="estado" value="{{ $postDetails['estado'] }}" required autocomplete="estado">

                                @error('estado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="preco" class="col-md-4 col-form-label text-md-end">{{ __('preco') }}</label>

                            <div class="col-md-6">
                            <input id="preco" type="number" class="form-control @error('preco') is-invalid @enderror" name="preco" value="{{ $postDetails['preco'] }}" required autocomplete="new-preco">
                                @error('preco')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enviar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
