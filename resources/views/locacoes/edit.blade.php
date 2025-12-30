@extends('layouts.app')

@section('title', 'Editar locação')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Editar locação</h1>

        <a href="{{ route('locacoes.index') }}" class="btn btn-outline-secondary">
            Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('locacoes.update', $locacao->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="cliente_id" class="form-label">Cliente</label>
                    <select
                        id="cliente_id"
                        name="cliente_id"
                        class="form-select @error('cliente_id') is-invalid @enderror"
                        required
                    >
                        <option value="">Selecione um cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}"
                                {{ old('cliente_id', $locacao->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nome }} ({{ $cliente->documento }})
                            </option>
                        @endforeach
                    </select>
                    @error('cliente_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="carro_id" class="form-label">Carro</label>
                    <select
                        id="carro_id"
                        name="carro_id"
                        class="form-select @error('carro_id') is-invalid @enderror"
                        required
                    >
                        <option value="">Selecione um carro</option>
                        @foreach($carros as $carro)
                            <option value="{{ $carro->id }}"
                                {{ old('carro_id', $locacao->carro_id) == $carro->id ? 'selected' : '' }}>
                                {{ $carro->placa }} - {{ $carro->modelo->marca->nome }} {{ $carro->modelo->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('carro_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="data_retirada" class="form-label">Data de retirada</label>
                        <input
                            type="date"
                            id="data_retirada"
                            name="data_retirada"
                            value="{{ old('data_retirada', optional($locacao->data_retirada)->format('Y-m-d')) }}"
                            class="form-control @error('data_retirada') is-invalid @enderror"
                            required
                        >
                        @error('data_retirada')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="data_devolucao_prevista" class="form-label">Data de devolução</label>
                        <input
                            type="date"
                            id="data_devolucao_prevista"
                            name="data_devolucao_prevista"
                            value="{{ old('data_devolucao_prevista', optional($locacao->data_devolucao_prevista)->format('Y-m-d')) }}"
                            class="form-control @error('data_devolucao_prevista') is-invalid @enderror"
                            required
                        >
                        @error('data_devolucao_prevista')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="valor_diaria" class="form-label">Valor da diária (R$)</label>
                        <input
                            type="number"
                            step="0.01"
                            id="valor_diaria"
                            name="valor_diaria"
                            value="{{ old('valor_diaria', $locacao->valor_diaria) }}"
                            class="form-control @error('valor_diaria') is-invalid @enderror"
                            required
                        >
                        @error('valor_diaria')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Valor total (calculado)</label>
                        <p class="form-control-plaintext">
                            R$ {{ number_format($locacao->valor_total ?? 0, 2, ',', '.') }}
                        </p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select
                            id="status"
                            name="status"
                            class="form-select @error('status') is-invalid @enderror"
                            required
                        >
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('status', $locacao->status) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    Atualizar
                </button>
            </form>
        </div>
    </div>
@endsection