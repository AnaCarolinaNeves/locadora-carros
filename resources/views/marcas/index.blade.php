@extends('layouts.app')

@section('title', 'Marcas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Marcas</h1>

        <a href="{{ route('marcas.create') }}" class="btn btn-primary">
            Nova marca
        </a>
    </div>

    <form method="GET" action="{{ route('marcas.index') }}" class="row g-2 mb-3">
        <div class="col-sm-6 col-md-4">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                class="form-control"
                placeholder="Buscar por nome..."
            >
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-secondary">
                Buscar
            </button>
        </div>
        @if($search)
            <div class="col-auto">
                <a href="{{ route('marcas.index') }}" class="btn btn-link">
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
                        <th style="width: 180px;">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($marcas as $marca)
                        <tr>
                            <td>{{ $marca->id }}</td>
                            <td>{{ $marca->nome }}</td>
                            <td>
                                <a href="{{ route('marcas.edit', $marca) }}" class="btn btn-sm btn-outline-primary">
                                    Editar
                                </a>

                                <form action="{{ route('marcas.destroy', $marca) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Tem certeza que deseja excluir esta marca?');">
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
                            <td colspan="3" class="text-center py-3">
                                Nenhuma marca encontrada.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($marcas->hasPages())
                <div class="p-3">
                    {{ $marcas->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection