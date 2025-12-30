@extends('layouts.app')

@section('title', 'Novo carro')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Novo carro</h1>

        <a href="{{ route('carros.index') }}" class="btn btn-outline-secondary">
            Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('carros.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="modelo_id" class="form-label">Modelo</label>
                    <select
                        id="modelo_id"
                        name="modelo_id"
                        class="form-select @error('modelo_id') is-invalid @enderror"
                        required
                    >
                        <option value="">Selecione um modelo</option>
                        @foreach($modelos as $modelo)
                            <option value="{{ $modelo->id }}" {{ old('modelo_id') == $modelo->id ? 'selected' : '' }}>
                                {{ $modelo->marca->nome }} - {{ $modelo->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('modelo_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="placa" class="form-label">Placa</label>
                    <input
                        type="text"
                        id="placa"
                        name="placa"
                        value="{{ old('placa') }}"
                        class="form-control @error('placa') is-invalid @enderror"
                        required
                    >
                    @error('placa')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cor" class="form-label">Cor</label>
                    <input
                        type="text"
                        id="cor"
                        name="cor"
                        value="{{ old('cor') }}"
                        class="form-control @error('cor') is-invalid @enderror"
                    >
                    @error('cor')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="km" class="form-label">Quilometragem</label>
                    <input
                        type="number"
                        id="km"
                        name="km"
                        value="{{ old('km') }}"
                        class="form-control @error('km') is-invalid @enderror"
                        min="0"
                    >
                    @error('km')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select
                        id="status"
                        name="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required
                    >
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('status', 'disponivel') == $value ? 'selected' : '' }}>
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

                <button type="submit" class="btn btn-primary">
                    Salvar
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#placa').mask('SSS-0000', {
            'translation': {
                S: { pattern: /[A-Za-z]/ },
            },
            onKeyPress: function (value, e, field, options) {
                field.val(value.toUpperCase());
            }
        });
    });
</script>
@endpush