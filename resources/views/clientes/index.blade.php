@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Clientes</h1>

        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            Novo cliente
        </a>
    </div>

    <form method="GET" action="{{ route('clientes.index') }}" class="row g-2 mb-3">
        <div class="col-sm-6 col-md-4">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                class="form-control"
                placeholder="Buscar por nome ou documento..."
            >
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-secondary">
                Buscar
            </button>
        </div>
        @if($search)
            <div class="col-auto">
                <a href="{{ route('clientes.index') }}" class="btn btn-link">
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
                        <th>Documento</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th style="width: 180px;">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td>{{ $cliente->nome }}</td>
                            <td>{{ $cliente->documento }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ $cliente->telefone }}</td>
                            <td>
                                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-outline-primary">
                                    Editar
                                </a>

                                <form action="{{ route('clientes.destroy', $cliente) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
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
                            <td colspan="6" class="text-center py-3">
                                Nenhum cliente encontrado.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($clientes->hasPages())
                <div class="p-3">
                    {{ $clientes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection