@extends('layouts.app')

@section('body_class', 'vehicule-bg')

@section('content')
<a href="{{ route('utilisateurs.index') }}" class="btn btn-secondary mb-3">Retour à la liste des utilisateurs</a>
<h1>Activités de {{ $user->name }} ({{ $user->email }})</h1>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Date</th>
            <th>Action</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        @forelse($activities as $activity)
            <tr>
                <td>{{ $activity->created_at }}</td>
                <td>{{ $activity->action }}</td>
                <td>{{ $activity->description }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">Aucune activité trouvée.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection 