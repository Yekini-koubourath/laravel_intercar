@extends('layouts.stock')

@section('title', 'Nouvelle entrée de stock')
@section('crumb', 'Nouvelle entrée de stock')

@section('content')

<div class="mb-4 d-flex justify-content-between align-items-startgap-2 flex-wrap">
    <div>
        <h1 class="page-title mb-1">
            <i class="bi bi-box-arrow-in-down me-2" style="color:var(--purple);"></i>Nouvelle entrée de stock
        </h1>
        <p class="page-subtitle mb-0">Enregistrer un approvisionnement et calculer automatiquement son prix de revient.</p>
    </div>
    <a href="{{ route('stock.entries.index') }}" class="btn btn-light border">
        <i class="bi bi-list-ul me-1"></i>Voir les entrées
    </a>
</div>

<form method="POST" action="{{ route('stock.entries.store') }}" id="stockEntryForm">
@csrf

<div class="row g-4">
<div class="col-12 col-xl-8">
   {{-- 1. PRODUIT --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-number">1</div>
            <div>
                <h2 class="section-title">Produit à approvisionner</h2>
                <p class="section-description">Sélectionnez le produit qui entre en stock.</p>
            </div>
        </div>
        <div class="section-body">
            <label class="form-label">Rechercher un produit <spanclass="required">*</span></label>

            <div class="product-search-wrapper">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" id="productSearch" class="form-control"
                           placeholder="Rechercher par référence ou nom…" autocomplete="off">
                </div>

                <div class="product-results" id="productResults">
                    @forelse($products as $product)
                        <div class="product-result-item"
                             data-id="{{ $product->id }}"
                             data-name="{{ $product->name }}"
                             data-reference="{{ $product->reference }}"
                             data-type="{{ $product->type }}"
                             data-stock="{{ $product->quantity }}"
                             data-price="{{ $product->selling_price ?? 0 }}"
                             data-cost="{{ $product->purchase_price ?? 0 }}"
                             data-unit="{{ $product->unit }}">
                            <div class="fw-semibold">{{ $product->name }}</div>
                            <div class="small text-muted">Réf. {{$product->reference }} · Stock : {{ $product->quantity }}</div>
                        </div>
                    @empty
                        <div class="p-3 text-muted small">Aucun produit disponible.</div>
                    @endforelse
                </div>
            </div>

            <div class="selected-product" id="selectedProduct">
                <div class="d-flex justify-content-between align-items-start gap-2">
                    <div>
                        <div class="fw-semibold" id="selectedProductName"></div>
                        <div class="small text-muted">Réf. : <span id="selectedProductReference"></span></div>
                        <div class="small text-muted">Dernier prix de revient : <span id="selectedProductCost">-</span></div>
                    </div>
                    <span class="badge bg-light text-dark border"id="selectedProductType"></span>
                </div>
            </div>

            <input type="hidden" name="product_id" id="productId"value="{{ old('product_id') }}">

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label" for="quantity">Quantité <span class="required">*</span></label>
                    <input type="number" name="quantity" id="quantity" class="form-control"
                           min="1" step="1" value="{{ old('quantity', 1) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="unit">Unité</label>
                    <select name="unit" id="unit" class="form-select">
                        @foreach($units as $value => $label)
                            <option value="{{ $value }}" {{ old('unit', 'piece') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    {{-- 2. INFORMATIONS --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-number">2</div>
            <div>
                <h2 class="section-title">Informations de l'approvisionnement</h2>
                <p class="section-description">Source et date de l'entrée en stock.</p>
            </div>
        </div>
        <div class="section-body">
            <div class="row g-3">


                <div class="col-md-8">
                    <label class="form-label" for="supplierSelect">Fournisseur <span class="required">*</span></label>
                    <select name="supplier_id" id="supplierSelect" class="form-select">
                        <option value="">Sélectionner un fournisseur</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ (string) old('supplier_id') === (string) $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                        <option value="__new" {{ old('new_supplier') ? 'selected' : '' }}>+ Nouveau fournisseur…</option>
                    </select>
                    <input type="text" name="new_supplier" id="newSupplier" class="form-control mt-2 d-none"
                           placeholder="Nom du nouveau fournisseur" value="{{ old('new_supplier') }}">
                </div>
<div class="col-md-4">
    <label class="form-label" for="supplier_reference">Numéro du fournisseur</label>
    <input
        type="text"
        name="supplier_reference"
        id="supplier_reference"
        class="form-control"
        placeholder="Numéro du fournisseur"
        value="{{ old('supplier_reference') }}"
    >
</div>
            </div>
        </div>
    </div>

 
</div>

{{-- COLONNE DROITE --}}
<div class="col-12 col-xl-4">
<div class="sticky-side">

    <div class="section-card">
        <div class="section-header">
            <div class="section-number"><i class="bi bi-boxes"></i></div>
            <div><h2 class="section-title">Stock après entrée</h2></div>
        </div>
        <div class="section-body">
            <div class="stock-preview">
                <div class="small text-muted">Stock actuel</div>
                <div class="stock-number" id="currentStock">0</div>
                <div class="my-2">+</div>
                <div class="fw-semibold"><span id="previewQuantity">0</span> unité(s)</div>
                <hr>
                <div class="small text-muted">Nouveau stock</div>
                <div class="stock-number" id="newStock">0</div>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <div class="section-number"><i class="bi bi-arrow-left-right"></i></div>
            <div><h2 class="section-title">Mouvement créé</h2></div>
        </div>
        <div class="section-body">
            <div class="info-line"><span class="text-muted">Produit</span><strong id="previewProduct">-</strong></div>
            <div class="info-line"><span class="text-muted">Type</span><span class="badge bg-success">Entrée</span></div>
            <div class="info-line"><span class="text-muted">Quantité</span><strong id="previewMovementQuantity">+0</strong></div>
            <div class="info-line"><span class="text-muted">Stock avant</span><strong id="previewStockBefore">0</strong></div>
            <div class="info-line"><span class="text-muted">Stock après</span><strong id="previewStockAfter">0</strong></div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <div class="section-number"><i class="bi bi-shield-check"></i></div>
            <div><h2 class="section-title">Traçabilité</h2></div>
        </div>
        <div class="section-body">
            <div class="info-line"><span class="text-muted">Utilisateur</span><strong>{{ Auth::user()->name }}</strong></div>
            <div class="small text-muted mt-2">La date et l'heure d'enregistrement sont ajoutées automatiquement.</div>
        </div>
    </div>

</div>
</div>
</div>

<div class="bottom-actions">
    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('stock.index') }}" class="btn btn-lightborder">Annuler</a>
        <button type="submit" class="btn btn-purple">
            <i class="bi bi-check-lg me-1"></i>Valider l'entrée
        </button>
    </div>
</div>

</form>
@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const $ = id => document.getElementById(id);

    const fmt = value =>
        new Intl.NumberFormat('fr-FR', {
            maximumFractionDigits: 2
        }).format(value);

    let selectedStock = 0;

    /* =========================================
       FOURNISSEUR
    ========================================= */

    const supplierSelect = $('supplierSelect');
    const newSupplier = $('newSupplier');

    function toggleNewSupplier() {
        const isNew = supplierSelect.value === '__new';

        newSupplier.classList.toggle('d-none', !isNew);
        newSupplier.required = isNew;

        if (!isNew) {
            newSupplier.value = '';
        }
    }

    supplierSelect.addEventListener('change', toggleNewSupplier);
    toggleNewSupplier();

    /* =========================================
       RECHERCHE DU PRODUIT
    ========================================= */

    const productSearch = $('productSearch');
    const productResults = $('productResults');
    const productId = $('productId');

    const items = () =>
        document.querySelectorAll('.product-result-item');

    productSearch.addEventListener('focus', function () {
        productResults.classList.add('show');
    });

    productSearch.addEventListener('input', function () {
        const search = productSearch.value.toLowerCase().trim();

        // Une nouvelle recherche exige une nouvelle sélection.
        productId.value = '';
        selectedStock = 0;

        $('selectedProduct').classList.remove('show');
        $('previewProduct').textContent = '-';

        items().forEach(item => {
            const name = (item.dataset.name || '').toLowerCase();
            const reference = (item.dataset.reference || '').toLowerCase();

            const matches =
                name.includes(search) ||
                reference.includes(search);

            item.style.display = matches ? '' : 'none';
        });

        productResults.classList.add('show');
        updateStockPreview();
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.product-search-wrapper')) {
            productResults.classList.remove('show');
        }
    });

    /* =========================================
       SÉLECTION DU PRODUIT
    ========================================= */

    function selectProduct(item) {
        productId.value = item.dataset.id;

        $('selectedProductName').textContent =
            item.dataset.name || '';

        $('selectedProductReference').textContent =
            item.dataset.reference || '';

        $('selectedProductType').textContent =
            item.dataset.type === 'piece'
                ? 'Pièce détachée'
                : 'Véhicule';

        // Le prix affiché ici est informatif uniquement.
        // Aucun prix n'est modifié par cette entrée de stock.
        const cost = Number(item.dataset.cost) || 0;

        $('selectedProductCost').textContent =
            cost > 0 ? fmt(cost) + ' XOF' : '-';

        $('selectedProduct').classList.add('show');

        $('previewProduct').textContent =
            item.dataset.name || '-';

        productSearch.value = item.dataset.name || '';

        selectedStock = Number(item.dataset.stock) || 0;

        // Préremplir l'unité si elle existe dans la liste.
        const unit = item.dataset.unit;

        if (unit) {
            const unitOption = Array.from($('unit').options)
                .find(option => option.value === unit);

            if (unitOption) {
                $('unit').value = unit;
            }
        }

        items().forEach(product => {
            product.style.display = '';
        });

        productResults.classList.remove('show');

        updateStockPreview();
    }

    productResults.addEventListener('click', function (event) {
        const item = event.target.closest('.product-result-item');

        if (item) {
            selectProduct(item);
        }
    });

    /* =========================================
       APERÇU DU STOCK
    ========================================= */

    function updateStockPreview() {
        const hasProduct = Boolean(productId.value);

        const quantity = hasProduct
            ? Math.max(0, Number($('quantity').value) || 0)
            : 0;

        const stockBefore = hasProduct ? selectedStock : 0;
        const stockAfter = stockBefore + quantity;

        // Carte « Stock après entrée »
        $('currentStock').textContent = fmt(stockBefore);
        $('previewQuantity').textContent = fmt(quantity);
        $('newStock').textContent = fmt(stockAfter);

        // Carte « Mouvement créé »
        $('previewMovementQuantity').textContent =
            '+' + fmt(quantity);

        $('previewStockBefore').textContent =
            fmt(stockBefore);

        $('previewStockAfter').textContent =
            fmt(stockAfter);
    }

    $('quantity').addEventListener(
        'input',
        updateStockPreview
    );

    $('unit').addEventListener(
        'change',
        updateStockPreview
    );

    /* =========================================
       VALIDATION AVANT ENREGISTREMENT
    ========================================= */

    $('stockEntryForm').addEventListener('submit', function (event) {
        if (!productId.value) {
            event.preventDefault();

            alert('Veuillez sélectionner un produit.');

            productSearch.focus();
            return;
        }

        const quantity = Number($('quantity').value);

        if (!Number.isInteger(quantity) || quantity < 1) {
            event.preventDefault();

            alert('Veuillez saisir une quantité entière supérieure à zéro.');

            $('quantity').focus();
            return;
        }

        if (supplierSelect.value === '__new') {
            if (!newSupplier.value.trim()) {
                event.preventDefault();

                alert('Veuillez saisir le nom du nouveau fournisseur.');

                newSupplier.focus();
                return;
            }

            // Le contrôleur reçoit new_supplier pour créer le fournisseur.
            supplierSelect.disabled = true;
        }
    });

    /* =========================================
       INITIALISATION
    ========================================= */

    const oldProductId = productId.value;

    if (oldProductId) {
        const oldProduct = document.querySelector(
            '.product-result-item[data-id="' + oldProductId + '"]'
        );

        if (oldProduct) {
            selectProduct(oldProduct);
        } else {
            updateStockPreview();
        }
    } else {
        updateStockPreview();
    }
});
</script>
@endpush
