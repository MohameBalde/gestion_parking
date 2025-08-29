@extends('layouts.app')

@section('body_class', 'vehicule-bg')

@section('content')
<video autoplay loop muted playsinline id="bg-video" style="position:fixed;top:0;left:0;width:100vw;height:100vh;object-fit:cover;z-index:-1;">
    <source src="{{ asset('images/fondhistvehicule.mp4') }}" type="video/mp4">
    Votre navigateur ne supporte pas la vidéo HTML5.
</video>
<div class="container">
    <a href="{{ url('/dashboard') }}" class="btn btn-secondary mb-3">Retour au dashboard</a>
    <h1>Historique des véhicules</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="GET" action="" class="row g-3 mb-3">
        <div class="col-auto">
            <input type="text" name="vehicule_id" class="form-control" placeholder="ID véhicule" value="{{ request('vehicule_id') }}">
        </div>
        <div class="col-auto">
            <input type="text" name="plaque" class="form-control" placeholder="Plaque" value="{{ request('plaque') }}">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary">Filtrer</button>
        </div>
        <div class="col-auto">
            <a href="{{ route('historiques.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
        </div>
    </form>
    <div class="table-blur" style="position:relative;">
        <div style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:0;background:rgba(255,255,255,0.18);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);border-radius:12px;"></div>
        <table class="table table-bordered table-overlay" style="position:relative;z-index:1;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Véhicule</th>
                    <th>Type</th>
                    <th>Plaque</th>
                    <th>Date entrée</th>
                    <th>Date sortie</th>
                    <th>Action</th>
                    <th>Date action</th>
                    <th>Voir</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historiques as $histo)
                    <tr>
                        <td>{{ $histo->id }}</td>
                        <td>{{ $histo->vehicule_id }}</td>
                        <td>{{ $histo->type }}</td>
                        <td>{{ $histo->plaque }}</td>
                        <td>{{ $histo->date_entree }}</td>
                        <td>{{ $histo->date_sortie }}</td>
                        <td>{{ $histo->action }}</td>
                        <td>{{ $histo->date_action }}</td>
                        <td><a href="{{ route('historiques.show', $histo) }}" class="btn btn-info btn-sm">Voir</a></td>
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
        background: none !important;
    }
    .main-card {
        background: rgba(255,255,255,0.85) !important;
        backdrop-filter: blur(6px) !important;
        border-radius: 20px !important;
        box-shadow: 0 4px 24px rgba(0,0,0,0.12) !important;
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