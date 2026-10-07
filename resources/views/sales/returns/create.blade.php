<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Nouveau retour - INTERCAR</title>

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

        .card-section {
            background: white;
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        .sale-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .sale-card:hover {
            border-color: #ff9800;
        }

        .sale-card.selected {
            border-color: #ff9800;
            background: #fff8ed;
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

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <div class="text-muted small">
                Ventes / Retours
            </div>

            <h1 class="h4 fw-bold">
                Nouveau retour
            </h1>

        </div>


        <a
            href="{{ route('sales.returns.index') }}"
            class="btn btn-outline-secondary"
        >

            <i class="fa-solid fa-arrow-left me-1"></i>

            Retour

        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Impossible d'enregistrer le retour.</strong>

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
        action="{{ route('sales.returns.store') }}"
        id="returnForm"
    >

        @csrf


        <!-- =================================================
             INFORMATIONS
        ================================================== -->

        <div class="card-section">

            <h2 class="h6 fw-bold mb-4">

                <i class="fa-solid fa-file-invoice me-2"></i>

                Informations du retour

            </h2>


            <div class="row g-3">

                <div class="col-md-4">

                    <label class="form-label">
                        Numéro
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $nextNumber }}"
                        readonly
                    >

                </div>


                <div class="col-md-4">

                    <label class="form-label">
                        Date du retour
                    </label>

                    <input
                        type="date"
                        name="return_date"
                        class="form-control"
                        value="{{ now()->format('Y-m-d') }}"
                        max="{{ now()->format('Y-m-d') }}"
                        required
                    >

                </div>


                <div class="col-md-4">

                    <label class="form-label">
                        Vente concernée
                    </label>

                    <select
                        name="sale_id"
                        id="saleSelect"
                        class="form-select"
                        required
                    >

                        <option value="">
                            Sélectionner une vente
                        </option>

                        @foreach($sales as $sale)

                            <option
                                value="{{ $sale->id }}"
                                @selected(
                                    request('sale') == $sale->id
                                )
                            >

                                {{ $sale->number }}

                                —
                                {{ $sale->customer_name ?: 'Client comptoir' }}

                                —
                                {{ $sale->sale_date->format('d/m/Y') }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>


        <!-- =================================================
             PRODUITS
        ================================================== -->

        <div class="card-section">

            <h2 class="h6 fw-bold mb-4">

                <i class="fa-solid fa-box me-2"></i>

                Produits à retourner

            </h2>


            <div id="itemsContainer">

                <div class="text-muted text-center py-4">
                    Sélectionnez d'abord une vente.
                </div>

            </div>

        </div>


        <!-- =================================================
             MOTIF
        ================================================== -->

        <div class="card-section">

            <label class="form-label fw-semibold">
                Motif du retour
            </label>

            <textarea
                name="reason"
                class="form-control"
                rows="4"
                placeholder="Ex : Produit défectueux, erreur de référence..."
            >{{ old('reason') }}</textarea>

        </div>


        <div class="d-flex justify-content-between">

            <a
                href="{{ route('sales.returns.index') }}"
                class="btn btn-outline-secondary"
            >
                Annuler
            </a>


            <button
                type="submit"
                class="btn btn-warning"
                id="submitReturn"
            >

                <i class="fa-solid fa-rotate-left me-1"></i>

                Enregistrer le retour

            </button>

        </div>

    </form>

</div>


<script>

const sales = @json(
    $sales->map(function ($sale) {

        return [
            'id' => $sale->id,
            'number' => $sale->number,
            'items' => $sale->items->map(function ($item) {

                $alreadyReturned =
                    $item->returnItems()->sum('quantity');

                $remaining =
                    max(
                        0,
                        $item->quantity - $alreadyReturned
                    );

                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'reference' => $item->product->reference,
                    'quantity' => $item->quantity,
                    'remaining' => $remaining,
                    'unit_price' => (float) $item->unit_price,
                ];

            })->values(),
        ];

    })->values()
);


const saleSelect =
    document.getElementById('saleSelect');

const itemsContainer =
    document.getElementById('itemsContainer');


function formatMoney(value)
{
    return new Intl.NumberFormat(
        'fr-FR'
    ).format(value) + ' FCFA';
}


function renderItems()
{
    const saleId =
        saleSelect.value;


    itemsContainer.innerHTML = '';


    if (!saleId) {

        itemsContainer.innerHTML = `
            <div class="text-muted text-center py-4">
                Sélectionnez d'abord une vente.
            </div>
        `;

        return;
    }


    const sale =
        sales.find(function (s) {

            return s.id == saleId;

        });


    if (!sale || sale.items.length === 0) {

        itemsContainer.innerHTML = `
            <div class="alert alert-warning">
                Aucun produit disponible pour un retour.
            </div>
        `;

        return;
    }


    let available = 0;


    sale.items.forEach(function (item, index) {

        if (item.remaining <= 0) {
            return;
        }


        available++;


        const row =
            document.createElement('div');

        row.className =
            'border rounded p-3 mb-3';


        row.innerHTML = `

            <div class="row align-items-center g-3">

                <div class="col-md-5">

                    <strong>
                        ${item.product_name}
                    </strong>

                    <div class="small text-muted">
                        ${item.reference}
                    </div>

                    <div class="small text-muted">
                        Vendu : ${item.quantity}
                        |
                        Encore retournable : ${item.remaining}
                    </div>

                </div>


                <div class="col-md-2">

                    <div class="small text-muted">
                        Prix unitaire
                    </div>

                    <strong>
                        ${formatMoney(item.unit_price)}
                    </strong>

                </div>


                <div class="col-md-3">

                    <label class="form-label">
                        Quantité retournée
                    </label>

                    <input
                        type="number"
                        name="items[${index}][quantity]"
                        class="form-control"
                        min="1"
                        max="${item.remaining}"
                        value="0"
                        data-price="${item.unit_price}"
                    >

                    <input
                        type="hidden"
                        name="items[${index}][sale_item_id]"
                        value="${item.id}"
                    >

                </div>


                <div class="col-md-2 text-end">

                    <div class="small text-muted">
                        Montant
                    </div>

                    <strong class="line-total">
                        0 FCFA
                    </strong>

                </div>

            </div>

        `;


        itemsContainer.appendChild(row);


        const quantityInput =
            row.querySelector(
                'input[type="number"]'
            );


        const lineTotal =
            row.querySelector(
                '.line-total'
            );


        quantityInput.addEventListener(
            'input',
            function () {

                const quantity =
                    parseInt(
                        quantityInput.value
                    ) || 0;

                lineTotal.textContent =
                    formatMoney(
                        quantity *
                        item.unit_price
                    );

            }
        );

    });


    if (available === 0) {

        itemsContainer.innerHTML = `
            <div class="alert alert-info">
                Tous les produits de cette vente ont déjà été retournés.
            </div>
        `;

    }

}


saleSelect.addEventListener(
    'change',
    renderItems
);


document.getElementById(
    'returnForm'
).addEventListener(
    'submit',
    function (event) {

        let hasQuantity = false;


        itemsContainer
            .querySelectorAll(
                'input[type="number"]'
            )
            .forEach(function (input) {

                if (
                    parseInt(input.value) > 0
                ) {

                    hasQuantity = true;

                }

            });


        if (!hasQuantity) {

            event.preventDefault();

            alert(
                'Veuillez sélectionner au moins une quantité à retourner.'
            );

            return;
        }


        const button =
            document.getElementById(
                'submitReturn'
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


renderItems();

</script>

</body>

</html>