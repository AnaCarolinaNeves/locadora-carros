@extends('layouts.app')

@section('title', 'Nova marca')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Nova marca</h1>

        <a href="{{ route('marcas.index') }}" class="btn btn-outline-secondary">
            Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('marcas.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome da marca</label>
                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="{{ old('nome') }}"
                        class="form-control @error('nome') is-invalid @enderror"
                        required
                    >
                    @error('nome')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Salvar
                </button>
            </form>
        </div>
    </div>
@endsection