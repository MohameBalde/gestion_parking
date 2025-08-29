@extends('layouts.app')

@section('body_class', 'vehicule-bg')

@section('content')
<div class="container">
    <h1>Modifier le véhicule</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('vehicules.update', $vehicule) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" name="type" class="form-control" value="{{ $vehicule->type }}" required>
        </div>
        <div class="mb-3">
            <label for="plaque" class="form-label">Plaque</label>
            <input type="text" name="plaque" class="form-control" value="{{ $vehicule->plaque }}" required>
        </div>
        <div class="mb-3">
            <label for="date_entree" class="form-label">Date entrée</label>
            <input type="date" name="date_entree" class="form-control" value="{{ $vehicule->date_entree }}">
        </div>
        <div class="mb-3">
            <label for="statut_paiement" class="form-label">Statut paiement</label>
            <select name="statut_paiement" class="form-control" required>
                <option value="payé" @if($vehicule->statut_paiement == 'payé') selected @endif>Payé</option>
                <option value="non payé" @if($vehicule->statut_paiement == 'non payé') selected @endif>Non payé</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('vehicules.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
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
 