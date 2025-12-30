@extends('layouts.app')

@section('title', 'Locações')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Locações</h1>

        <a href="{{ route('locacoes.create') }}" class="btn btn-primary">
            Nova locação
        </a>
    </div>

    <form method="GET" action="{{ route('locacoes.index') }}" class="row g-2 mb-3">
        <div class="col-sm-6 col-md-4">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                class="form-control"
                placeholder="Buscar por cliente ou placa..."
            >
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

        @if($search || $status)
            <div class="col-auto">
                <a href="{{ route('locacoes.index') }}" class="btn btn-link">
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
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Carro</th>
                        <th>Retirada</th>
                        <th>Prevista</th>
                        <th>Status</th>
                        <th>Valor diária</th>
                        <th>Valor total</th>
                        <th style="width: 200px;">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($locacoes as $locacao)
                        <tr>
                            <td>{{ $locacao->id }}</td>
                            <td>{{ $locacao->cliente->nome }}</td>
                            <td>
                                {{ $locacao->carro->placa }}
                                -
                                {{ $locacao->carro->modelo->marca->nome }}
                                {{ $locacao->carro->modelo->nome }}
                            </td>
                            <td>{{ optional($locacao->data_retirada)->format('d/m/Y') }}</td>
                            <td>{{ optional($locacao->data_devolucao_prevista)->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $label = $statusOptions[$locacao->status] ?? $locacao->status;
                                @endphp
                                <span class="badge
                                    @if($locacao->status === 'aberta') bg-warning text-dark
                                    @elseif($locacao->status === 'finalizada') bg-success
                                    @else bg-secondary
                                    @endif">
                                    {{ $label }}
                                </span>
                            </td>
                            <td>R$ {{ number_format($locacao->valor_diaria, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($locacao->valor_total ?? 0, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('locacoes.edit', $locacao) }}" class="btn btn-sm btn-outline-primary mb-1">
                                    Editar
                                </a>

                                @if($locacao->status === 'aberta')
                                    <form action="{{ route('locacoes.concluir', $locacao->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Deseja concluir esta locação?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success mb-1">
                                            Concluir
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('locacoes.destroy', $locacao) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Tem certeza que deseja excluir esta locação?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger mb-1">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-3">
                                Nenhuma locação encontrada.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($locacoes->hasPages())
                <div class="p-3">
                    {{ $locacoes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection