@extends('layouts.stock')

@section('title', 'Stock')
@section('crumb', 'État du stock')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
        <h1 class="page-title mb-1"><i class="bi bi-boxes me-2" style="color:var(--purple);"></i>Stock</h1>
        <p class="page-subtitle mb-0">Niveaux de stock et alertes par produit.</p>
    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('stock.movements.index') }}" class="btn btn-light border">
            <i class="bi bi-arrow-left-right me-1"></i>Mouvements
        </a>
        <a href="{{ route('stock.entries.create') }}" class="btn btn-purple">
            <i class="bi bi-plus-lg me-1"></i>Nouvelle entrée
        </a>
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#exitModal">
            <i class="bi bi-dash-lg me-1"></i>Sortie
        </button>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="section-card mb-0"><div class="section-body d-flex justify-content-between align-items-center">
            <div>
                <div class="text-muted mb-1">Produits</div>
                <div class="stat-number">{{ $totalProducts }}</div>
            </div>
            <i class="bi bi-box fs-3 text-primary"></i>
        </div></div>
    </div>
    <div class="col-12 col-md-4">
        <div class="section-card mb-0"><div class="section-body d-flex justify-content-between align-items-center">
            <div>
                <div class="text-muted mb-1">Quantité totale en stock</div>
                <div class="stat-number">{{ $totalStock }}</div>
            </div>
            <i class="bi bi-boxes fs-3 text-success"></i>
        </div></div>
    </div>
    <div class="col-12 col-md-4">
        <div class="section-card mb-0"><div class="section-body d-flex justify-content-between align-items-center">
            <div>
                <div class="text-muted mb-1">Stocks faibles</div>
                <div class="stat-number text-danger">{{ $stockFaible }}</div>
            </div>
            <i class="bi bi-exclamation-triangle fs-3 text-danger"></i>
        </div></div>
    </div>
</div>

<div class="section-card">
    <div class="section-header">
        <div class="section-number"><i class="bi bi-list-check"></i></div>
        <div><h2 class="section-title">État du stock</h2></div>
    </div>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Référence</th>
                    <th>Produit</th>
                    <th>Catégorie</th>
                    <th>Type</th>
                    <th>Stock</th>
                    <th>Seuil minimum</th>
                    <th>État</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td class="ps-3 fw-semibold">{{ $product->reference }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td>
                            @if($product->type === 'piece')
                                <span class="badge bg-warning text-dark">Pièce</span>
                            @else
                                <span class="badge bg-info text-dark">Véhicule</span>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $product->quantity }}</td>
                        <td>{{ $product->stock_minimum }}</td>
                        <td>
                            @if($product->quantity == 0)
                                <span class="badge bg-danger">Rupture</span>
                            @elseif($product->quantity <= $product->stock_minimum)
                                <span class="badge bg-warning text-dark">Stock faible</span>
                            @else
                                <span class="badge bg-success">Normal</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-box fs-1 d-block mb-2"></i>Aucun produit enregistré.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL : SORTIE DE STOCK --}}
<div class="modal fade" id="exitModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('stock.movements.store') }}">
                @csrf
                <input type="hidden" name="type" value="sortie">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Nouvelle sortie de stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Produit</label>
                            <select name="product_id" class="form-select" required>
                                <option value="">Sélectionner un produit</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->reference }} - {{ $product->name }} (Stock : {{ $product->quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Quantité</label>
                            <input type="number" name="quantity" class="form-control" min="1" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Motif</label>
                            <input type="text" name="motif" class="form-control" placeholder="Ex : Vente, casse, usage interne">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Observation</label>
                            <textarea name="observation" class="form-control" rows="3" placeholder="Observation facultative"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-purple"><i class="bi bi-check-lg me-1"></i>Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection