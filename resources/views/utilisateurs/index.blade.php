@extends('layouts.app')

@section('body_class', 'vehicule-bg')

@section('content')
<h1>Liste des utilisateurs</h1>
<a href="{{ url('/dashboard') }}" class="btn btn-secondary mb-3">Retour au dashboard</a>
<div class="table-blur" style="position:relative;">
    <div style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:0;background:rgba(255,255,255,0.18);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);border-radius:12px;"></div>
    <table class="table table-bordered table-overlay" style="position:relative;z-index:1;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Admin ?</th>
                <th>Validé ?</th>
                <th>Statut</th>
                <th>Actions</th>
                <th>Date de création</th>
            </tr>
        </thead>
        <tbody>
            @forelse($utilisateurs as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>@if($user->is_admin) <span style="color:green;font-weight:bold">Oui</span> @else Non @endif</td>
                    <td>
                        @if($user->is_approved)
                            <span style="color:green;font-weight:bold">Oui</span>
                        @else
                            <form method="POST" action="{{ route('utilisateurs.approve', $user->id) }}" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Valider ce compte ?')">Valider</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        @if($user->is_active)
                            <span style="color:green;font-weight:bold">Actif</span>
                        @else
                            <span style="color:red;font-weight:bold">Désactivé</span>
                        @endif
                    </td>
                    <td>
                        @if(!$user->is_approved)
                            <form method="POST" action="{{ route('utilisateurs.reject', $user->id) }}" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Refuser ce compte ?')">Refuser</button>
                            </form>
                        @endif
                        @if(auth()->user()->id !== $user->id)
                            <div class="dropdown" style="display:inline-block;">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $user->id }}">
                                    <li>
                                        <form method="POST" action="{{ route('utilisateurs.toggle_active', $user->id) }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item" onclick="return confirm('{{ $user->is_active ? 'Désactiver' : 'Réactiver' }} ce compte ?')">
                                                {{ $user->is_active ? 'Désactiver' : 'Réactiver' }}
                                            </button>
                                        </form>
                                    </li>
                                    @if(!($user->is_admin && auth()->user()->id === $user->id))
                                    <li>
                                        <form method="POST" action="{{ route('utilisateurs.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Supprimer ce compte ?')">Supprimer</button>
                                        </form>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                        <a href="{{ route('utilisateurs.activities', $user->id) }}" class="btn btn-info btn-sm" style="margin-top:4px;">Voir activités</a>
                    </td>
                    <td>{{ $user->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Aucun utilisateur trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('styles')
<style>
    body.vehicule-bg {
        background: url('{{ asset('images/fondusers.jpeg') }}') no-repeat center center fixed !important;
        background-size: cover !important;
    }
    .main-card {
        background: transparent !important;
        backdrop-filter: none !important;
        border-radius: 20px !important;
        box-shadow: none !important;
    }
    .dropdown-menu {
        min-width: 120px;
    }
    .dropdown-item.text-danger {
        color: #e53e3e;
        font-weight: bold;
    }
    th, td {
        border: none !important;
        background: transparent !important;
        color: #222 !important;
        font-size: 1.08rem;
        text-shadow: none !important;
    }
    .table-blur table,
    .table-blur tbody tr,
    .table-blur tbody tr:nth-child(even),
    .table-blur tbody tr:nth-child(odd),
    .table-blur tbody tr:hover {
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