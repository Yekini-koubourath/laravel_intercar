<!DOCTYPE html>

<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Nouvelle vente - INTERCAR</title>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
>

<link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    rel="stylesheet"
>

<style>

    body {
        background: #f5f6fa;
    }

    .app-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100vh;
    overflow-y: auto;
    background: #30173D;
    z-index: 1000;
}

    .main-wrapper {
        margin-left: 250px;
        padding: 30px;
    }

    .page-header {
        background: #ffffff;
        border-radius: 14px;
        padding: 20px 24px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
    }

    .card-section {
        background: #ffffff;
        border: 0;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
    }

    .section-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 18px;
        color: #30173D;
    }

    .product-row {
        border-bottom: 1px solid #eee;
        padding: 14px 0;
    }

    .product-row:last-child {
        border-bottom: 0;
    }

    .total-box {
        background: #30173D;
        color: white;
        border-radius: 14px;
        padding: 22px;
    }

    .total-value {
        font-size: 1.7rem;
        font-weight: 700;
    }

    .btn-intercar {
        background: #ff9800;
        border-color: #ff9800;
        color: white;
    }

    .btn-intercar:hover {
        background: #e68900;
        border-color: #e68900;
        color: white;
    }

    @media (max-width: 991px) {

        .main-wrapper {
            margin-left: 0;
            padding: 20px;
        }
  .app-sidebar {
        display: none;
    }
    }

</style>

</head>

<body>

<aside class="app-sidebar">
    @include('auth.partials.sidebar')
</aside>

<div class="main-wrapper">

<!-- =====================================================
     HEADER
====================================================== -->

<div class="page-header">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>

            <div class="text-muted small mb-1">
                Ventes / Nouvelle vente
            </div>

            <h1 class="h4 mb-1 fw-bold">
                Nouvelle vente
            </h1>

            <p class="text-muted mb-0">
                Enregistrez une vente et le stock sera diminué automatiquement.
            </p>

        </div>

        <div class="text-end">

            <div class="small text-muted">
                Numéro de vente
            </div>

            <strong>
                {{ $nextNumber }}
            </strong>

        </div>

    </div>

</div>


@if(session('success'))

    <div class="alert alert-success">

        <i class="fa-solid fa-circle-check me-2"></i>

        {{ session('success') }}

    </div>

@endif


@if($errors->any())

    <div class="alert alert-danger">

        <strong>
            Impossible d'enregistrer la vente.
        </strong>

        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


<form
    method="POST"
    action="{{ route('sales.store') }}"
    id="saleForm"
>

    @csrf


    <!-- =================================================
         INFORMATIONS VENTE
    ================================================== -->

    <div class="card-section">

        <div class="section-title">

            <i class="fa-solid fa-file-invoice-dollar me-2"></i>

            Informations de la vente

        </div>


        <div class="row g-3">

            <div class="col-md-4">

                <label class="form-label">
                    Date de vente
                </label>

                <input
                    type="date"
                    name="sale_date"
                    class="form-control"
                    value="{{ old('sale_date', now()->format('Y-m-d')) }}"
                    max="{{ now()->format('Y-m-d') }}"
                    required
                >

            </div>


            <div class="col-md-4">

                <label class="form-label">
                    Nom du client
                </label>

                <input
                    type="text"
                    name="customer_name"
                    class="form-control"
                    value="{{ old('customer_name') }}"
                    placeholder="Client particulier"
                >

            </div>


            <div class="col-md-4">

                <label class="form-label">
                    Téléphone
                </label>

                <input
                    type="text"
                    name="customer_phone"
                    class="form-control"
                    value="{{ old('customer_phone') }}"
                    placeholder="Ex : 97 00 00 00"
                >

            </div>


            <div class="col-md-6">

                <label class="form-label">
                    Mode de paiement
                </label>

                <select
                    name="payment_method"
                    class="form-select"
                    required
                >

                    <option
                        value="especes"
                        {{ old('payment_method', 'especes') === 'especes' ? 'selected' : '' }}
                    >
                        Espèces
                    </option>

                    <option
                        value="mobile_money"
                        {{ old('payment_method') === 'mobile_money' ? 'selected' : '' }}
                    >
                        Mobile Money
                    </option>

                    <option
                        value="virement"
                        {{ old('payment_method') === 'virement' ? 'selected' : '' }}
                    >
                        Virement bancaire
                    </option>

                    <option
                        value="carte"
                        {{ old('payment_method') === 'carte' ? 'selected' : '' }}
                    >
                        Carte bancaire
                    </option>

                    <option
                        value="autre"
                        {{ old('payment_method') === 'autre' ? 'selected' : '' }}
                    >
                        Autre
                    </option>

                </select>

            </div>


            <div class="col-md-6">

                <label class="form-label">
                    Remise
                </label>

                <input
                    type="number"
                    name="discount"
                    id="discount"
                    class="form-control"
                    min="0"
                    step="0.01"
                    value="{{ old('discount', 0) }}"
                >

            </div>


            <div class="col-12">

                <label class="form-label">
                    Observation
                </label>

                <textarea
                    name="observation"
                    class="form-control"
                    rows="3"
                    placeholder="Observation éventuelle..."
                >{{ old('observation') }}</textarea>

            </div>

        </div>

    </div>


    <!-- =================================================
         PRODUITS
    ================================================== -->

    <div class="card-section">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div class="section-title mb-0">

                <i class="fa-solid fa-box me-2"></i>

                Produits

            </div>

            <button
                type="button"
                class="btn btn-sm btn-intercar"
                id="addProductBtn"
            >

                <i class="fa-solid fa-plus me-1"></i>

                Ajouter un produit

            </button>

        </div>


        <div id="productsContainer"></div>


        <div
            id="emptyProducts"
            class="text-center text-muted py-5"
        >

            <i class="fa-solid fa-cart-shopping fa-2x mb-3"></i>

            <p class="mb-0">
                Aucun produit ajouté.
            </p>

        </div>

    </div>


    <!-- =================================================
         TOTAL
    ================================================== -->

    <div class="row justify-content-end">

        <div class="col-lg-5">

            <div class="total-box mb-4">

                <div class="d-flex justify-content-between mb-2">

                    <span>
                        Sous-total
                    </span>

                    <strong id="subtotalDisplay">
                        0 FCFA
                    </strong>

                </div>


                <div class="d-flex justify-content-between mb-2">

                    <span>
                        Remise
                    </span>

                    <strong id="discountDisplay">
                        0 FCFA
                    </strong>

                </div>


                <hr>


                <div class="d-flex justify-content-between align-items-center">

                    <span>
                        TOTAL
                    </span>

                    <span
                        class="total-value"
                        id="totalDisplay"
                    >
                        0 FCFA
                    </span>

                </div>

            </div>

        </div>

    </div>


    <!-- =================================================
         ACTIONS
    ================================================== -->

    <div class="d-flex justify-content-between align-items-center gap-2">

        <a
            href="{{ route('sales.index') }}"
            class="btn btn-outline-secondary"
        >

            <i class="fa-solid fa-arrow-left me-1"></i>

            Annuler

        </a>


        <button
            type="submit"
            class="btn btn-intercar px-4"
            id="submitSale"
        >

            <i class="fa-solid fa-check me-1"></i>

            Enregistrer la vente

        </button>

    </div>

</form>
```

</div>

<script>

/*
|--------------------------------------------------------------------------
| PRODUITS DISPONIBLES
|--------------------------------------------------------------------------
|
| IMPORTANT :
| Les données sont maintenant préparées dans SaleController.
|
*/

const products = @json($productsData);


/*
|--------------------------------------------------------------------------
| VARIABLES
|--------------------------------------------------------------------------
*/

let productIndex = 0;


const container =
    document.getElementById('productsContainer');


const emptyProducts =
    document.getElementById('emptyProducts');


const discountInput =
    document.getElementById('discount');


/*
|--------------------------------------------------------------------------
| FORMAT MONÉTAIRE
|--------------------------------------------------------------------------
*/

function formatMoney(value)
{
    return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
}


/*
|--------------------------------------------------------------------------
| ÉTAT VIDE
|--------------------------------------------------------------------------
*/

function refreshEmptyState()
{
    emptyProducts.style.display =
        container.querySelectorAll('.product-row').length === 0
            ? 'block'
            : 'none';
}


/*
|--------------------------------------------------------------------------
| CALCUL DES TOTAUX
|--------------------------------------------------------------------------
*/

function refreshTotals()
{
    let subtotal = 0;


    container
        .querySelectorAll('.product-row')
        .forEach(function (row) {

            const price =
                parseFloat(
                    row.dataset.price
                ) || 0;


            const quantity =
                parseInt(
                    row.querySelector('.quantity-input').value
                ) || 0;


            subtotal += price * quantity;

        });


    const discount =
        parseFloat(discountInput.value) || 0;


    const total =
        Math.max(
            0,
            subtotal - discount
        );


    document.getElementById(
        'subtotalDisplay'
    ).textContent =
        formatMoney(subtotal);


    document.getElementById(
        'discountDisplay'
    ).textContent =
        formatMoney(discount);


    document.getElementById(
        'totalDisplay'
    ).textContent =
        formatMoney(total);
}


/*
|--------------------------------------------------------------------------
| VÉRIFIER SI UN PRODUIT EST DÉJÀ UTILISÉ
|--------------------------------------------------------------------------
*/

function productAlreadySelected(
    productId,
    currentRow = null
)
{
    return Array.from(
        container.querySelectorAll('.product-row')
    ).some(function (row) {

        if (row === currentRow) {
            return false;
        }


        return Number(row.dataset.productId) ===
            Number(productId);

    });
}


/*
|--------------------------------------------------------------------------
| METTRE À JOUR LES OPTIONS DES PRODUITS
|--------------------------------------------------------------------------
*/

function refreshProductOptions()
{
    const rows =
        container.querySelectorAll('.product-row');


    rows.forEach(function (row) {

        const select =
            row.querySelector('.product-select');


        const currentProductId =
            Number(select.value);


        select.innerHTML =
            products
                .filter(function (product) {

                    return !productAlreadySelected(
                        product.id,
                        row
                    ) ||
                    product.id === currentProductId;

                })
                .map(function (product) {

                    return `
                        <option
                            value="${product.id}"
                            ${product.id === currentProductId ? 'selected' : ''}
                        >
                            ${product.name}
                            — ${product.reference}
                            — Stock : ${product.quantity}
                        </option>
                    `;

                })
                .join('');

    });
}


/*
|--------------------------------------------------------------------------
| AJOUTER UN PRODUIT
|--------------------------------------------------------------------------
*/

function addProduct()
{
    const availableProducts =
        products.filter(function (product) {

            return !productAlreadySelected(
                product.id
            );

        });


    if (availableProducts.length === 0) {

        alert(
            'Tous les produits disponibles ont déjà été ajoutés.'
        );

        return;
    }


    const product =
        availableProducts[0];


    const index =
        productIndex++;


    const row =
        document.createElement('div');


    row.className =
        'product-row';


    row.dataset.productId =
        product.id;


    row.dataset.price =
        product.selling_price;


    row.innerHTML = `

        <div class="row align-items-center g-3">

            <div class="col-md-5">

                <label class="form-label small text-muted">
                    Produit
                </label>

                <select
                    class="form-select product-select"
                    name="items[${index}][product_id]"
                    required
                >
                </select>

            </div>


            <div class="col-md-2">

                <label class="form-label small text-muted">
                    Quantité
                </label>

                <input
                    type="number"
                    name="items[${index}][quantity]"
                    class="form-control quantity-input"
                    value="1"
                    min="1"
                    max="${product.quantity}"
                    required
                >

                <small class="text-muted stock-info">
                    Stock : ${product.quantity}
                </small>

            </div>


            <div class="col-md-2">

                <label class="form-label small text-muted">
                    Prix unitaire
                </label>

                <input
                    type="number"
                    name="items[${index}][unit_price]"
                    class="form-control unit-price-input"
                    value="${product.selling_price}"
                    min="0"
                    step="0.01"
                    required
                >

            </div>


            <div class="col-md-2">

                <label class="form-label small text-muted">
                    Total
                </label>

                <div
                    class="form-control-plaintext fw-bold line-total"
                >
                    ${formatMoney(product.selling_price)}
                </div>

            </div>


            <div class="col-md-1 text-end">

                <button
                    type="button"
                    class="btn btn-outline-danger remove-product"
                >

                    <i class="fa-solid fa-trash"></i>

                </button>

            </div>

        </div>

    `;


    container.appendChild(row);


    const select =
        row.querySelector('.product-select');


    const quantityInput =
        row.querySelector('.quantity-input');


    const unitPriceInput =
        row.querySelector('.unit-price-input');


    /*
    |--------------------------------------------------------------------------
    | REMPLIR LE SELECT
    |--------------------------------------------------------------------------
    */

    refreshProductOptions();


    /*
    |--------------------------------------------------------------------------
    | MISE À JOUR DE LA LIGNE
    |--------------------------------------------------------------------------
    */

    function updateRow()
    {
        const selected =
            products.find(function (product) {

                return product.id ===
                    Number(select.value);

            });


        if (!selected) {
            return;
        }


        row.dataset.productId =
            selected.id;


        row.dataset.price =
            parseFloat(
                unitPriceInput.value
            ) || 0;


        quantityInput.max =
            selected.quantity;


        if (
            parseInt(quantityInput.value) >
            selected.quantity
        ) {

            quantityInput.value =
                selected.quantity;

        }


        if (
            parseInt(quantityInput.value) < 1 ||
            !quantityInput.value
        ) {

            quantityInput.value = 1;

        }


        row.querySelector(
            '.stock-info'
        ).textContent =
            'Stock : ' + selected.quantity;


        const unitPrice =
            parseFloat(
                unitPriceInput.value
            ) || 0;


        const quantity =
            parseInt(
                quantityInput.value
            ) || 0;


        row.querySelector(
            '.line-total'
        ).textContent =
            formatMoney(
                unitPrice * quantity
            );


        refreshTotals();


        refreshProductOptions();
    }


    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT DE PRODUIT
    |--------------------------------------------------------------------------
    */

    select.addEventListener(
        'change',
        function () {

            const selected =
                products.find(function (product) {

                    return product.id ===
                        Number(select.value);

                });


            if (!selected) {
                return;
            }


            unitPriceInput.value =
                selected.selling_price;


            quantityInput.value =
                1;


            updateRow();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT QUANTITÉ
    |--------------------------------------------------------------------------
    */

    quantityInput.addEventListener(
        'input',
        updateRow
    );


    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT PRIX
    |--------------------------------------------------------------------------
    */

    unitPriceInput.addEventListener(
        'input',
        updateRow
    );


    /*
    |--------------------------------------------------------------------------
    | SUPPRESSION
    |--------------------------------------------------------------------------
    */

    row.querySelector(
        '.remove-product'
    ).addEventListener(
        'click',
        function () {

            row.remove();


            refreshProductOptions();


            refreshEmptyState();


            refreshTotals();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | PREMIÈRE MISE À JOUR
    |--------------------------------------------------------------------------
    */

    select.value =
        String(product.id);


    updateRow();


    refreshEmptyState();


    refreshTotals();
}


/*
|--------------------------------------------------------------------------
| BOUTON AJOUTER
|--------------------------------------------------------------------------
*/

document.getElementById(
    'addProductBtn'
).addEventListener(
    'click',
    addProduct
);


/*
|--------------------------------------------------------------------------
| REMISE
|--------------------------------------------------------------------------
*/

discountInput.addEventListener(
    'input',
    refreshTotals
);


/*
|--------------------------------------------------------------------------
| SOUMISSION
|--------------------------------------------------------------------------
*/

document.getElementById(
    'saleForm'
).addEventListener(
    'submit',
    function (event) {

        const rows =
            container.querySelectorAll(
                '.product-row'
            );


        if (rows.length === 0) {

            event.preventDefault();


            alert(
                'Veuillez ajouter au moins un produit.'
            );


            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Vérifier les quantités
        |--------------------------------------------------------------------------
        */

        let invalidQuantity = false;


        rows.forEach(function (row) {

            const quantity =
                parseInt(
                    row.querySelector(
                        '.quantity-input'
                    ).value
                ) || 0;


            const max =
                parseInt(
                    row.querySelector(
                        '.quantity-input'
                    ).max
                ) || 0;


            if (
                quantity < 1 ||
                quantity > max
            ) {

                invalidQuantity = true;

            }

        });


        if (invalidQuantity) {

            event.preventDefault();


            alert(
                'Une quantité dépasse le stock disponible.'
            );


            return;
        }


        const button =
            document.getElementById(
                'submitSale'
            );


        button.disabled = true;


        button.innerHTML = `

            <span
                class="spinner-border spinner-border-sm me-1"
            ></span>

            Enregistrement...

        `;

    }
);


/*
|--------------------------------------------------------------------------
| ÉTAT INITIAL
|--------------------------------------------------------------------------
*/

refreshEmptyState();

refreshTotals();

</script>

</body>

</html>
