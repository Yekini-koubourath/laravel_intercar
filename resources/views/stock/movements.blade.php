@extends('layouts.stock')

@section('title', 'Mouvements de stock')
@section('crumb', 'Mouvements de stock')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
        <h1 class="page-title mb-1"><i class="bi bi-arrow-left-right me-2" style="color:var(--purple);"></i>Mouvements de stock</h1>
        <p class="page-subtitle mb-0">Historique complet des entrées, sorties et ajustements.</p>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('stock.index') }}" class="btn btn-light border">
            <i class="bi bi-boxes me-1"></i>Stock
        </a>
        <a href="{{ route('stock.entries.index') }}" class="btn btn-light border">
            <i class="bi bi-receipt me-1"></i>Entrées d'achat
        </a>
        <a href="{{ route('stock.entries.create') }}" class="btn btn-purple">
            <i class="bi bi-plus-lg me-1"></i>Nouvelle entrée
        </a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="section-card mb-0"><div class="section-body">
            <div class="text-muted mb-1">Mouvements enregistrés</div>
            <div class="stat-number">{{ number_format($countAll, 0, ',', ' ') }}</div>
        </div></div>
    </div>
    <div class="col-12 col-md-4">
        <div class="section-card mb-0"><div class="section-body">
            <div class="text-muted mb-1">Total des entrées</div>
            <div class="stat-number text-success">+{{ number_format($totalEntrees, 0, ',', ' ') }}</div>
        </div></div>
    </div>
    <div class="col-12 col-md-4">
        <div class="section-card mb-0"><div class="section-body">
            <div class="text-muted mb-1">Total des sorties</div>
            <div class="stat-number text-danger">-{{ number_format($totalSorties, 0, ',', ' ') }}</div>
        </div></div>
    </div>
</div>

<div class="section-card">
    <div class="section-body">
        <form method="GET" action="{{ route('stock.movements.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Recherche</label>
                <input type="text" name="q" class="form-control" placeholder="Produit, référence, motif…" value="{{ request('q') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="">Tous</option>
                    <option value="entree" {{ request('type') === 'entree' ? 'selected' : '' }}>Entrée</option>
                    <option value="sortie" {{ request('type') === 'sortie' ? 'selected' : '' }}>Sortie</option>
                    <option value="ajustement" {{ request('type') === 'ajustement' ? 'selected' : '' }}>Ajustement</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Du</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Au</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>
            <div class="col-md-2 d-flex gap-1">
                <button class="btn btn-purple flex-grow-1" title="Filtrer"><i class="bi bi-funnel"></i></button>
                <a href="{{ route('stock.movements.index') }}" class="btn btn-light border" title="Réinitialiser"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="section-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Date</th>
                    <th>Produit</th>
                    <th>Type</th>
                    <th class="text-end">Quantité</th>
                    <th class="text-end">Stock avant</th>
                    <th class="text-end">Stock après</th>
                    <th>Motif</th>
                    <th class="pe-3">Utilisateur</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $movement)
                    <tr>
                        <td class="ps-3">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="fw-semibold">{{ $movement->product->name ?? '-' }}</div>
                            <div class="small text-muted">{{ $movement->product->reference ?? '' }}</div>
                        </td>
                        <td>
                            @if($movement->type === 'entree')
                                <span class="badge bg-success">Entrée</span>
                            @elseif($movement->type === 'sortie')
                                <span class="badge bg-danger">Sortie</span>
                            @else
                                <span class="badge bg-warning text-dark">Ajustement</span>
                            @endif
                        </td>
                        <td class="text-end fw-bold {{ $movement->type === 'entree' ? 'text-success' : 'text-danger' }}">
                            {{ $movement->type === 'entree' ? '+' : '-' }}{{ $movement->quantity }}
                        </td>
                        <td class="text-end">{{ $movement->stock_avant }}</td>
                        <td class="text-end">{{ $movement->stock_apres }}</td>
                        <td>
                            @if($movement->purchase)
                                <a href="{{ route('stock.entries.show', $movement->purchase) }}" class="text-decoration-none">
                                    <i class="bi bi-receipt me-1"></i>{{ $movement->motif }}
                                </a>
                            @else
                                {{ $movement->motif ?? '-' }}
                            @endif
                        </td>
                        <td class="pe-3">{{ $movement->user->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>Aucun mouvement trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($movements->hasPages())
        <div class="p-3 border-top">{{ $movements->links('pagination::bootstrap-5') }}</div>
    @endif
</div>

@endsection