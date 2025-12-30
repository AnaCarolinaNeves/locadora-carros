@extends('layouts.app')

@section('title', 'Novo modelo')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Novo modelo</h1>

        <a href="{{ route('modelos.index') }}" class="btn btn-outline-secondary">
            Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('modelos.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="marca_id" class="form-label">Marca</label>
                    <select
                        id="marca_id"
                        name="marca_id"
                        class="form-select @error('marca_id') is-invalid @enderror"
                        required
                    >
                        <option value="">Selecione uma marca</option>
                        @foreach($marcas as $marca)
                            <option value="{{ $marca->id }}" {{ old('marca_id') == $marca->id ? 'selected' : '' }}>
                                {{ $marca->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('marca_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do modelo</label>
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

                <div class="mb-3">
                    <label for="ano" class="form-label">Ano (opcional)</label>
                    <input
                        type="number"
                        id="ano"
                        name="ano"
                        value="{{ old('ano') }}"
                        class="form-control @error('ano') is-invalid @enderror"
                    >
                    @error('ano')
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