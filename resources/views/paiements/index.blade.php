@extends('layouts.app')

@section('body_class', 'vehicule-bg')

@section('content')
<video autoplay loop muted playsinline id="bg-video" style="position:fixed;top:0;left:0;width:100vw;height:100vh;object-fit:cover;z-index:-1;">
    <source src="{{ asset('images/fondpaiement.mp4') }}" type="video/mp4">
    Votre navigateur ne supporte pas la vidéo HTML5.
</video>
<div class="container">
    <h1>Liste des paiements</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ url('/dashboard') }}" class="btn btn-secondary mb-3">Retour au dashboard</a>
    <a href="{{ route('paiements.create') }}" class="btn btn-primary mb-3">Ajouter un paiement</a>
    <form method="GET" action="" class="row g-3 mb-3">
        <div class="col-auto">
            <input type="text" name="vehicule_id" class="form-control" placeholder="ID véhicule" value="{{ request('vehicule_id') }}">
        </div>
        <div class="col-auto">
            <input type="text" name="plaque" class="form-control" placeholder="Plaque" value="{{ request('plaque') }}">
        </div>
        <div class="col-auto">
            <select name="mois" class="form-control">
                <option value="">-- Tous les mois --</option>
                @foreach($mois_disponibles as $m)
                    <option value="{{ $m }}" @if(isset($mois) && $mois == $m) selected @endif>{{ \Carbon\Carbon::parse($m.'-01')->translatedFormat('F Y') }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary">Filtrer</button>
        </div>
        <div class="col-auto">
            <a href="{{ route('paiements.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
        </div>
    </form>
    @if($totaux_par_mois && count($totaux_par_mois))
        <div class="mb-3">
            <h5>Totaux par mois</h5>
            <table class="table table-sm table-bordered" style="max-width:400px;">
                <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Total (GNF)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($totaux_par_mois as $mois_key => $total)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($mois_key.'-01')->translatedFormat('F Y') }}</td>
                            <td>{{ number_format($total, 0, ',', ' ') }} GNF</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div class="table-blur" style="position:relative;">
        <div style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:0;background:rgba(255,255,255,0.18);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);border-radius:12px;"></div>
        <table class="table table-bordered table-overlay" style="position:relative;z-index:1;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Véhicule</th>
                    <th>Montant</th>
                    <th>Date paiement</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paiements as $paiement)
                    <tr>
                        <td>{{ $paiement->id }}</td>
                        <td>{{ $paiement->vehicule_id }}</td>
                        <td>{{ $paiement->montant }}</td>
                        <td>{{ $paiement->date_paiement }}</td>
                        <td>{{ $paiement->statut }}</td>
                        <td>
                            <a href="{{ route('paiements.show', $paiement) }}" class="btn btn-info btn-sm">Voir</a>
                            <a href="{{ route('paiements.edit', $paiement) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('paiements.destroy', $paiement) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce paiement ?')">Supprimer</button>
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
        background: none !important;
    }
    .main-card {
        background: rgba(255,255,255,0.25) !important;
        backdrop-filter: blur(6px) !important;
        border-radius: 20px !important;
        box-shadow: 0 4px 24px rgba(0,0,0,0.12) !important;
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
    th, td {
        border: none !important;
        background: transparent !important;
        color: #222 !important;
        font-size: 1.08rem;
        text-shadow: none !important;
    }
    tbody tr, tbody tr:nth-child(even), tbody tr:nth-child(odd) {
        background: transparent !important;
    }
    thead th {
        font-weight: bold;
        color: #000 !important;
        text-shadow: none !important;
    }
    .table-overlay {
        background: transparent !important;
    }
</style>
@endsection 