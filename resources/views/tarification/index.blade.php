
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
                Consultez les prix et modifiez le prix de vente de vos produits.
            </p>
        </div>
    </div>

    {{-- Une seule notification de succès --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    {{-- Erreurs --}}
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <div class="fw-semibold mb-2">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                Impossible d'enregistrer le prix.
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
                <span class="summary-description">Coût total des produits filtrés</span>
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
                <span class="summary-description">Valeur totale aux prix de vente actuels</span>
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

    {{-- Tableau des produits --}}
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
            <table class="table pricing-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Référence</th>
                        <th>Type</th>
                        <th class="text-end">Prix de revient</th>
                        <th class="text-end">Prix de vente</th>
                        <th class="text-end">Marge</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $product)
                        @php
                            $cost = (float) ($product->purchase_price ?? 0);
                            $sale = (float) ($product->selling_price ?? 0);
                            $margin = $sale - $cost;
                            $marginPercent = $cost > 0
                                ? ($margin / $cost) * 100
                                : 0;
                            $isVehicle = ($product->type ?? '') === 'vehicule';
                        @endphp

                        <tr>
                            <td>
                                <div class="product-cell">
                                    <div class="product-avatar">
                                        <i class="fa-solid {{ $isVehicle ? 'fa-car' : 'fa-gears' }}"></i>
                                    </div>
                                    <span class="product-name">
                                        {{ $product->name }}
                                    </span>
                                </div>
                            </td>

                            <td>
                                <span class="reference-text">
                                    {{ $product->reference ?? '—' }}
                                </span>
                            </td>

                            <td>
                                <span class="type-badge {{ $isVehicle ? 'type-vehicle' : 'type-piece' }}">
                                    {{ $isVehicle ? 'Véhicule' : 'Pièce détachée' }}
                                </span>
                            </td>

                            <td class="text-end text-nowrap">
                                {{ number_format($cost, 0, ',', ' ') }}
                                <span class="currency">FCFA</span>
                            </td>

                            <td class="text-end text-nowrap fw-semibold">
                                {{ number_format($sale, 0, ',', ' ') }}
                                <span class="currency">FCFA</span>
                            </td>

                            <td class="text-end">
                                <div class="margin-value {{ $margin < 0 ? 'margin-negative' : 'margin-positive' }}">
                                    {{ number_format($margin, 0, ',', ' ') }} FCFA
                                </div>
                                <small class="margin-percent">
                                    {{ number_format($marginPercent, 2, ',', ' ') }} %
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
                            <td colspan="7">
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

{{-- Fenêtre de modification --}}
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

    .summary-cost .summary-icon {
        color: #512264;
        background: #f1e8f6;
    }

    .summary-sale .summary-icon {
        color: #2471a3;
        background: #e8f3fb;
    }

    .summary-margin .summary-icon {
        color: #16835c;
        background: #e6f7ef;
    }

    .summary-content {
        min-width: 0;
    }

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

    .summary-value span {
        font-size: 0.75rem;
        font-weight: 600;
    }

    .summary-value.negative-value {
        color: #c0392b;
    }

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

    .pricing-table {
        width: 100%;
        min-width: 900px;
    }

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

    .pricing-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .pricing-table tbody tr:hover {
        background: #fcfaff;
    }

    .product-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 180px;
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

    .reference-text {
        color: #766d7d;
        font-size: 0.84rem;
    }

    .type-badge {
        display: inline-block;
        padding: 6px 9px;
        border-radius: 6px;
        font-size: 0.76rem;
        font-weight: 650;
        white-space: nowrap;
    }

    .type-vehicle {
        color: #285e9b;
        background: #eaf2fc;
    }

    .type-piece {
        color: #67428a;
        background: #f1eafa;
    }

    .currency {
        color: #89818e;
        font-size: 0.75rem;
    }

    .margin-value {
        font-weight: 700;
        white-space: nowrap;
    }

    .margin-positive {
        color: #16835c;
    }

    .margin-negative {
        color: #c0392b;
    }

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

    .empty-state {
        padding: 50px 20px;
        text-align: center;
    }

    .empty-state > i {
        margin-bottom: 15px;
        color: #a28eaf;
        font-size: 2rem;
    }

    .empty-state h3 {
        color: #30173D;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .empty-state p {
        margin: 0;
        color: #837b89;
    }

    .pagination-wrapper {
        padding: 18px 22px;
        border-top: 1px solid #f0ecf2;
    }

    .pagination {
        flex-wrap: wrap;
        gap: 4px;
        margin-bottom: 0;
    }

    .pagination .page-link {
        color: #512264;
        border-radius: 6px;
    }

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

    .price-modal .modal-header {
        padding: 22px 24px;
        border-bottom: 1px solid #eee8f1;
    }

    .modal-eyebrow {
        display: block;
        margin-bottom: 5px;
        color: #8b6b9a;
        font-size: 0.7rem;
        font-weight: 750;
        letter-spacing: 0.12em;
    }

    .price-modal .modal-title {
        color: #30173D;
        font-size: 1.25rem;
        font-weight: 750;
    }

    .price-modal .modal-body {
        padding: 24px;
    }

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

    .modal-product-name {
        color: #30173D;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .modal-product-reference {
        margin-top: 4px;
        color: #827789;
        font-size: 0.82rem;
    }

    .price-modal .form-label {
        color: #45394b;
        font-size: 0.88rem;
        font-weight: 650;
    }

    .modal-price-input {
        min-height: 46px;
        border: 1px solid #ddd2e5;
        border-radius: 9px;
        font-size: 1rem;
    }

    .price-modal .modal-footer {
        gap: 8px;
        padding: 16px 24px;
        border-top: 1px solid #eee8f1;
    }

    .btn-cancel {
        min-height: 42px;
        padding: 9px 16px;
        color: #554b5c;
        background: #fff;
        border: 1px solid #ded6e3;
        border-radius: 9px;
        font-weight: 600;
    }

    .btn-cancel:hover {
        background: #f7f4f9;
    }

    /* Tablette */
    @media (max-width: 991.98px) {
        .summary-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .summary-card:last-child {
            grid-column: 1 / -1;
        }

        .pricing-table {
            min-width: 850px;
        }
    }

    /* Téléphone */
    @media (max-width: 575.98px) {
        .page-title {
            font-size: 1.45rem;
        }

        .page-subtitle {
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .summary-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 12px;
        }

        .summary-card,
        .summary-card:last-child {
            grid-column: auto;
            padding: 17px;
        }

        .summary-icon {
            flex-basis: 45px;
            width: 45px;
            height: 45px;
        }

        .summary-value {
            font-size: 1.35rem;
        }

        .filter-card {
            padding: 12px;
        }

        .filter-form {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-input-wrap,
        .btn-filter {
            width: 100%;
        }

        .table-heading {
            padding: 17px 14px;
        }

        .pricing-table {
            min-width: 820px;
        }

        .pricing-table thead th,
        .pricing-table tbody td {
            padding: 12px;
        }

        .pagination-wrapper {
            padding: 14px;
            overflow-x: auto;
        }

        .price-modal .modal-header,
        .price-modal .modal-body,
        .price-modal .modal-footer {
            padding: 17px;
        }

        .price-modal .modal-footer {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .price-modal .modal-footer .btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
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
</script>
@endpush
