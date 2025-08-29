@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détail de l'historique de paiement</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Paiement ID : {{ $historique->paiement_id }}</h5>
            <p class="card-text">Véhicule ID : {{ $historique->vehicule_id }}</p>
            <p class="card-text">Montant : {{ number_format($historique->montant, 0, ',', ' ') }} GNF</p>
            <p class="card-text">Date paiement : {{ $historique->date_paiement }}</p>
            <p class="card-text">Statut : {{ $historique->statut }}</p>
            <p class="card-text">Action : {{ $historique->action }}</p>
            <p class="card-text">Date action : {{ $historique->date_action }}</p>
        </div>
    </div>
    <a href="{{ route('historiques_paiements.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection 