@extends('layouts.stock')

@section('title', 'Nouvelle entrée de stock')
@section('crumb', 'Nouvelle entrée de stock')

@section('content')

<div class="mb-4 d-flex justify-content-between align-items-start gap-2 flex-wrap">
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

    {{-- 1. INFORMATIONS --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-number">1</div>
            <div>
                <h2 class="section-title">Informations de l'approvisionnement</h2>
                <p class="section-description">Source et date de l'entrée en stock.</p>
            </div>
        </div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Numéro d'achat</label>
                    <input type="text" class="form-control" value="{{ $nextNumber }}" readonly>
                    <div class="form-text">Attribué définitivement à l'enregistrement.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="purchase_date">Date de l'achat <span class="required">*</span></label>
                    <input type="date" name="purchase_date" id="purchase_date" class="form-control"
                           value="{{ old('purchase_date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                </div>

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
                    <label class="form-label" for="supplier_reference">Référence fournisseur</label>
                    <input type="text" name="supplier_reference" id="supplier_reference" class="form-control"
                           placeholder="Facture / BL" value="{{ old('supplier_reference') }}">
                </div>

                <div class="col-12">
                    <label class="form-label" for="observation">Observation</label>
                    <textarea name="observation" id="observation" class="form-control" rows="3"
                              placeholder="Informations complémentaires…">{{ old('observation') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. PRODUIT --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-number">2</div>
            <div>
                <h2 class="section-title">Produit à approvisionner</h2>
                <p class="section-description">Sélectionnez le produit qui entre en stock.</p>
            </div>
        </div>
        <div class="section-body">
            <label class="form-label">Rechercher un produit <span class="required">*</span></label>

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
                            <div class="small text-muted">Réf. {{ $product->reference }} · Stock : {{ $product->quantity }}</div>
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
                    <span class="badge bg-light text-dark border" id="selectedProductType"></span>
                </div>
            </div>

            <input type="hidden" name="product_id" id="productId" value="{{ old('product_id') }}">

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

    {{-- 3. PRIX D'ACHAT --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-number">3</div>
            <div>
                <h2 class="section-title">Prix d'achat et devise</h2>
                <p class="section-description">Le prix peut être saisi en Naira ou en Franc CFA.</p>
            </div>
        </div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="currency">Devise d'achat <span class="required">*</span></label>
                    <select name="currency" id="currency" class="form-select">
                        @foreach($currencies as $value => $label)
                            <option value="{{ $value }}" {{ old('currency', 'NGN') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="unit_price">Prix d'achat unitaire <span class="required">*</span></label>
                    <div class="input-group">
                        <input type="number" name="unit_price" id="unit_price" class="form-control"
                               min="0" step="0.01" value="{{ old('unit_price', 0) }}" required>
                        <span class="input-group-text currency-label">NGN</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Total prix d'achat</label>
                    <div class="input-group">
                        <input type="text" id="purchaseTotal" class="form-control" value="0" readonly>
                        <span class="input-group-text currency-label">NGN</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="exchange_rate">Taux de change <span class="small text-muted">(utilisé si NGN)</span></label>
                    <div class="input-group">
                        <span class="input-group-text">1 NGN =</span>
                        <input type="number" name="exchange_rate" id="exchange_rate" class="form-control"
                               min="0" step="0.00000001" value="{{ old('exchange_rate', $rate?->rate) }}">
                        <span class="input-group-text">XOF</span>
                    </div>
                    <div class="form-text">
                        @if($rate)
                            <i class="bi {{ $rate->isStale() ? 'bi-exclamation-triangle text-warning' : 'bi-check-circle text-success' }} me-1"></i>
                            Taux du {{ $rate->rate_date->format('d/m/Y') }} ({{ $rate->source }}) —
                            {{ $rate->isStale() ? 'non à jour' : 'à jour' }}. Le taux utilisé est conservé avec l'achat.
                        @else
                            <i class="bi bi-exclamation-triangle text-warning me-1"></i>
                            Aucun taux enregistré. Saisissez-le ou lancez <code>php artisan rates:update</code>.
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Équivalent en FCFA</label>
                    <div class="input-group">
                        <input type="text" id="convertedTotal" class="form-control fw-semibold" value="0" readonly>
                        <span class="input-group-text">XOF</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. FRAIS ANNEXES --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-number">4</div>
            <div class="flex-grow-1">
                <h2 class="section-title">Frais annexes</h2>
                <p class="section-description">Transport, douane, manutention, frais de dossier, etc.</p>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="addExpense">
                <i class="bi bi-plus-lg me-1"></i>Ajouter un frais
            </button>
        </div>
        <div class="section-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr><th>Type</th><th>Description</th><th style="width:160px">Montant</th><th style="width:100px">Devise</th><th></th></tr>
                    </thead>
                    <tbody id="expensesBody"></tbody>
                </table>
            </div>
            <div class="text-center text-muted py-3" id="emptyExpense">
                <i class="bi bi-receipt fs-4 d-block mb-1"></i>Aucun frais annexe ajouté.
            </div>
            <div class="text-end mt-3">
                <span class="text-muted">Total des frais :</span>
                <strong id="expensesTotal">0 XOF</strong>
            </div>
        </div>
    </div>

    {{-- 5. PRIX DE REVIENT --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-number">5</div>
            <div>
                <h2 class="section-title">Calcul du prix de revient</h2>
                <p class="section-description">Prix de revient = prix d'achat + somme des frais annexes.</p>
            </div>
        </div>
        <div class="section-body">
            <div class="calculation-box">
                <div class="calculation-row"><span class="text-muted">Prix d'achat en FCFA</span><strong id="costPurchase">0 XOF</strong></div>
                <div class="calculation-row"><span class="text-muted">Total des frais annexes</span><strong id="costExpenses">0 XOF</strong></div>
                <div class="calculation-row total"><span>Prix de revient total</span><span id="totalCost">0 XOF</span></div>
                <div class="calculation-row"><span class="text-muted">Prix de revient unitaire</span><strong id="unitCost">0 XOF</strong></div>
            </div>
        </div>
    </div>

    {{-- 6. TARIFICATION --}}
    <div class="section-card">
        <div class="section-header">
            <div class="section-number">6</div>
            <div>
                <h2 class="section-title">Tarification</h2>
                <p class="section-description">Prix de vente souhaité et marge.</p>
            </div>
        </div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="selling_price">Prix de vente unitaire <span class="required">*</span></label>
                    <div class="input-group">
                        <input type="number" name="selling_price" id="selling_price" class="form-control"
                               min="0" step="0.01" value="{{ old('selling_price', 0) }}" required>
                        <span class="input-group-text">XOF</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Marge unitaire</label>
                    <div class="input-group">
                        <input type="text" id="unitMargin" class="form-control fw-semibold" value="0" readonly>
                        <span class="input-group-text">XOF</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Marge %</label>
                    <input type="text" id="marginPercentage" class="form-control" value="0 %" readonly>
                </div>
                <div class="col-12">
                    <div class="alert alert-light border mb-0">
                        Marge totale sur cette entrée : <strong id="totalMargin">0 XOF</strong>
                    </div>
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
            <div class="info-line"><span class="text-muted">Devise d'origine</span><strong id="traceCurrency">NGN</strong></div>
            <div class="info-line"><span class="text-muted">Taux utilisé</span><strong id="traceRate">-</strong></div>
            <div class="small text-muted mt-2">La date et l'heure d'enregistrement sont ajoutées automatiquement.</div>
        </div>
    </div>

    <div class="alert alert-warning">
        <i class="bi bi-info-circle-fill me-2"></i><strong>Rappel :</strong>
        la validation augmente le stock, met à jour le prix de revient et le prix de vente du produit, et crée un mouvement d'entrée.
    </div>

</div>
</div>
</div>

<div class="bottom-actions">
    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('stock.index') }}" class="btn btn-light border">Annuler</a>
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
    const fmt = v => new Intl.NumberFormat('fr-FR', { maximumFractionDigits: 2 }).format(v);

    const expenseTypes = @json($expenseTypes);
    const oldExpenses  = @json(old('expenses', []));

    let selectedStock = 0;
    let expenseIndex  = 0;

    /* ---------- Fournisseur ---------- */
    const supplierSelect = $('supplierSelect');
    const newSupplier    = $('newSupplier');

    function toggleNewSupplier() {
        const isNew = supplierSelect.value === '__new';
        newSupplier.classList.toggle('d-none', !isNew);
        if (!isNew) newSupplier.value = '';
    }
    supplierSelect.addEventListener('change', toggleNewSupplier);
    toggleNewSupplier();

    /* ---------- Produit ---------- */
    const productSearch  = $('productSearch');
    const productResults = $('productResults');
    const items = () => document.querySelectorAll('.product-result-item');

    productSearch.addEventListener('focus', () => productResults.classList.add('show'));
    productSearch.addEventListener('input', function () {
        const s = productSearch.value.toLowerCase().trim();
        items().forEach(i => {
            const ok = i.dataset.name.toLowerCase().includes(s) || i.dataset.reference.toLowerCase().includes(s);
            i.style.display = ok ? '' : 'none';
        });
        productResults.classList.add('show');
    });
    document.addEventListener('click', e => {
        if (!e.target.closest('.product-search-wrapper')) productResults.classList.remove('show');
    });

    function selectProduct(item, fillPrices) {
        $('productId').value = item.dataset.id;
        $('selectedProductName').textContent = item.dataset.name;
        $('selectedProductReference').textContent = item.dataset.reference;
        $('selectedProductType').textContent = item.dataset.type === 'piece' ? 'Pièce détachée' : 'Véhicule';
        const cost = parseFloat(item.dataset.cost) || 0;
        $('selectedProductCost').textContent = cost > 0 ? fmt(cost) + ' XOF' : '-';
        $('selectedProduct').classList.add('show');
        $('previewProduct').textContent = item.dataset.name;
        productSearch.value = item.dataset.name;
        selectedStock = parseFloat(item.dataset.stock) || 0;

        if (fillPrices) {
            $('selling_price').value = item.dataset.price || 0;
            const unit = item.dataset.unit;
            if (unit && $('unit').querySelector('option[value="' + unit + '"]')) $('unit').value = unit;
        }
        productResults.classList.remove('show');
        update();
    }

    productResults.addEventListener('click', e => {
        const item = e.target.closest('.product-result-item');
        if (item) selectProduct(item, true);
    });

    /* ---------- Frais annexes ---------- */
    const expensesBody = $('expensesBody');

    function addExpense(data = {}) {
        const i = expenseIndex++;
        const opts = Object.entries(expenseTypes)
            .map(([v, l]) => `<option value="${v}">${l}</option>`).join('');
        const row = document.createElement('tr');
        row.className = 'expense-row';
        row.innerHTML = `
            <td><select name="expenses[${i}][type]" class="form-select">${opts}</select></td>
            <td><input type="text" name="expenses[${i}][description]" class="form-control" placeholder="Description"></td>
            <td><input type="number" name="expenses[${i}][amount]" class="form-control expense-amount" min="0" step="0.01" value="0"></td>
            <td><select name="expenses[${i}][currency]" class="form-select expense-currency">
                <option value="XOF">XOF</option><option value="NGN">NGN</option></select></td>
            <td><button type="button" class="btn btn-sm btn-light border remove-expense"><i class="bi bi-trash"></i></button></td>`;
        expensesBody.appendChild(row);

        if (data.type) row.querySelector(`[name="expenses[${i}][type]"]`).value = data.type;
        if (data.description) row.querySelector(`[name="expenses[${i}][description]"]`).value = data.description;
        if (data.amount !== undefined) row.querySelector('.expense-amount').value = data.amount;
        if (data.currency) row.querySelector('.expense-currency').value = data.currency;

        row.querySelector('.expense-amount').addEventListener('input', update);
        row.querySelector('.expense-currency').addEventListener('change', update);
        row.querySelector('.remove-expense').addEventListener('click', () => { row.remove(); update(); });
        update();
    }

    $('addExpense').addEventListener('click', () => addExpense());

    /* ---------- Calculs ---------- */
    function update() {
        const qty   = parseFloat($('quantity').value) || 0;
        const price = parseFloat($('unit_price').value) || 0;
        const rate  = parseFloat($('exchange_rate').value) || 0;
        const cur   = $('currency').value;

        document.querySelectorAll('.currency-label').forEach(el => el.textContent = cur);

        const purchase  = qty * price;
        const purchaseX = cur === 'NGN' ? purchase * rate : purchase;
        $('purchaseTotal').value   = fmt(purchase);
        $('convertedTotal').value  = fmt(purchaseX);

        let expenses = 0;
        const rows = document.querySelectorAll('.expense-row');
        rows.forEach(r => {
            const a = parseFloat(r.querySelector('.expense-amount').value) || 0;
            expenses += r.querySelector('.expense-currency').value === 'NGN' ? a * rate : a;
        });
        $('emptyExpense').style.display = rows.length ? 'none' : 'block';
        $('expensesTotal').textContent = fmt(expenses) + ' XOF';

        const total = purchaseX + expenses;
        const unit  = qty > 0 ? total / qty : 0;
        $('costPurchase').textContent  = fmt(purchaseX) + ' XOF';
        $('costExpenses').textContent  = fmt(expenses) + ' XOF';
        $('totalCost').textContent     = fmt(total) + ' XOF';
        $('unitCost').textContent      = fmt(unit) + ' XOF';

        const sale   = parseFloat($('selling_price').value) || 0;
        const margin = sale - unit;
        $('unitMargin').value       = fmt(margin);
        $('marginPercentage').value = fmt(unit > 0 ? margin / unit * 100 : 0) + ' %';
        $('totalMargin').textContent = fmt(margin * qty) + ' XOF';

        const after = selectedStock + qty;
        $('currentStock').textContent  = fmt(selectedStock);
        $('previewQuantity').textContent = fmt(qty);
        $('newStock').textContent      = fmt(after);
        $('previewMovementQuantity').textContent = '+' + fmt(qty);
        $('previewStockBefore').textContent = fmt(selectedStock);
        $('previewStockAfter').textContent  = fmt(after);

        $('traceCurrency').textContent = cur;
        $('traceRate').textContent = (cur === 'NGN' || expenses > 0) && rate ? String(rate) : '-';
    }

    ['quantity', 'unit_price', 'exchange_rate', 'selling_price'].forEach(id => $(id).addEventListener('input', update));
    $('currency').addEventListener('change', update);

    /* ---------- Envoi ---------- */
    $('stockEntryForm').addEventListener('submit', function (e) {
        if (!$('productId').value) {
            e.preventDefault();
            alert('Veuillez sélectionner un produit.');
            productSearch.focus();
            return;
        }
        if (supplierSelect.value === '__new') {
            if (!newSupplier.value.trim()) {
                e.preventDefault();
                alert('Veuillez saisir le nom du nouveau fournisseur.');
                newSupplier.focus();
                return;
            }
            supplierSelect.disabled = true; // seul new_supplier est envoyé
        }
    });

    /* ---------- Initialisation (réaffichage après erreur) ---------- */
    Object.values(oldExpenses).forEach(addExpense);

    const oldProduct = $('productId').value;
    if (oldProduct) {
        const item = document.querySelector('.product-result-item[data-id="' + oldProduct + '"]');
        if (item) selectProduct(item, false);
    }
    update();
});
</script>
@endpush