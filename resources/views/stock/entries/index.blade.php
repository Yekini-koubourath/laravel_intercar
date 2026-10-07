@extends('layouts.stock')

@section('title', 'Entrées de stock')
@section('crumb', 'Entrées de stock')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
        <h1 class="page-title mb-1"><i class="bi bi-box-arrow-in-down me-2" style="color:var(--purple);"></i>Entrées de stock</h1>
        <p class="page-subtitle mb-0">Historique des approvisionnements enregistrés.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('stock.index') }}" class="btn btn-light border"><i class="bi bi-arrow-left me-1"></i>Stock</a>
        <a href="{{ route('stock.entries.create') }}" class="btn btn-purple"><i class="bi bi-plus-lg me-1"></i>Nouvelle entrée</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="section-card mb-0"><div class="section-body">
            <div class="text-muted mb-1">Entrées enregistrées</div>
            <div class="stat-number">{{ number_format($countEntries, 0, ',', ' ') }}</div>
        </div></div>
    </div>
    <div class="col-12 col-md-4">
        <div class="section-card mb-0"><div class="section-body">
            <div class="text-muted mb-1">Quantité totale reçue</div>
            <div class="stat-number">{{ number_format($totalQuantity, 0, ',', ' ') }}</div>
        </div></div>
    </div>
    <div class="col-12 col-md-4">
        <div class="section-card mb-0"><div class="section-body">
            <div class="text-muted mb-1">Coût total d'acquisition</div>
            <div class="stat-number">{{ number_format($totalCost, 0, ',', ' ') }} <small class="fs-6">XOF</small></div>
        </div></div>
    </div>
</div>

<div class="section-card">
    <div class="section-body">
        <form method="GET" action="{{ route('stock.entries.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Recherche</label>
                <input type="text" name="q" class="form-control" placeholder="N° achat, produit, référence…" value="{{ request('q') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Fournisseur</label>
                <select name="supplier_id" class="form-select">
                    <option value="">Tous</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ (string) request('supplier_id') === (string) $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                    @endforeach
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
            <div class="col-md-1 d-flex gap-1">
                <button class="btn btn-purple w-100" title="Filtrer"><i class="bi bi-funnel"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="section-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">N° achat</th>
                    <th>Date</th>
                    <th>Fournisseur</th>
                    <th>Produit</th>
                    <th class="text-end">Qté</th>
                    <th class="text-end">Coût total</th>
                    <th class="text-end">Coût unitaire</th>
                    <th class="text-end">Marge</th>
                    <th>Par</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $purchase)
                    <tr>
                        <td class="ps-3 fw-semibold">{{ $purchase->number }}</td>
                        <td>{{ $purchase->purchase_date->format('d/m/Y') }}</td>
                        <td>{{ $purchase->supplier->name ?? '-' }}</td>
                        <td>
                            <div class="fw-semibold">{{ $purchase->product->name ?? '-' }}</div>
                            <div class="small text-muted">{{ $purchase->product->reference ?? '' }}</div>
                        </td>
                        <td class="text-end fw-bold text-success">+{{ $purchase->quantity }}</td>
                        <td class="text-end">{{ number_format($purchase->total_cost_xof, 0, ',', ' ') }} XOF</td>
                        <td class="text-end">{{ number_format($purchase->unit_cost_xof, 0, ',', ' ') }} XOF</td>
                        <td class="text-end">
                            <span class="badge {{ $purchase->margin_percent >= 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ number_format($purchase->margin_percent, 1, ',', ' ') }} %
                            </span>
                        </td>
                        <td>{{ $purchase->user->name ?? '-' }}</td>
                        <td class="text-end pe-3">
                            <a href="{{ route('stock.entries.show', $purchase) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-eye me-1"></i>Voir
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>Aucune entrée enregistrée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($purchases->hasPages())
        <div class="p-3 border-top">{{ $purchases->links('pagination::bootstrap-5') }}</div>
    @endif
</div>

@endsection