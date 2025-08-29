@extends('layouts.app')

@section('body_class', 'vehicule-bg')

@section('content')
<div class="container">
    <h1>Détails du véhicule</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Type : {{ $vehicule->type }}</h5>
            <p class="card-text">Plaque : {{ $vehicule->plaque }}</p>
            <p class="card-text">Date entrée : {{ $vehicule->date_entree }}</p>
            <p class="card-text">Statut paiement : {{ $vehicule->statut_paiement }}</p>
        </div>
    </div>
    <a href="{{ route('vehicules.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection

@section('styles')
<style>
    body.vehicule-bg {
        background: url('{{ asset('images/fondvehicule.png') }}') no-repeat center center fixed !important;
        background-size: cover !important;
    }
</style>
@endsection 