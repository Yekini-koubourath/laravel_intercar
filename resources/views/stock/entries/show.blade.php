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


</div>

<div class="col-12 col-xl-4">
<div class="sticky-side">


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