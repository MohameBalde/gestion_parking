@extends('layouts.app')

@section('body_class', 'vehicule-bg')

@section('content')
<div class="container">
    <h1>Liste des véhicules</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ url('/dashboard') }}" class="btn btn-secondary mb-3">Retour au dashboard</a>
    <a href="{{ route('vehicules.create') }}" class="btn btn-primary mb-3">Ajouter un véhicule</a>
    <form method="GET" action="" class="row g-3 mb-3">
        <div class="col-auto">
            <input type="text" name="id" class="form-control" placeholder="ID véhicule" value="{{ request('id') }}">
        </div>
        <div class="col-auto">
            <input type="text" name="plaque" class="form-control" placeholder="Plaque" value="{{ request('plaque') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary">Filtrer</button>
        </div>
        <div class="col-auto">
            <a href="{{ route('vehicules.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
        </div>
    </form>
    <div class="table-blur" style="position:relative;">
        <div style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:0;background:rgba(255,255,255,0.18);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);border-radius:12px;"></div>
        <table class="table table-bordered table-overlay" style="position:relative;z-index:1;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Plaque</th>
                    <th>Date entrée</th>
                    <th>Statut paiement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehicules as $vehicule)
                    <tr>
                        <td>{{ $vehicule->id }}</td>
                        <td>{{ $vehicule->type }}</td>
                        <td>{{ $vehicule->plaque }}</td>
                        <td>{{ $vehicule->date_entree }}</td>
                        <td>{{ $vehicule->statut_paiement }}</td>
                        <td>
                            <a href="{{ route('vehicules.show', $vehicule) }}" class="btn btn-info btn-sm">Voir</a>
                            <a href="{{ route('vehicules.edit', $vehicule) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('vehicules.destroy', $vehicule) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce véhicule ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('styles')
<style>
    body.vehicule-bg {
        background: url('{{ asset('images/fondvehicule1.png') }}') no-repeat center center fixed !important;
        background-size: cover !important;
    }
    .main-card {
        background: transparent !important;
        backdrop-filter: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
    }
    .table-blur table,
    .table-blur tbody tr,
    .table-blur tbody tr:nth-child(even),
    .table-blur tbody tr:nth-child(odd),
    .table-blur tbody tr:hover {
        background: transparent !important;
    }
    th, td {
        border: none !important;
        background: transparent !important;
        color: #222 !important;
        font-size: 1.08rem;
        text-shadow: none !important;
    }
    thead th {
        font-weight: bold;
        color: #000 !important;
        text-shadow: none !important;
    }
    .table-overlay {
        background: transparent !important;
    }
    a.btn.btn-outline-secondary {
        background: #e2e8f0;
        color: #222;
        border: 1px solid #bfc9d9;
        font-weight: 600;
        transition: background 0.2s, color 0.2s;
    }
    a.btn.btn-outline-secondary:hover, a.btn.btn-outline-secondary:focus {
        background: #6a11cb;
        color: #fff;
        border: 1px solid #6a11cb;
    }
</style>
@endsection 