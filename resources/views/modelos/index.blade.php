@extends('layouts.app')

@section('title', 'Modelos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Modelos</h1>

        <a href="{{ route('modelos.create') }}" class="btn btn-primary">
            Novo modelo
        </a>
    </div>

    <form method="GET" action="{{ route('modelos.index') }}" class="row g-2 mb-3">
        <div class="col-sm-6 col-md-3">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                class="form-control"
                placeholder="Buscar por nome..."
            >
        </div>

        <div class="col-sm-6 col-md-3">
            <select name="marca_id" class="form-select">
                <option value="">Todas as marcas</option>
                @foreach($marcas as $marca)
                    <option value="{{ $marca->id }}" {{ $marcaId == $marca->id ? 'selected' : '' }}>
                        {{ $marca->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-outline-secondary">
                Filtrar
            </button>
        </div>

        @if($search || $marcaId)
            <div class="col-auto">
                <a href="{{ route('modelos.index') }}" class="btn btn-link">
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
                        <th>Nome</th>
                        <th>Marca</th>
                        <th style="width: 100px;">Ano</th>
                        <th style="width: 180px;">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($modelos as $modelo)
                        <tr>
                            <td>{{ $modelo->id }}</td>
                            <td>{{ $modelo->nome }}</td>
                            <td>{{ $modelo->marca->nome }}</td>
                            <td>{{ $modelo->ano }}</td>
                            <td>
                                <a href="{{ route('modelos.edit', $modelo) }}" class="btn btn-sm btn-outline-primary">
                                    Editar
                                </a>

                                <form action="{{ route('modelos.destroy', $modelo) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Tem certeza que deseja excluir este modelo?');">
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
                            <td colspan="5" class="text-center py-3">
                                Nenhum modelo encontrado.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($modelos->hasPages())
                <div class="p-3">
                    {{ $modelos->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection