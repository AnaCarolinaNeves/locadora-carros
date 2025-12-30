<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Locadora de Carros - @yield('title', 'Painel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 via CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    />

    <style>
        body {
            min-height: 100vh;
        }

        .sidebar {
            min-width: 220px;
            max-width: 220px;
        }

        .content-wrapper {
            flex: 1;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            Locadora de Carros
        </a>

        <div class="d-flex">
            <span class="navbar-text text-white">
                Painel
            </span>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        {{-- Sidebar --}}
        <aside class="col-md-3 col-lg-2 d-md-block bg-white border-end sidebar py-3">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('marcas.*') ? 'active' : '' }}"
                       href="{{ route('marcas.index') }}">
                        <i class="bi bi-tags me-1"></i> Marcas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('modelos.*') ? 'active' : '' }}"
                       href="{{ route('modelos.index') }}">
                        <i class="bi bi-car-front me-1"></i> Modelos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('carros.*') ? 'active' : '' }}"
                       href="{{ route('carros.index') }}">
                        <i class="bi bi-truck-front me-1"></i> Carros
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}"
                       href="{{ route('clientes.index') }}">
                        <i class="bi bi-people me-1"></i> Clientes
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('locacoes.*') ? 'active' : '' }}"
                       href="{{ route('locacoes.index') }}">
                        <i class="bi bi-receipt me-1"></i> Locações
                    </a>
                </li>
            </ul>
        </aside>

        {{-- Conteúdo principal --}}
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content-wrapper py-4">
            {{-- Mensagens flash globais --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

@stack('scripts')
</body>
</html>