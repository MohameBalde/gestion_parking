@extends('layouts.app')

@section('content')
<style>
    .dashboard-bg {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        width: 100vw;
        height: 100vh;
        z-index: 0;
        background: url('{{ asset('images/img.png') }}') no-repeat center center fixed;
        background-size: cover;
        pointer-events: none;
    }
    .dashboard-card {
        background: rgba(255,255,255,0.4);
        backdrop-filter: blur(4px);
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.12);
        padding: 40px 32px;
        margin-top: 40px;
        max-width: 520px;
        z-index: 1;
        position: relative;
    }
    .dashboard-logo {
        width: 90px;
        height: 90px;
        object-fit: contain;
        margin-bottom: 18px;
    }
    .dashboard-title {
        font-size: 2.2rem;
        font-weight: bold;
        color: #1a202c;
        margin-bottom: 10px;
    }
    .dashboard-welcome {
        font-size: 1.1rem;
        color: #4a5568;
        margin-bottom: 24px;
    }
    .dashboard-links {
        display: flex;
        flex-direction: column;
        gap: 14px;
        align-items: center;
        margin-bottom: 18px;
    }
    .dashboard-links a {
        min-width: 220px;
        font-size: 1.08rem;
        padding: 10px 0;
        border-radius: 8px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(106,17,203,0.07);
    }
    @media (max-width: 600px) {
        .dashboard-card { padding: 18px 4vw; }
        .dashboard-links a { min-width: 90vw; }
    }
    .dashboard-tip {
        color: #222;
        font-size: 1rem;
        margin-top: 18px;
        text-align: left;
    }
    .dashboard-tip strong {
        color: #2575fc;
        font-weight: bold;
    }
</style>
<div class="dashboard-bg"></div>
<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 100vh; position: relative; z-index: 1; display: flex; justify-content: center; align-items: center;">
    <div class="dashboard-card text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="dashboard-logo">
        <div class="dashboard-title">Gestion du Parking</div>
        <div class="dashboard-welcome">Bienvenue, {{ Auth::user()->name ?? Auth::user()->username ?? 'Utilisateur' }} !</div>
        <div class="dashboard-links">
            <a href="{{ route('vehicules.index') }}" class="btn btn-primary">Gérer les véhicules</a>
            <a href="{{ route('paiements.index') }}" class="btn btn-success">Gérer les paiements</a>
            <a href="{{ route('historiques.index') }}" class="btn btn-warning text-dark">Historique des véhicules</a>
            <a href="{{ route('historiques_paiements.index') }}" class="btn btn-info text-dark">Historique des paiements</a>
        </div>
        <hr>
        <div class="dashboard-tip">
            <strong>Astuce :</strong> Utilisez le menu ci-dessus pour accéder rapidement à la gestion et à l'historique de votre parking.<br>
            Pour toute question, contactez l'administrateur.
        </div>
    </div>
</div>
@endsection
