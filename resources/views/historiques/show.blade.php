@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de l'historique</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Véhicule ID : {{ $historique->vehicule_id }}</h5>
            <p class="card-text">Type : {{ $historique->type }}</p>
            <p class="card-text">Plaque : {{ $historique->plaque }}</p>
            <p class="card-text">Date entrée : {{ $historique->date_entree }}</p>
            <p class="card-text">Date sortie : {{ $historique->date_sortie }}</p>
            <p class="card-text">Action : {{ $historique->action }}</p>
            <p class="card-text">Date action : {{ $historique->date_action }}</p>
        </div>
    </div>
    <a href="{{ route('historiques.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection 