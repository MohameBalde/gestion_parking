@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le paiement</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('paiements.update', $paiement) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="vehicule_id" class="form-label">ID Véhicule</label>
            <input type="number" name="vehicule_id" class="form-control" value="{{ $paiement->vehicule_id }}" required>
        </div>
        <div class="mb-3">
            <label for="montant" class="form-label">Montant</label>
            <input type="number" step="0.01" name="montant" class="form-control" value="{{ $paiement->montant }}" required>
        </div>
        <div class="mb-3">
            <label for="date_paiement" class="form-label">Date paiement</label>
            <input type="datetime-local" name="date_paiement" class="form-control" value="{{ Carbon\Carbon::parse($paiement->date_paiement)->format('Y-m-d\TH:i') }}" required>
        </div>
        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" class="form-control" required>
                <option value="payé" @if($paiement->statut == 'payé') selected @endif>Payé</option>
                <option value="non payé" @if($paiement->statut == 'non payé') selected @endif>Non payé</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('paiements.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection 