@extends('layouts.stock')

@section('title', 'Tarification')
@section('crumb', 'Tarification')

@section('content')
<div class="container-fluid px-0 tarification-page">

    {{-- En-tête --}}
    <div class="page-heading mb-4">
        <div>
            <h1 class="page-title">Tarification</h1>
            <p class="page-subtitle">
                Enregistrez le prix et le stock d'un produit, puis consultez et modifiez vos tarifs.
            </p>
        </div>

        <button type="button"
                class="btn btn-filter"
                data-bs-toggle="modal"
                data-bs-target="#pricingEntryModal">
            <i class="fa-solid fa-plus me-2"></i>
            Nouvelle tarification
        </button>
    </div>

    {{-- Notification de succès --}}

@if (session('success'))
    <div id="tarificationSuccessAlert" class="alert alert-success" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alertElement = document.getElementById('tarificationSuccessAlert');

            if (alertElement) {
                setTimeout(function () {
                    alertElement.style.transition = 'opacity 0.3s ease';
                    alertElement.style.opacity = '0';

                    setTimeout(function () {
                        alertElement.remove();
                    }, 300);
                }, 1000);
            }
        });
    </script>
@endif


    {{-- Erreurs --}}
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <div class="fw-semibold mb-2">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                Impossible d'enregistrer.
            </div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Trois cartes de synthèse --}}
    <div class="summary-grid mb-4">

        <article class="summary-card summary-cost">
            <div class="summary-icon">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div class="summary-content">
                <span class="summary-label">Prix de revient total</span>
                <div class="summary-value">
                    {{ number_format((float) $totalCost, 0, ',', ' ') }}
                    <span>FCFA</span>
                </div>
                <span class="summary-description">Valeur du stock au prix de revient</span>
            </div>
        </article>

        <article class="summary-card summary-sale">
            <div class="summary-icon">
                <i class="fa-solid fa-tags"></i>
            </div>
            <div class="summary-content">
                <span class="summary-label">Prix de vente total</span>
                <div class="summary-value">
                    {{ number_format((float) $totalSale, 0, ',', ' ') }}
                    <span>FCFA</span>
                </div>
                <span class="summary-description">Valeur du stock aux prix de vente actuels</span>
            </div>
        </article>

        <article class="summary-card summary-margin">
            <div class="summary-icon">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div class="summary-content">
                <span class="summary-label">Marge totale</span>
                <div class="summary-value {{ $totalMargin < 0 ? 'negative-value' : '' }}">
                    {{ number_format((float) $totalMargin, 0, ',', ' ') }}
                    <span>FCFA</span>
                </div>
                <span class="summary-description">Prix de vente total moins prix de revient total</span>
            </div>
        </article>

    </div>

    {{-- Recherche et filtre --}}
    <section class="filter-card mb-4">
        <form method="GET"
              action="{{ route('tarification.index') }}"
              class="filter-form">

            <div class="filter-input-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input
                    type="search"
                    name="q"
                    value="{{ $search }}"
                    class="form-control filter-input"
                    placeholder="Rechercher par nom ou référence..."
                    aria-label="Rechercher un produit par nom ou référence"
                >
            </div>

            <button type="submit" class="btn btn-filter">
                <i class="fa-solid fa-filter me-2"></i>
                Filtrer
            </button>
        </form>
    </section>

    {{-- Liste des tarifs --}}
    <section class="table-card">

        <div class="table-heading">
            <div>
                <h2>Liste des tarifs</h2>
                <p>Prix exprimés en FCFA</p>
            </div>

            <span class="result-count">
                {{ $products->total() }}
                {{ $products->total() > 1 ? 'produits' : 'produit' }}
            </span>
        </div>

        <div class="table-responsive">
            <table class="table pricing-table te-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-end">Prix d'achat unitaire</th>
                        <th class="text-end">Frais annexes</th>
                        <th class="text-end">Prix de revient unitaire</th>
                        <th class="text-end">Prix de vente unitaire</th>
                        <th class="text-end">Marge unitaire</th>
                        <th class="text-end">Marge totale</th>
                        <th class="text-end">Total des ventes</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $product)
                        @php
                            $cost    = (float) ($product->purchase_price ?? 0);
                            $sale    = (float) ($product->selling_price ?? 0);
                            $qty     = (int) $product->quantity;
                            $priced  = $cost > 0;
                            $unitMargin  = $sale - $cost;
                            $marginPercent = $priced ? ($unitMargin / $cost) * 100 : 0;
                            $totalMarginRow = $unitMargin * $qty;
                            $isVehicle = ($product->type ?? '') === 'vehicule';

                            $last = $lastPurchases->get($product->id);
                            $sold = $sales->get($product->id);
                            $soldQty = (int) ($sold->qty_sold ?? 0);
                            $revenue = (float) ($sold->revenue ?? 0);
                        @endphp

                        <tr>
                            <td>
                                <div class="product-cell">
                                    <div class="product-avatar">
                                        <i class="fa-solid {{ $isVehicle ? 'fa-car' : 'fa-gears' }}"></i>
                                    </div>
                                    <div>
                                        <span class="product-name d-block">{{ $product->name }}</span>
                                        <span class="reference-text">{{ $product->reference ?? '—' }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center fw-bold">
                                {{ number_format($qty, 0, ',', ' ') }}
                            </td>

                            <td class="text-end text-nowrap">
                                @if ($last)
                                    {{ number_format($last->unit_price, 2, ',', ' ') }}
                                    <span class="currency">{{ $last->currency }}</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-end">
    <span class="fw-semibold">
        {{ number_format((float) ($last->expenses_total_xof ?? 0), 0, ',', ' ') }}
        FCFA
    </span>
</td>

                            <td class="text-end text-nowrap">
                                @if ($priced)
                                    {{ number_format($cost, 0, ',', ' ') }}
                                    <span class="currency">FCFA</span>
                                @else
                                    —
                                @endif
                            </td>

                            <td class="text-end text-nowrap fw-semibold">
                                @if ($sale > 0)
                                    {{ number_format($sale, 0, ',', ' ') }}
                                    <span class="currency">FCFA</span>
                                @else
                                    —
                                @endif
                            </td>

                            <td class="text-end">
                                @if ($priced)
                                    <div class="margin-value {{ $unitMargin < 0 ? 'margin-negative' : 'margin-positive' }}">
                                        {{ number_format($unitMargin, 0, ',', ' ') }} FCFA
                                    </div>
                                    <small class="margin-percent">
                                        {{ number_format($marginPercent, 2, ',', ' ') }} %
                                    </small>
                                @else
                                    —
                                @endif
                            </td>

                            <td class="text-end text-nowrap">
                                @if ($priced)
                                    <span class="margin-value {{ $totalMarginRow < 0 ? 'margin-negative' : 'margin-positive' }}">
                                        {{ number_format($totalMarginRow, 0, ',', ' ') }} FCFA
                                    </span>
                                @else
                                    —
                                @endif
                            </td>

                            <td class="text-end text-nowrap">
                                <div class="fw-semibold">
                                    {{ number_format($revenue, 0, ',', ' ') }}
                                    <span class="currency">FCFA</span>
                                </div>
                                <small class="margin-percent">
                                    {{ number_format($soldQty, 0, ',', ' ') }} vendu(s)
                                </small>
                            </td>

                            <td class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editPriceModal"
                                    data-product-id="{{ $product->id }}"
                                    data-product-name="{{ $product->name }}"
                                    data-product-reference="{{ $product->reference ?? '—' }}"
                                    data-current-price="{{ $product->selling_price ?? 0 }}"
                                    data-update-url="{{ route('tarification.update', $product) }}"
                                >
                                    <i class="fa-solid fa-pen-to-square me-1"></i>
                                    Modifier
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <h3>Aucun produit trouvé</h3>
                                    <p>
                                        Aucun produit ne correspond à votre recherche.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
        @endif

    </section>
</div>


{{-- =========================================================
     FENÊTRE : NOUVELLE TARIFICATION
========================================================== --}}
@php
    $defaultCurrency = old('currency', array_key_exists('NGN', $currencies) ? 'NGN' : array_key_first($currencies));
@endphp

<div class="modal fade" id="pricingEntryModal" tabindex="-1"
     aria-labelledby="pricingEntryModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content te-modal">

            <form method="POST" action="{{ route('tarification.store') }}" id="pricingEntryForm">
                @csrf

                <input type="hidden" name="return_to" value="tarification">
                <input type="hidden" name="purchase_date" value="{{ date('Y-m-d') }}">
                <input type="hidden" name="product_id" id="te_product_id" value="{{ old('product_id') }}">
                <input type="hidden" name="exchange_rate" id="te_exchange_rate" value="{{ old('exchange_rate') }}">

                <div class="modal-header">
                    <div>
                        <span class="modal-eyebrow">TARIFICATION</span>
                        <h2 class="modal-title" id="pricingEntryModalLabel">
                            Nouvelle tarification
                            @if(!empty($nextNumber))
                                <small class="text-muted fs-6 ms-2">{{ $nextNumber }}</small>
                            @endif
                        </h2>
                    </div>

                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body te-body">
                    <div class="row g-4">

                        {{-- ================= COLONNE GAUCHE ================= --}}
                        <div class="col-12 col-lg-8">

                            {{-- 1. PRODUIT, QUANTITÉ, FOURNISSEUR --}}
                            <div class="section-card te-visible">
                                <div class="section-header">
                                    <div class="section-number">1</div>
                                    <div>
                                        <h3 class="section-title">Produit, quantité et fournisseur</h3>
                                        <p class="section-description">Choisissez un produit déjà enregistré.</p>
                                    </div>
                                </div>
                                <div class="section-body">

                                    <label class="form-label">
                                        Rechercher un produit <span class="required">*</span>
                                    </label>

                                    <div class="product-search-wrapper" id="te_searchWrapper">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                                            <input type="text" id="te_productSearch" class="form-control"
                                                   placeholder="Rechercher par nom ou référence…" autocomplete="off">
                                        </div>

                                        <div class="product-results" id="te_productResults">
                                            @forelse($entryProducts as $entryProduct)
                                                <div class="product-result-item"
                                                     data-id="{{ $entryProduct->id }}"
                                                     data-name="{{ $entryProduct->name }}"
                                                     data-reference="{{ $entryProduct->reference }}"
                                                     data-type="{{ $entryProduct->type }}"
                                                     data-stock="{{ $entryProduct->quantity }}"
                                                     data-price="{{ $entryProduct->selling_price ?? 0 }}"
                                                     data-cost="{{ $entryProduct->purchase_price ?? 0 }}"
                                                     data-unit="{{ $entryProduct->unit }}">
                                                    <div class="fw-semibold">{{ $entryProduct->name }}</div>
                                                    <div class="small text-muted">
                                                        Réf. {{ $entryProduct->reference }} · Stock : {{ $entryProduct->quantity }}
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="p-3 text-muted small">Aucun produit enregistré.</div>
                                            @endforelse

                                            <div class="p-3 text-muted small d-none" id="te_noProduct">
                                                Aucun produit ne correspond.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="selected-product" id="te_selectedProduct">
                                        <div class="d-flex justify-content-between align-items-start gap-2">
                                            <div>
                                                <div class="fw-semibold" id="te_selectedName"></div>
                                                <div class="small text-muted">Réf. : <span id="te_selectedRef"></span></div>
                                                <div class="small text-muted">
                                                    Prix de revient actuel : <span id="te_selectedCost">-</span>
                                                </div>
                                            </div>
                                            <span class="badge bg-light text-dark border" id="te_selectedType"></span>
                                        </div>
                                    </div>

                                    <div class="row g-3 mt-1">
                                        <div class="col-12 col-md-4">
                                            <label class="form-label" for="te_quantity">
                                                Quantité <span class="required">*</span>
                                            </label>
                                            <input type="number" name="quantity" id="te_quantity" class="form-control"
                                                   min="1" step="1" value="{{ old('quantity', 1) }}" required>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label class="form-label" for="te_unit">Unité</label>
                                            <select name="unit" id="te_unit" class="form-select">
                                                @foreach($units as $value => $label)
                                                    <option value="{{ $value }}"
                                                        {{ old('unit', 'piece') === $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label class="form-label" for="te_supplier">
                                                Fournisseur <span class="required">*</span>
                                            </label>
                                            <select name="supplier_id" id="te_supplier" class="form-select">
                                                <option value="">Sélectionner</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}"
                                                        {{ (string) old('supplier_id') === (string) $supplier->id ? 'selected' : '' }}>
                                                        {{ $supplier->name }}
                                                    </option>
                                                @endforeach
                                                <option value="__new" {{ old('new_supplier') ? 'selected' : '' }}>
                                                    + Nouveau fournisseur…
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-12 d-none" id="te_newSupplierWrap">
                                            <input type="text" name="new_supplier" id="te_newSupplier" class="form-control"
                                                   placeholder="Nom du nouveau fournisseur" value="{{ old('new_supplier') }}">
                                        </div>
                                    </div>

                                </div>
                            </div>


{{-- 2. PRIX D'ACHAT ET DEVISE --}}
<div class="section-card">
    <div class="section-header">
        <div class="section-number">2</div>
        <div>
            <h3 class="section-title">Prix d'achat et devise</h3>
            <p class="section-description">
                Saisissez le prix unitaire et choisissez la devise.
                La conversion en FCFA est automatique.
            </p>
        </div>
    </div>

    <div class="section-body">
        <div class="row g-3 align-items-end">

            {{-- Prix d'achat unitaire et devise --}}
            <div class="col-12 col-md-6">
                <label class="form-label" for="te_unit_price">
                    Prix d'achat unitaire <span class="required">*</span>
                </label>

                <div class="input-group">
                    <input
                        type="number"
                        name="unit_price"
                        id="te_unit_price"
                        class="form-control"
                        min="0"
                        step="0.01"
                        value="{{ old('unit_price', 0) }}"
                        required
                    >

                    <select
                        name="currency"
                        id="te_currency"
                        class="form-select"
                        style="max-width: 115px;"
                        aria-label="Devise du prix d'achat"
                        required
                    >
                        @foreach($currencies as $value => $label)
                            <option
                                value="{{ $value }}"
                                {{ ($defaultCurrency ?? 'XOF') === $value ? 'selected' : '' }}
                            >
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Prix d'achat total et devise --}}
            <div class="col-12 col-md-6">
                <label class="form-label" for="te_purchaseXof">
                    Prix d'achat total
                </label>

                <div class="input-group">
                    <input
                        type="text"
                        id="te_purchaseXof"
                        class="form-control fw-semibold"
                        value="0"
                        readonly
                    >

                    <select
                        id="te_total_currency"
                        class="form-select"
                        style="max-width: 115px;"
                        aria-label="Devise du prix d'achat total"
                    >
                        @foreach($currencies as $value => $label)
                            <option
                                value="{{ $value }}"
                                {{ $value === 'XOF' ? 'selected' : '' }}
                            >
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

        {{-- Information sur le taux de change --}}
        <div class="small mt-3" id="te_rateHelp"></div>
    </div>
</div>


                            {{-- 3. FRAIS ANNEXES --}}
                            <div class="section-card">
                                <div class="section-header">
                                    <div class="section-number">3</div>
                                    <div class="flex-grow-1">
                                        <h3 class="section-title">Frais annexes</h3>
                                        <p class="section-description">Transport, douane, manutention, frais de dossier, etc.</p>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="te_addExpense">
                                        <i class="fa-solid fa-plus me-1"></i>Ajouter un frais
                                    </button>
                                </div>
                                <div class="section-body">
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0 te-expense-table">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Description</th>
                                                    <th style="width:150px">Montant</th>
                                                    <th style="width:110px">Devise</th>
                                                    <th style="width:48px"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="te_expensesBody"></tbody>
                                        </table>
                                    </div>

                                    <div class="text-center text-muted py-3" id="te_emptyExpense">
                                        <i class="fa-solid fa-receipt fs-4 d-block mb-1"></i>
                                        Aucun frais annexe ajouté.
                                    </div>

                                    <div class="text-end mt-3">
                                        <span class="text-muted">Total des frais :</span>
                                        <strong id="te_expensesTotal">0 XOF</strong>
                                    </div>
                                </div>
                            </div>


                            {{-- 4. PRIX DE REVIENT, MARGE, PRIX DE VENTE --}}
                            <div class="section-card">
                                <div class="section-header">
                                    <div class="section-number">4</div>
                                    <div>
                                        <h3 class="section-title">Prix de revient, marge et prix de vente</h3>
                                        <p class="section-description">
                                            Le prix de vente se calcule à partir de la marge que vous fixez.
                                        </p>
                                    </div>
                                </div>
                                <div class="section-body">

                                    <div class="calculation-box mb-3">
                                        <div class="calculation-row">
                                            <span class="text-muted">Prix d'achat en FCFA</span>
                                            <strong id="te_costPurchase">0 XOF</strong>
                                        </div>
                                        <div class="calculation-row">
                                            <span class="text-muted">Total des frais annexes</span>
                                            <strong id="te_costExpenses">0 XOF</strong>
                                        </div>
                                        <div class="calculation-row total">
                                            <span>Prix de revient total</span>
                                            <span id="te_totalCost">0 XOF</span>
                                        </div>
                                        <div class="calculation-row">
                                            <span class="text-muted">Prix de revient unitaire</span>
                                            <strong id="te_unitCost">0 XOF</strong>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12 col-md-4">
                                            <label class="form-label" for="te_margin">
                                                Marge souhaitée (%) <span class="required">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="number" id="te_margin" class="form-control"
                                                       min="0" step="0.1" value="0">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Marge unitaire</label>
                                            <div class="input-group">
                                                <input type="text" id="te_unitMargin"
                                                       class="form-control fw-semibold" value="0" readonly>
                                                <span class="input-group-text">XOF</span>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <label class="form-label">Prix de vente unitaire</label>
                                            <div class="input-group">
                                                <input type="number" name="selling_price" id="te_selling_price"
                                                       class="form-control fw-bold te-sale-input"
                                                       value="0" readonly>
                                                <span class="input-group-text">XOF</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label class="form-label" for="te_observation">Observation</label>
                                        <input type="text" name="observation" id="te_observation" class="form-control"
                                               placeholder="Facultatif" value="{{ old('observation') }}">
                                    </div>

                                </div>
                            </div>

                        </div>


                        {{-- ================= COLONNE DROITE : HISTORIQUE ================= --}}
                        <div class="col-12 col-lg-4">
                            <div class="te-sticky">

                                <div class="section-card mb-0">
                                    <div class="section-header">
                                        <div class="section-number"><i class="fa-solid fa-clock-rotate-left"></i></div>
                                        <div>
                                            <h3 class="section-title">Historique</h3>
                                            <p class="section-description">Résumé de la saisie en cours</p>
                                        </div>
                                    </div>
                                    <div class="section-body">

                                        <div class="info-line"><span class="text-muted">Produit</span><strong id="te_rProduct">—</strong></div>
                                        <div class="info-line"><span class="text-muted">Référence</span><strong id="te_rRef">—</strong></div>
                                        <div class="info-line"><span class="text-muted">Fournisseur</span><strong id="te_rSupplier">—</strong></div>
                                        <div class="info-line"><span class="text-muted">Quantité</span><strong id="te_rQty">0</strong></div>
                                        <div class="info-line"><span class="text-muted">Devise</span><strong id="te_rCurrency">—</strong></div>
                                        <div class="info-line"><span class="text-muted">Taux utilisé</span><strong id="te_rRate">—</strong></div>
                                        <div class="info-line"><span class="text-muted">Achat unitaire</span><strong id="te_rUnitPrice">0</strong></div>
                                        <div class="info-line"><span class="text-muted">Achat total (FCFA)</span><strong id="te_rPurchase">0 XOF</strong></div>

                                        <div class="te-recap-title">Frais annexes</div>
                                        <div id="te_rExpenses" class="small text-muted">Aucun frais.</div>
                                        <div class="info-line mt-1"><span class="text-muted">Total des frais</span><strong id="te_rExpensesTotal">0 XOF</strong></div>

                                        <div class="te-recap-title">Tarification</div>
                                        <div class="info-line"><span class="text-muted">Prix de revient total</span><strong id="te_rTotalCost">0 XOF</strong></div>
                                        <div class="info-line"><span class="text-muted">Prix de revient unitaire</span><strong id="te_rUnitCost">0 XOF</strong></div>
                                        <div class="info-line"><span class="text-muted">Marge</span><strong id="te_rMarginPct">0 %</strong></div>
                                        <div class="info-line"><span class="text-muted">Marge unitaire</span><strong id="te_rUnitMargin">0 XOF</strong></div>
                                        <div class="info-line"><span class="text-muted">Prix de vente unitaire</span><strong class="te-sale-text" id="te_rSale">0 XOF</strong></div>
                                        <div class="info-line"><span class="text-muted">Marge totale</span><strong id="te_rTotalMargin">0 XOF</strong></div>

                                        <div class="te-stock-preview">
                                            <div class="small text-muted">Stock actuel</div>
                                            <div class="te-stock-number" id="te_rCurrentStock">0</div>
                                            <div class="small text-muted my-1">+ <span id="te_rAddQty">0</span> unité(s)</div>
                                            <div class="small text-muted">Nouveau stock</div>
                                            <div class="te-stock-number te-stock-new" id="te_rNewStock">0</div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Annuler</button>

                    <button type="submit" class="btn btn-filter" id="te_submit">
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        Enregistrer
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


{{-- Fenêtre de modification du prix de vente --}}
<div class="modal fade" id="editPriceModal" tabindex="-1"
     aria-labelledby="editPriceModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content price-modal">

            <form id="editPriceForm" method="POST" action="">
                @csrf
                @method('PATCH')

                <input type="hidden" name="q" value="{{ $search }}">
                <input type="hidden" name="page" value="{{ $products->currentPage() }}">

                <div class="modal-header">
                    <div>
                        <span class="modal-eyebrow">TARIFICATION</span>
                        <h2 class="modal-title" id="editPriceModalLabel">
                            Modifier le prix
                        </h2>
                    </div>

                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body">
                    <div class="modal-product-info mb-4">
                        <div class="modal-product-icon">
                            <i class="fa-solid fa-tags"></i>
                        </div>
                        <div>
                            <div class="modal-product-name" id="modalProductName">
                                Produit
                            </div>
                            <div class="modal-product-reference" id="modalProductReference">
                                Référence
                            </div>
                        </div>
                    </div>

                    <label for="modalSellingPrice" class="form-label">
                        Nouveau prix de vente (FCFA)
                    </label>

                    <input
                        type="number"
                        id="modalSellingPrice"
                        name="selling_price"
                        class="form-control modal-price-input"
                        min="0"
                        step="0.01"
                        required
                    >

                    <small class="text-muted d-block mt-2">
                        La marge sera recalculée après l'enregistrement.
                    </small>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel"
                            data-bs-dismiss="modal">
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-filter" id="savePriceButton">
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        Enregistrer
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .tarification-page {
        min-width: 0;
        color: #302637;
    }

    .page-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .page-title {
        margin: 0 0 7px;
        color: #30173D;
        font-size: clamp(1.4rem, 2vw, 1.9rem);
        font-weight: 750;
    }

    .page-subtitle {
        margin: 0;
        color: #77717c;
        font-size: 0.93rem;
    }

    /* Trois cartes de synthèse */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .summary-card {
        display: flex;
        align-items: center;
        gap: 16px;
        min-width: 0;
        padding: 22px;
        background: #fff;
        border: 1px solid #eee8f1;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(48, 23, 61, 0.045);
    }

    .summary-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 52px;
        width: 52px;
        height: 52px;
        border-radius: 14px;
        font-size: 1.25rem;
    }

    .summary-cost .summary-icon { color: #512264; background: #f1e8f6; }
    .summary-sale .summary-icon { color: #2471a3; background: #e8f3fb; }
    .summary-margin .summary-icon { color: #16835c; background: #e6f7ef; }

    .summary-content { min-width: 0; }

    .summary-label {
        display: block;
        margin-bottom: 8px;
        color: #716978;
        font-size: 0.84rem;
        font-weight: 600;
    }

    .summary-value {
        color: #30173D;
        font-size: clamp(1.1rem, 1.7vw, 1.65rem);
        font-weight: 750;
        line-height: 1.3;
        overflow-wrap: anywhere;
    }

    .summary-value span { font-size: 0.75rem; font-weight: 600; }
    .summary-value.negative-value { color: #c0392b; }

    .summary-description {
        display: block;
        margin-top: 7px;
        color: #928b98;
        font-size: 0.76rem;
        line-height: 1.4;
    }

    /* Filtrage */
    .filter-card {
        padding: 16px;
        background: #fff;
        border: 1px solid #eee8f1;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(48, 23, 61, 0.035);
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .filter-input-wrap {
        position: relative;
        flex: 1;
        min-width: 0;
    }

    .filter-input-wrap > i {
        position: absolute;
        top: 50%;
        left: 14px;
        z-index: 2;
        color: #8d7a98;
        transform: translateY(-50%);
    }

    .filter-input {
        min-height: 44px;
        padding-left: 42px;
        border: 1px solid #e4dce9;
        border-radius: 9px;
    }

    .filter-input:focus,
    .modal-price-input:focus {
        border-color: #8d63a0;
        box-shadow: 0 0 0 0.2rem rgba(81, 34, 100, 0.11);
    }

    .btn-filter {
        min-height: 44px;
        padding: 10px 18px;
        color: #fff;
        background: #512264;
        border: 1px solid #512264;
        border-radius: 9px;
        font-weight: 600;
        white-space: nowrap;
    }

    .btn-filter:hover,
    .btn-filter:focus {
        color: #fff;
        background: #6f42c1;
        border-color: #6f42c1;
    }

    /* Tableau */
    .table-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid #eee8f1;
        border-radius: 15px;
        box-shadow: 0 4px 18px rgba(48, 23, 61, 0.04);
    }

    .table-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 22px 24px;
    }

    .table-heading h2 {
        margin: 0 0 5px;
        color: #30173D;
        font-size: 1.08rem;
        font-weight: 750;
    }

    .table-heading p {
        margin: 0;
        color: #8a8290;
        font-size: 0.84rem;
    }

    .result-count {
        display: inline-flex;
        align-items: center;
        padding: 7px 12px;
        color: #512264;
        background: #f3edf7;
        border-radius: 20px;
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .pricing-table { width: 100%; min-width: 900px; }
    .te-table { min-width: 1250px; }

    .pricing-table thead th {
        padding: 15px 16px;
        color: #706579;
        background: #f8f6fa;
        border-top: 1px solid #eee8f1;
        border-bottom: 1px solid #eee8f1;
        font-size: 0.77rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.035em;
        white-space: nowrap;
    }

    .pricing-table tbody td {
        padding: 15px 16px;
        border-bottom: 1px solid #f0ecf2;
        color: #403746;
        font-size: 0.87rem;
    }

    .pricing-table tbody tr:last-child td { border-bottom: 0; }
    .pricing-table tbody tr:hover { background: #fcfaff; }

    .product-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 190px;
    }

    .product-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 36px;
        width: 36px;
        height: 36px;
        color: #512264;
        background: #f1eaf5;
        border-radius: 10px;
    }

    .product-name {
        color: #34263c;
        font-weight: 650;
        overflow-wrap: anywhere;
    }

    .reference-text { color: #766d7d; font-size: 0.84rem; }

    .currency { color: #89818e; font-size: 0.75rem; }

    .margin-value { font-weight: 700; white-space: nowrap; }
    .margin-positive { color: #16835c; }
    .margin-negative { color: #c0392b; }

    .margin-percent {
        display: block;
        margin-top: 4px;
        color: #8c8491;
        white-space: nowrap;
    }

    .btn-edit {
        padding: 7px 11px;
        color: #512264;
        background: #f5eff8;
        border: 1px solid #e8d9f0;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 650;
        white-space: nowrap;
    }

    .btn-edit:hover,
    .btn-edit:focus {
        color: #fff;
        background: #512264;
        border-color: #512264;
    }

    .empty-state { padding: 50px 20px; text-align: center; }

    .empty-state > i {
        margin-bottom: 15px;
        color: #a28eaf;
        font-size: 2rem;
    }

    .empty-state h3 { color: #30173D; font-size: 1.05rem; font-weight: 700; }
    .empty-state p { margin: 0; color: #837b89; }

    .pagination-wrapper { padding: 18px 22px; border-top: 1px solid #f0ecf2; }
    .pagination { flex-wrap: wrap; gap: 4px; margin-bottom: 0; }
    .pagination .page-link { color: #512264; border-radius: 6px; }

    .pagination .active .page-link {
        color: #fff;
        background: #512264;
        border-color: #512264;
    }

    /* Fenêtre Modifier */
    .price-modal {
        overflow: hidden;
        border: 0;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(30, 15, 38, 0.2);
    }

    .price-modal .modal-header { padding: 22px 24px; border-bottom: 1px solid #eee8f1; }

    .modal-eyebrow {
        display: block;
        margin-bottom: 5px;
        color: #8b6b9a;
        font-size: 0.7rem;
        font-weight: 750;
        letter-spacing: 0.12em;
    }

    .price-modal .modal-title { color: #30173D; font-size: 1.25rem; font-weight: 750; }
    .price-modal .modal-body { padding: 24px; }

    .modal-product-info {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 14px;
        background: #faf7fc;
        border: 1px solid #eee5f3;
        border-radius: 11px;
    }

    .modal-product-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 42px;
        width: 42px;
        height: 42px;
        color: #512264;
        background: #eee3f5;
        border-radius: 10px;
    }

    .modal-product-name { color: #30173D; font-weight: 700; overflow-wrap: anywhere; }
    .modal-product-reference { margin-top: 4px; color: #827789; font-size: 0.82rem; }

    .price-modal .form-label { color: #45394b; font-size: 0.88rem; font-weight: 650; }

    .modal-price-input {
        min-height: 46px;
        border: 1px solid #ddd2e5;
        border-radius: 9px;
        font-size: 1rem;
    }

    .price-modal .modal-footer { gap: 8px; padding: 16px 24px; border-top: 1px solid #eee8f1; }

    .btn-cancel {
        min-height: 42px;
        padding: 9px 16px;
        color: #554b5c;
        background: #fff;
        border: 1px solid #ded6e3;
        border-radius: 9px;
        font-weight: 600;
    }

    .btn-cancel:hover { background: #f7f4f9; }


    /* =========================================================
       NOUVELLE TARIFICATION
    ========================================================= */

    .te-modal {
        overflow: hidden;
        border: 0;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(30, 15, 38, 0.2);
    }

    .te-modal .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid #eee8f1;
        background: #fff;
    }

    .te-modal .modal-title { color: #30173D; font-size: 1.25rem; font-weight: 750; }

    .te-modal .te-body { padding: 22px 24px; background: #f6f4f9; }

    .te-modal .modal-footer {
        gap: 8px;
        padding: 16px 24px;
        border-top: 1px solid #eee8f1;
        background: #fff;
    }

    /* Le menu de recherche doit pouvoir dépasser de sa carte */
    .te-modal .section-card.te-visible { overflow: visible; }

    .te-modal .section-card .section-title { color: #30173D; }

    .te-modal .form-control:focus,
    .te-modal .form-select:focus {
        border-color: #8d63a0;
        box-shadow: 0 0 0 0.2rem rgba(81, 34, 100, 0.11);
    }

    .te-modal .section-number { color: #512264; background: #f1e8f6; }

    .te-sale-input { color: #512264; background: #f8f5ff; }

    .te-sticky { position: sticky; top: 0; }

    .te-recap-title {
        margin: 16px 0 6px;
        padding-top: 12px;
        border-top: 1px dashed #e5deea;
        color: #8b6b9a;
        font-size: 0.7rem;
        font-weight: 750;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .te-sale-text { color: #512264; }

    .te-stock-preview {
        margin-top: 16px;
        padding: 14px;
        text-align: center;
        background: linear-gradient(135deg, #f7f2ff, #fff);
        border: 1px solid #e2d6f7;
        border-radius: 12px;
    }

    .te-stock-number { color: #30173D; font-size: 1.5rem; font-weight: 750; line-height: 1.2; }
    .te-stock-number.te-stock-new { color: #16835c; }

    .te-expense-table th {
        color: #706579;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .te-expense-table td { padding-left: 4px; padding-right: 4px; }

    /* Tablette */
    @media (max-width: 991.98px) {
        .summary-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .summary-card:last-child { grid-column: 1 / -1; }
        .pricing-table { min-width: 850px; }
        .te-table { min-width: 1150px; }
        .te-sticky { position: static; }
    }

    /* Téléphone */
    @media (max-width: 575.98px) {
        .page-heading { flex-direction: column; align-items: stretch; }
        .page-heading .btn-filter { width: 100%; }

        .page-title { font-size: 1.45rem; }
        .page-subtitle { font-size: 0.85rem; line-height: 1.5; }

        .summary-grid { grid-template-columns: minmax(0, 1fr); gap: 12px; }

        .summary-card,
        .summary-card:last-child { grid-column: auto; padding: 17px; }

        .summary-icon { flex-basis: 45px; width: 45px; height: 45px; }
        .summary-value { font-size: 1.35rem; }

        .filter-card { padding: 12px; }
        .filter-form { flex-direction: column; align-items: stretch; }
        .filter-input-wrap,
        .btn-filter { width: 100%; }

        .table-heading { padding: 17px 14px; }
        .pricing-table { min-width: 820px; }
        .te-table { min-width: 1100px; }

        .pricing-table thead th,
        .pricing-table tbody td { padding: 12px; }

        .pagination-wrapper { padding: 14px; overflow-x: auto; }

        .price-modal .modal-header,
        .price-modal .modal-body,
        .price-modal .modal-footer { padding: 17px; }

        .price-modal .modal-footer { display: grid; grid-template-columns: 1fr 1fr; }
        .price-modal .modal-footer .btn { width: 100%; }

       
        .te-modal .modal-header,
        .te-modal .modal-footer { padding: 14px 16px; }

        .te-modal .te-body { padding: 14px; }

        .te-modal .modal-footer { display: grid; grid-template-columns: 1fr 1fr; }
        .te-modal .modal-footer .btn { width: 100%; }
    }

/* =========================================================
   CORRECTION DU DÉFILEMENT — NOUVELLE TARIFICATION
========================================================= */

#pricingEntryModal {
    overflow: hidden;
}

#pricingEntryModal .modal-dialog {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 3.5rem);
    max-height: calc(100vh - 3.5rem);
    min-height: 0;
}

#pricingEntryModal .modal-content {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    height: 100%;
    max-height: 100%;
    min-height: 0;
    overflow: hidden;
}

/* Le formulaire doit aussi participer à la mise en page flex */
#pricingEntryModal #pricingEntryForm {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    height: 100%;
    min-height: 0;
    overflow: hidden;
}

#pricingEntryModal .modal-header,
#pricingEntryModal .modal-footer {
    flex: 0 0 auto;
    background: #fff;
    z-index: 2;
}

#pricingEntryModal .modal-body {
    flex: 1 1 auto;
    height: 0;
    min-height: 0;
    overflow-y: auto !important;
    overflow-x: hidden;
    overscroll-behavior-y: contain;
    -webkit-overflow-scrolling: touch;
}

/* Barre de défilement visible dans les navigateurs compatibles */
#pricingEntryModal .modal-body::-webkit-scrollbar {
    width: 10px;
}

#pricingEntryModal .modal-body::-webkit-scrollbar-track {
    background: #eee8f1;
    border-radius: 10px;
}

#pricingEntryModal .modal-body::-webkit-scrollbar-thumb {
    background: #8d63a0;
    border: 2px solid #eee8f1;
    border-radius: 10px;
}

#pricingEntryModal .modal-body::-webkit-scrollbar-thumb:hover {
    background: #512264;
}

/* La liste de résultats de recherche reste au-dessus du formulaire */
#pricingEntryModal .section-card.te-visible {
    overflow: visible;
}

#pricingEntryModal .product-search-wrapper {
    position: relative;
}

#pricingEntryModal .product-results {
    z-index: 1056;
}

/* Tablettes */
@media (max-width: 991.98px) {
    #pricingEntryModal .modal-dialog {
        height: calc(100vh - 2rem);
        max-height: calc(100vh - 2rem);
    }

    #pricingEntryModal .te-sticky {
        position: static;
    }
}

/* Téléphones */
@media (max-width: 575.98px) {
    #pricingEntryModal .modal-dialog {
        width: 100%;
        max-width: none;
        height: 100vh;
        height: 100dvh;
        max-height: 100vh;
        max-height: 100dvh;
        margin: 0;
    }

    #pricingEntryModal .modal-content {
        width: 100%;
        height: 100vh;
        height: 100dvh;
        max-height: 100vh;
        max-height: 100dvh;
        border-radius: 0;
    }

    #pricingEntryModal .modal-body {
        padding: 14px;
    }

    #pricingEntryModal .modal-header,
    #pricingEntryModal .modal-footer {
        padding: 14px 16px;
    }

    #pricingEntryModal .modal-footer {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    #pricingEntryModal .modal-footer .btn {
        width: 100%;
    }
}

</style>
@endpush

@push('scripts')
<script>
    /* =========================================================
       MODAL « MODIFIER LE PRIX »
    ========================================================= */
    document.addEventListener('DOMContentLoaded', function () {
        const editModal = document.getElementById('editPriceModal');
        const editForm = document.getElementById('editPriceForm');
        const productName = document.getElementById('modalProductName');
        const productReference = document.getElementById('modalProductReference');
        const sellingPrice = document.getElementById('modalSellingPrice');

        if (!editModal || !editForm || !sellingPrice) {
            return;
        }

        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            if (!button) {
                return;
            }

            editForm.action = button.getAttribute('data-update-url') || '';
            productName.textContent = button.getAttribute('data-product-name') || 'Produit';
            productReference.textContent = 'Réf. : ' +
                (button.getAttribute('data-product-reference') || '—');
            sellingPrice.value = button.getAttribute('data-current-price') || '0';
        });
    });


    /* =========================================================
       MODAL « NOUVELLE TARIFICATION »
    ========================================================= */
    document.addEventListener('DOMContentLoaded', function () {

        const modalEl = document.getElementById('pricingEntryModal');
        const form    = document.getElementById('pricingEntryForm');

        if (!modalEl || !form) {
            return;
        }

        const $ = id => document.getElementById(id);

        const RATES         = @json($rates);
        const CURRENCIES    = @json(array_keys($currencies));
        const EXPENSE_TYPES = @json($expenseTypes);
        const OLD_EXPENSES  = @json(old('expenses', []));
        const OPEN_ON_LOAD  = {{ ($errors->any() && old('product_id')) ? 'true' : 'false' }};

        const nf  = new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 2 });
        const fmt = v => nf.format(Number.isFinite(v) ? v : 0);

        let selectedStock = 0;
        let expenseIndex  = 0;

        /* ---------- Taux de change ---------- */

        function rateFor(currency) {
            if (currency === 'XOF') { return 1; }
            return Number(RATES[currency]) || 0;
        }

        /* ---------- Fournisseur ---------- */

        const supplier        = $('te_supplier');
        const newSupplierWrap = $('te_newSupplierWrap');
        const newSupplier     = $('te_newSupplier');

        function toggleNewSupplier() {
            const isNew = supplier.value === '__new';
            newSupplierWrap.classList.toggle('d-none', !isNew);
            if (!isNew) { newSupplier.value = ''; }
        }

        supplier.addEventListener('change', function () {
            toggleNewSupplier();
            update();
        });
        newSupplier.addEventListener('input', update);

        /* ---------- Recherche de produit ---------- */

        const search  = $('te_productSearch');
        const results = $('te_productResults');
        const noMatch = $('te_noProduct');
        const items   = () => results.querySelectorAll('.product-result-item');

        function filterItems() {
            const term = search.value.toLowerCase().trim();
            let visible = 0;

            items().forEach(function (item) {
                const ok = item.dataset.name.toLowerCase().includes(term) ||
                           (item.dataset.reference || '').toLowerCase().includes(term);
                item.style.display = ok ? '' : 'none';
                if (ok) { visible++; }
            });

            noMatch.classList.toggle('d-none', visible > 0 || items().length === 0);
        }

        search.addEventListener('focus', function () {
            filterItems();
            results.classList.add('show');
        });

        search.addEventListener('input', function () {
            filterItems();
            results.classList.add('show');
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('#te_searchWrapper')) {
                results.classList.remove('show');
            }
        });

        function selectProduct(item, prefill) {

            $('te_product_id').value = item.dataset.id;
            $('te_selectedName').textContent = item.dataset.name;
            $('te_selectedRef').textContent  = item.dataset.reference || '—';
            $('te_selectedType').textContent = item.dataset.type === 'piece' ? 'Pièce détachée' : 'Véhicule';

            const cost = parseFloat(item.dataset.cost) || 0;
            const sale = parseFloat(item.dataset.price) || 0;

            $('te_selectedCost').textContent = cost > 0 ? fmt(cost) + ' XOF' : '-';
            $('te_selectedProduct').classList.add('show');

            search.value  = item.dataset.name;
            selectedStock = parseFloat(item.dataset.stock) || 0;

            if (prefill) {
                const unit = item.dataset.unit;
                if (unit && $('te_unit').querySelector('option[value="' + unit + '"]')) {
                    $('te_unit').value = unit;
                }
                // Reprend la marge actuelle du produit comme point de départ
                if (cost > 0 && sale > cost) {
                    $('te_margin').value = ((sale - cost) / cost * 100).toFixed(1);
                }
            }

            results.classList.remove('show');
            update();
        }

        results.addEventListener('click', function (e) {
            const item = e.target.closest('.product-result-item');
            if (item) { selectProduct(item, true); }
        });

        /* ---------- Frais annexes ---------- */

        const expensesBody = $('te_expensesBody');

        function addExpense(data) {

            data = data || {};

            const i = expenseIndex++;

            const typeOptions = Object.entries(EXPENSE_TYPES)
                .map(function (entry) {
                    return '<option value="' + entry[0] + '">' + entry[1] + '</option>';
                }).join('');

            const currencyOptions = CURRENCIES
                .map(function (code) {
                    return '<option value="' + code + '">' + code + '</option>';
                }).join('');

            const row = document.createElement('tr');
            row.className = 'te-expense-row';

            row.innerHTML =
                '<td><select name="expenses[' + i + '][type]" class="form-select te-expense-type">' + typeOptions + '</select></td>' +
                '<td><input type="text" name="expenses[' + i + '][description]" class="form-control te-expense-desc" placeholder="Description"></td>' +
                '<td><input type="number" name="expenses[' + i + '][amount]" class="form-control te-expense-amount" min="0" step="0.01" value="0"></td>' +
                '<td><select name="expenses[' + i + '][currency]" class="form-select te-expense-currency">' + currencyOptions + '</select></td>' +
                '<td><button type="button" class="btn btn-sm btn-light border te-remove-expense" title="Retirer">' +
                    '<i class="fa-solid fa-trash"></i></button></td>';

            expensesBody.appendChild(row);

            if (data.type)                 { row.querySelector('.te-expense-type').value = data.type; }
            if (data.description)          { row.querySelector('.te-expense-desc').value = data.description; }
            if (data.amount !== undefined) { row.querySelector('.te-expense-amount').value = data.amount; }
            if (data.currency)             { row.querySelector('.te-expense-currency').value = data.currency; }

            row.querySelectorAll('input, select').forEach(function (el) {
                el.addEventListener('input', update);
                el.addEventListener('change', update);
            });

            row.querySelector('.te-remove-expense').addEventListener('click', function () {
                row.remove();
                update();
            });

            update();
        }

        $('te_addExpense').addEventListener('click', function () { addExpense(); });

        /* ---------- Calculs + historique ---------- */

        function update() {

            const qty      = parseFloat($('te_quantity').value) || 0;
            const price    = parseFloat($('te_unit_price').value) || 0;
            const currency = $('te_currency').value;
            const margin   = Math.max(0, parseFloat($('te_margin').value) || 0);

            const rate = rateFor(currency);

            document.querySelectorAll('.te-currency-label').forEach(function (el) {
                el.textContent = currency;
            });

            // Taux transmis au contrôleur (aucune saisie manuelle)
            $('te_exchange_rate').value = (currency !== 'XOF' && rate > 0) ? rate : '';

            // Aide taux
            const help = $('te_rateHelp');

            if (currency === 'XOF') {
                help.className = 'small mt-3 text-muted';
                help.innerHTML = '<i class="fa-solid fa-circle-info me-1"></i>Montant déjà en FCFA, aucune conversion.';
            } else if (rate > 0) {
                help.className = 'small mt-3 text-muted';
                help.innerHTML = '<i class="fa-solid fa-circle-check text-success me-1"></i>' +
                    'Taux automatique : 1 ' + currency + ' = <strong>' + fmt(rate) + '</strong> XOF';
            } else {
                help.className = 'small mt-3 text-danger';
                help.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i>' +
                    'Aucun taux enregistré pour ' + currency + '. Mettez à jour les taux de change avant de continuer.';
            }

            // Achat
            const purchaseXof = qty * price * rate;
            $('te_purchaseXof').value = fmt(purchaseXof);

            // Frais
            let expenses = 0;
            const rows = document.querySelectorAll('.te-expense-row');
            const expenseLines = [];

            rows.forEach(function (row) {
                const amount = parseFloat(row.querySelector('.te-expense-amount').value) || 0;
                const cur    = row.querySelector('.te-expense-currency').value;
                const typeSel = row.querySelector('.te-expense-type');
                const typeLabel = typeSel.options[typeSel.selectedIndex]
                    ? typeSel.options[typeSel.selectedIndex].text : '';

                expenses += amount * rateFor(cur);

                if (amount > 0) {
                    expenseLines.push(typeLabel + ' : ' + fmt(amount) + ' ' + cur);
                }
            });

            $('te_emptyExpense').style.display = rows.length ? 'none' : 'block';
            $('te_expensesTotal').textContent  = fmt(expenses) + ' XOF';

            // Prix de revient
            const totalCost = purchaseXof + expenses;
            const unitCost  = qty > 0 ? totalCost / qty : 0;

            $('te_costPurchase').textContent = fmt(purchaseXof) + ' XOF';
            $('te_costExpenses').textContent = fmt(expenses) + ' XOF';
            $('te_totalCost').textContent    = fmt(totalCost) + ' XOF';
            $('te_unitCost').textContent     = fmt(unitCost) + ' XOF';

            // Marge + prix de vente (arrondi à l'entier supérieur)
            const sale        = Math.ceil(unitCost * (1 + margin / 100) - 1e-9);
            const unitMargin  = sale - unitCost;
            const totalMargin = unitMargin * qty;

            $('te_selling_price').value = Math.max(0, sale);
            $('te_unitMargin').value    = fmt(unitMargin);

            // Historique (récapitulatif)
            const supplierText = supplier.value === '__new'
                ? (newSupplier.value.trim() || '—')
                : (supplier.value ? supplier.options[supplier.selectedIndex].text.trim() : '—');

            $('te_rProduct').textContent   = $('te_selectedName').textContent || '—';
            $('te_rRef').textContent       = $('te_selectedRef').textContent || '—';
            $('te_rSupplier').textContent  = supplierText;
            $('te_rQty').textContent       = fmt(qty);
            $('te_rCurrency').textContent  = currency;
            $('te_rRate').textContent      = currency === 'XOF' ? '—' : (rate > 0 ? fmt(rate) : 'Non défini');
            $('te_rUnitPrice').textContent = fmt(price) + ' ' + currency;
            $('te_rPurchase').textContent  = fmt(purchaseXof) + ' XOF';

            $('te_rExpenses').innerHTML = expenseLines.length
                ? expenseLines.map(function (l) {
                      return '<div>' + l.replace(/</g, '&lt;') + '</div>';
                  }).join('')
                : 'Aucun frais.';
            $('te_rExpensesTotal').textContent = fmt(expenses) + ' XOF';

            $('te_rTotalCost').textContent   = fmt(totalCost) + ' XOF';
            $('te_rUnitCost').textContent    = fmt(unitCost) + ' XOF';
            $('te_rMarginPct').textContent   = fmt(margin) + ' %';
            $('te_rUnitMargin').textContent  = fmt(unitMargin) + ' XOF';
            $('te_rSale').textContent        = fmt(sale) + ' XOF';
            $('te_rTotalMargin').textContent = fmt(totalMargin) + ' XOF';

            $('te_rCurrentStock').textContent = fmt(selectedStock);
            $('te_rAddQty').textContent       = fmt(qty);
            $('te_rNewStock').textContent     = fmt(selectedStock + qty);
        }

        ['te_quantity', 'te_unit_price', 'te_margin'].forEach(function (id) {
            $(id).addEventListener('input', update);
        });
        $('te_currency').addEventListener('change', update);

        /* ---------- Envoi ---------- */

        form.addEventListener('submit', function (e) {

            if (!$('te_product_id').value) {
                e.preventDefault();
                alert('Veuillez sélectionner un produit.');
                search.focus();
                return;
            }

            const currency = $('te_currency').value;

            if (rateFor(currency) <= 0) {
                e.preventDefault();
                alert('Aucun taux de change enregistré pour ' + currency + '.');
                return;
            }

            let missingExpenseRate = null;

            document.querySelectorAll('.te-expense-row').forEach(function (row) {
                const amount = parseFloat(row.querySelector('.te-expense-amount').value) || 0;
                const cur    = row.querySelector('.te-expense-currency').value;
                if (amount > 0 && rateFor(cur) <= 0) { missingExpenseRate = cur; }
            });

            if (missingExpenseRate) {
                e.preventDefault();
                alert('Aucun taux de change enregistré pour ' + missingExpenseRate + ' (frais annexes).');
                return;
            }

            if (supplier.value === '__new') {
                if (!newSupplier.value.trim()) {
                    e.preventDefault();
                    alert('Veuillez saisir le nom du nouveau fournisseur.');
                    newSupplier.focus();
                    return;
                }
                supplier.disabled = true; // seul new_supplier est envoyé
            } else if (!supplier.value) {
                e.preventDefault();
                alert('Veuillez choisir un fournisseur.');
                supplier.focus();
                return;
            }

            const button = $('te_submit');
            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Enregistrement...';
        });

        /* ---------- Réinitialisation à la fermeture ---------- */

        modalEl.addEventListener('hidden.bs.modal', function () {

            form.reset();
            supplier.disabled = false;

            expensesBody.innerHTML = '';
            expenseIndex = 0;

            $('te_product_id').value = '';
            $('te_selectedProduct').classList.remove('show');
            search.value  = '';
            selectedStock = 0;

            $('te_quantity').value   = 1;
            $('te_unit_price').value = 0;
            $('te_margin').value     = 0;

            const button = $('te_submit');
            button.disabled = false;
            button.innerHTML = '<i class="fa-solid fa-floppy-disk me-2"></i>Enregistrer';

            toggleNewSupplier();
            update();
        });

        /* ---------- Initialisation (réaffichage après erreur) ---------- */

        Object.values(OLD_EXPENSES || {}).forEach(function (expense) { addExpense(expense); });

        const oldProduct = $('te_product_id').value;

        if (oldProduct) {
            const item = results.querySelector('.product-result-item[data-id="' + oldProduct + '"]');
            if (item) { selectProduct(item, false); }
        }

        toggleNewSupplier();
        update();

        if (OPEN_ON_LOAD && window.bootstrap) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        }
    });
</script>
@endpush
