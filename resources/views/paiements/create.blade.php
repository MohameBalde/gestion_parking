@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un paiement</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('paiements.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="vehicule_id" class="form-label">Véhicule (ID - Plaque)</label>
            <select name="vehicule_id" class="form-control" required>
                <option value="">-- Sélectionner un véhicule --</option>
                @foreach($vehicules as $vehicule)
                    <option value="{{ $vehicule->id }}">{{ $vehicule->id }} - {{ $vehicule->plaque }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="montant" class="form-label">Montant</label>
            <input type="number" step="0.01" name="montant" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="date_paiement" class="form-label">Date paiement</label>
            <input type="datetime-local" name="date_paiement" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" class="form-control" required>
                <option value="payé">Payé</option>
                <option value="non payé">Non payé</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="{{ route('paiements.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection 