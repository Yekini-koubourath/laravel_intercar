@extends('layouts.stock')

@section('title', 'Entrée ' . $purchase->number)
@section('crumb', 'Entrée ' . $purchase->number)

@php
    $xof = fn ($v) => number_format($v, 0, ',', ' ') . ' XOF';
    $mv  = $purchase->stockMovement;
@endphp

@section('content')

<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
    <div>
        <h1 class="page-title mb-1">
            <i class="bi bi-receipt me-2" style="color:var(--purple);"></i>{{ $purchase->number }}
        </h1>
        <p class="page-subtitle mb-0">
            Enregistrée le {{ $purchase->created_at->format('d/m/Y à H:i') }}
            par {{ $purchase->user->name ?? '-' }}
        </p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('stock.entries.index') }}" class="btn btn-light border"><i class="bi bi-list-ul me-1"></i>Toutes les entrées</a>
        <a href="{{ route('stock.entries.create') }}" class="btn btn-purple"><i class="bi bi-plus-lg me-1"></i>Nouvelle entrée</a>
    </div>
</div>

<div class="row g-4">
<div class="col-12 col-xl-8">

    <div class="section-card">
        <div class="section-header"><div class="section-number"><i class="bi bi-info-circle"></i></div>
            <div><h2 class="section-title">Approvisionnement</h2></div></div>
        <div class="section-body">
            <div class="info-line"><span class="text-muted">Numéro d'achat</span><strong>{{ $purchase->number }}</strong></div>
            <div class="info-line"><span class="text-muted">Date de l'achat</span><strong>{{ $purchase->purchase_date->format('d/m/Y') }}</strong></div>
            <div class="info-line"><span class="text-muted">Fournisseur</span><strong>{{ $purchase->supplier->name ?? '-' }}</strong></div>
            <div class="info-line"><span class="text-muted">Référence fournisseur</span><strong>{{ $purchase->supplier_reference ?: '-' }}</strong></div>
            <div class="info-line"><span class="text-muted">Observation</span><span class="text-end">{{ $purchase->observation ?: '-' }}</span></div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header"><div class="section-number"><i class="bi bi-box-seam"></i></div>
            <div><h2 class="section-title">Produit</h2></div></div>
        <div class="section-body">
            <div class="info-line"><span class="text-muted">Produit</span><strong>{{ $purchase->product->name }}</strong></div>
            <div class="info-line"><span class="text-muted">Référence</span><strong>{{ $purchase->product->reference }}</strong></div>
            <div class="info-line"><span class="text-muted">Quantité reçue</span>
                <strong class="text-success">+{{ $purchase->quantity }} {{ strtolower($units[$purchase->unit] ?? $purchase->unit) }}(s)</strong></div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header"><div class="section-number"><i class="bi bi-cash-coin"></i></div>
            <div><h2 class="section-title">Achat et conversion</h2></div></div>
        <div class="section-body">
            <div class="info-line"><span class="text-muted">Devise d'achat</span><strong>{{ $purchase->currency }}</strong></div>
            <div class="info-line"><span class="text-muted">Prix d'achat unitaire</span>
                <strong>{{ number_format($purchase->unit_price, 2, ',', ' ') }} {{ $purchase->currency }}</strong></div>
            <div class="info-line"><span class="text-muted">Total d'achat (devise d'origine)</span>
                <strong>{{ number_format($purchase->purchase_total_original, 2, ',', ' ') }} {{ $purchase->currency }}</strong></div>
            @if($purchase->exchange_rate)
                <div class="info-line"><span class="text-muted">Taux utilisé</span>
                    <strong>1 NGN = {{ rtrim(rtrim(number_format($purchase->exchange_rate, 8, '.', ''), '0'), '.') }} XOF
                        <span class="badge bg-light text-dark border ms-1">{{ $purchase->exchange_rate_source }}</span></strong></div>
            @endif
            <div class="info-line"><span class="text-muted">Total d'achat en FCFA</span><strong>{{ $xof($purchase->purchase_total_xof) }}</strong></div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header"><div class="section-number"><i class="bi bi-truck"></i></div>
            <div><h2 class="section-title">Frais annexes</h2></div></div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr><th class="ps-3">Type</th><th>Description</th><th class="text-end">Montant</th><th class="text-end pe-3">En XOF</th></tr>
                </thead>
                <tbody>
                    @forelse($purchase->expenses as $expense)
                        <tr>
                            <td class="ps-3">{{ $expenseTypes[$expense->type] ?? $expense->type }}</td>
                            <td>{{ $expense->description ?: '-' }}</td>
                            <td class="text-end">{{ number_format($expense->amount, 2, ',', ' ') }} {{ $expense->currency }}</td>
                            <td class="text-end pe-3">{{ $xof($expense->amount_xof) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Aucun frais annexe.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="col-12 col-xl-4">
<div class="sticky-side">

    <div class="section-card">
        <div class="section-header"><div class="section-number"><i class="bi bi-calculator"></i></div>
            <div><h2 class="section-title">Prix de revient</h2></div></div>
        <div class="section-body">
            <div class="calculation-box">
                <div class="calculation-row"><span class="text-muted">Achat en FCFA</span><strong>{{ $xof($purchase->purchase_total_xof) }}</strong></div>
                <div class="calculation-row"><span class="text-muted">Frais annexes</span><strong>{{ $xof($purchase->expenses_total_xof) }}</strong></div>
                <div class="calculation-row total"><span>Prix de revient total</span><span>{{ $xof($purchase->total_cost_xof) }}</span></div>
                <div class="calculation-row"><span class="text-muted">Prix de revient unitaire</span><strong>{{ $xof($purchase->unit_cost_xof) }}</strong></div>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header"><div class="section-number"><i class="bi bi-graph-up-arrow"></i></div>
            <div><h2 class="section-title">Tarification</h2></div></div>
        <div class="section-body">
            <div class="info-line"><span class="text-muted">Prix de vente unitaire</span><strong>{{ $xof($purchase->selling_price) }}</strong></div>
            <div class="info-line"><span class="text-muted">Marge unitaire</span><strong>{{ $xof($purchase->unit_margin) }}</strong></div>
            <div class="info-line"><span class="text-muted">Marge %</span>
                <strong class="{{ $purchase->margin_percent >= 0 ? 'text-success' : 'text-danger' }}">{{ number_format($purchase->margin_percent, 2, ',', ' ') }} %</strong></div>
            <div class="info-line"><span class="text-muted">Marge totale</span><strong>{{ $xof($purchase->total_margin) }}</strong></div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header"><div class="section-number"><i class="bi bi-boxes"></i></div>
            <div><h2 class="section-title">Mouvement de stock</h2></div></div>
        <div class="section-body">
            @if($mv)
                <div class="stock-preview">
                    <div class="small text-muted">Stock avant</div>
                    <div class="fw-bold fs-4">{{ $mv->stock_avant }}</div>
                    <div class="my-1 text-success fw-semibold">+ {{ $mv->quantity }}</div>
                    <hr class="my-2">
                    <div class="small text-muted">Stock après</div>
                    <div class="stock-number">{{ $mv->stock_apres }}</div>
                </div>
                <div class="small text-muted mt-2">{{ $mv->motif }}</div>
            @else
                <div class="text-muted">Mouvement introuvable.</div>
            @endif
        </div>
    </div>

</div>
</div>
</div>

@endsection