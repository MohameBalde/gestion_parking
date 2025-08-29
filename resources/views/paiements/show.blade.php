@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détail du paiement</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ID : {{ $paiement->id }}</h5>
            <p class="card-text"><strong>Véhicule ID :</strong> {{ $paiement->vehicule_id }}</p>
            <p class="card-text"><strong>Montant :</strong> {{ number_format($paiement->montant, 0, ',', ' ') }} GNF</p>
            <p class="card-text"><strong>Date paiement :</strong> {{ $paiement->date_paiement }}</p>
            <p class="card-text"><strong>Statut :</strong> {{ $paiement->statut }}</p>
        </div>
    </div>
    <a href="{{ route('paiements.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection 