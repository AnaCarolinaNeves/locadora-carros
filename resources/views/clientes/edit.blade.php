@extends('layouts.app')

@section('title', 'Editar cliente')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Editar cliente</h1>

        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
            Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('clientes.update', $cliente) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="{{ old('nome', $cliente->nome) }}"
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
                    <label for="documento" class="form-label">Documento (CPF)</label>
                    <input
                        type="text"
                        id="documento"
                        name="documento"
                        value="{{ old('documento', $cliente->documento) }}"
                        class="form-control @error('documento') is-invalid @enderror"
                        required
                    >
                    @error('documento')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $cliente->email) }}"
                        class="form-control @error('email') is-invalid @enderror"
                    >
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input
                        type="text"
                        id="telefone"
                        name="telefone"
                        value="{{ old('telefone', $cliente->telefone) }}"
                        class="form-control @error('telefone') is-invalid @enderror"
                    >
                    @error('telefone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Atualizar
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#documento').mask('000.000.000-00', {reverse: true}); // CPF simples
        $('#telefone').mask('(00) 00000-0000');
    });
</script>
@endpush