@extends('layouts.app')

@section('title', 'Carros')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Carros</h1>

        <a href="{{ route('carros.create') }}" class="btn btn-primary">
            Novo carro
        </a>
    </div>

    <form method="GET" action="{{ route('carros.index') }}" class="row g-2 mb-3">
        <div class="col-sm-6 col-md-3">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                class="form-control"
                placeholder="Buscar por placa..."
            >
        </div>

        <div class="col-sm-6 col-md-3">
            <select name="modelo_id" class="form-select">
                <option value="">Todos os modelos</option>
                @foreach($modelos as $modelo)
                    <option value="{{ $modelo->id }}" {{ $modeloId == $modelo->id ? 'selected' : '' }}>
                        {{ $modelo->marca->nome }} - {{ $modelo->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-6 col-md-3">
            <select name="status" class="form-select">
                <option value="">Todos os status</option>
                @foreach($statusOptions as $value => $label)
                    <option value="{{ $value }}" {{ $status === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-outline-secondary">
                Filtrar
            </button>
        </div>

        @if($search || $modeloId || $status)
            <div class="col-auto">
                <a href="{{ route('carros.index') }}" class="btn btn-link">
                    Limpar
                </a>
            </div>
        @endif
    </form>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Cor</th>
                        <th>KM</th>
                        <th>Status</th>
                        <th style="width: 200px;">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($carros as $carro)
                        <tr>
                            <td>{{ $carro->id }}</td>
                            <td>{{ $carro->placa }}</td>
                            <td>{{ $carro->modelo->nome }}</td>
                            <td>{{ $carro->modelo->marca->nome }}</td>
                            <td>{{ $carro->cor }}</td>
                            <td>{{ $carro->km }}</td>
                            <td>
                                @php
                                    $label = $statusOptions[$carro->status] ?? $carro->status;
                                @endphp
                                <span class="badge
                                    @if($carro->status === 'disponivel') bg-success
                                    @elseif($carro->status === 'alugado') bg-warning text-dark
                                    @else bg-secondary
                                    @endif">
                                    {{ $label }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('carros.edit', $carro) }}" class="btn btn-sm btn-outline-primary">
                                    Editar
                                </a>

                                <form action="{{ route('carros.destroy', $carro) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Tem certeza que deseja excluir este carro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3">
                                Nenhum carro encontrado.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($carros->hasPages())
                <div class="p-3">
                    {{ $carros->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection