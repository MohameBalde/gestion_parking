@extends('layouts.app')

@section('body_class', 'vehicule-bg')

@section('content')
<div class="container">
    <h1>Ajouter un véhicule</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('vehicules.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" name="type" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="plaque" class="form-label">Plaque</label>
            <input type="text" name="plaque" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="date_entree" class="form-label">Date entrée</label>
            <input type="date" name="date_entree" class="form-control">
        </div>
        <div class="mb-3">
            <label for="statut_paiement" class="form-label">Statut paiement</label>
            <select name="statut_paiement" class="form-control" required>
                <option value="payé">Payé</option>
                <option value="non payé">Non payé</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
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