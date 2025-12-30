@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="h3 mb-4">Dashboard</h1>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="card-title text-muted">Marcas</h6>
                    <p class="display-6 mb-0">{{ $totalMarcas }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="card-title text-muted">Modelos</h6>
                    <p class="display-6 mb-0">{{ $totalModelos }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="card-title text-muted">Carros</h6>
                    <p class="display-6 mb-0">{{ $totalCarros }}</p>
                    <small class="text-muted">
                        Disponíveis: {{ $carrosDisp }}
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="card-title text-muted">Clientes</h6>
                    <p class="display-6 mb-0">{{ $totalClientes }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="card-title text-muted">Locações abertas</h6>
                    <p class="display-6 mb-0">{{ $locacoesAbertas }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="card-title text-muted">Locações finalizadas</h6>
                    <p class="display-6 mb-0">{{ $locacoesFinalizadas }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-secondary">
                <div class="card-body">
                    <h6 class="card-title text-muted">Locações canceladas</h6>
                    <p class="display-6 mb-0">{{ $locacoesCanceladas }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-info">
        <div class="card-body">
            <h6 class="card-title text-muted">Faturamento total (locações finalizadas)</h6>
            <p class="display-5 mb-0">
                R$ {{ number_format($faturamentoTotal ?? 0, 2, ',', '.') }}
            </p>
        </div>
    </div>
@endsection