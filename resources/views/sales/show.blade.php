<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>{{ $sale->number }} - INTERCAR</title>

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

        .total-box {
            background: #30173D;
            color: white;
            border-radius: 14px;
            padding: 24px;
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

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <div class="text-muted small mb-1">
                Ventes / Détail
            </div>

            <h1 class="h4 fw-bold mb-1">
                {{ $sale->number }}
            </h1>

            <p class="text-muted mb-0">
                Vente enregistrée le
                {{ $sale->sale_date->format('d/m/Y') }}
            </p>

        </div>


        <div class="d-flex gap-2">

            <a
                href="{{ route('sales.index') }}"
                class="btn btn-outline-secondary"
            >

                <i class="fa-solid fa-arrow-left me-1"></i>

                Retour aux ventes

            </a>


            @if(
                $sale->status === 'terminee' ||
                $sale->status === 'partiellement_retournee'
            )

                <a
                    href="{{ route('sales.returns.create', ['sale' => $sale->id]) }}"
                    class="btn btn-warning"
                >

                    <i class="fa-solid fa-rotate-left me-1"></i>

                    Retour produit

                </a>

            @endif

        </div>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
        </div>

    @endif


    <!-- =====================================================
         INFORMATIONS
    ====================================================== -->

    <div class="card-section">

        <div class="row g-4">

            <div class="col-md-3">

                <small class="text-muted d-block">
                    Client
                </small>

                <strong>
                    {{ $sale->customer_name ?: 'Client comptoir' }}
                </strong>

            </div>


            <div class="col-md-3">

                <small class="text-muted d-block">
                    Téléphone
                </small>

                <strong>
                    {{ $sale->customer_phone ?: '—' }}
                </strong>

            </div>


            <div class="col-md-3">

                <small class="text-muted d-block">
                    Paiement
                </small>

                <strong>

                    @switch($sale->payment_method)

                        @case('especes')
                            Espèces
                            @break

                        @case('mobile_money')
                            Mobile Money
                            @break

                        @case('virement')
                            Virement
                            @break

                        @case('carte')
                            Carte
                            @break

                        @default
                            Autre

                    @endswitch

                </strong>

            </div>


            <div class="col-md-3">

                <small class="text-muted d-block">
                    Statut
                </small>

                @if($sale->status === 'terminee')

                    <span class="badge text-bg-success">
                        Terminée
                    </span>

                @elseif($sale->status === 'partiellement_retournee')

                    <span class="badge text-bg-warning">
                        Retour partiel
                    </span>

                @elseif($sale->status === 'retournee')

                    <span class="badge text-bg-danger">
                        Retournée
                    </span>

                @else

                    <span class="badge text-bg-secondary">
                        Annulée
                    </span>

                @endif

            </div>

        </div>

    </div>


    <!-- =====================================================
         PRODUITS
    ====================================================== -->

    <div class="card-section">

        <h2 class="h6 fw-bold mb-4">

            <i class="fa-solid fa-box me-2"></i>

            Produits vendus

        </h2>


        <div class="table-responsive">

            <table class="table align-middle">

                <thead class="table-light">

                    <tr>

                        <th>Produit</th>

                        <th>Référence</th>

                        <th class="text-center">
                            Quantité
                        </th>

                        <th class="text-end">
                            Prix unitaire
                        </th>

                        <th class="text-end">
                            Total
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($sale->items as $item)

                        <tr>

                            <td>

                                <strong>
                                    {{ $item->product->name }}
                                </strong>

                            </td>

                            <td>
                                {{ $item->product->reference }}
                            </td>

                            <td class="text-center">
                                {{ $item->quantity }}
                            </td>

                            <td class="text-end">

                                {{ number_format(
                                    $item->unit_price,
                                    0,
                                    ',',
                                    ' '
                                ) }}

                                FCFA

                            </td>

                            <td class="text-end fw-semibold">

                                {{ number_format(
                                    $item->total,
                                    0,
                                    ',',
                                    ' '
                                ) }}

                                FCFA

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>


    <!-- =====================================================
         TOTAL
    ====================================================== -->

    <div class="row justify-content-end">

        <div class="col-lg-5">

            <div class="total-box">

                <div class="d-flex justify-content-between mb-2">

                    <span>
                        Sous-total
                    </span>

                    <strong>
                        {{ number_format(
                            $sale->subtotal,
                            0,
                            ',',
                            ' '
                        ) }}
                        FCFA
                    </strong>

                </div>


                <div class="d-flex justify-content-between mb-2">

                    <span>
                        Remise
                    </span>

                    <strong>
                        {{ number_format(
                            $sale->discount,
                            0,
                            ',',
                            ' '
                        ) }}
                        FCFA
                    </strong>

                </div>


                <hr>


                <div class="d-flex justify-content-between">

                    <strong>
                        TOTAL
                    </strong>

                    <strong class="fs-4">

                        {{ number_format(
                            $sale->total,
                            0,
                            ',',
                            ' '
                        ) }}

                        FCFA

                    </strong>

                </div>

            </div>

        </div>

    </div>


    @if($sale->observation)

        <div class="card-section">

            <h2 class="h6 fw-bold">
                Observation
            </h2>

            <p class="mb-0 text-muted">
                {{ $sale->observation }}
            </p>

        </div>

    @endif


    <!-- =====================================================
         RETOURS DE CETTE VENTE
    ====================================================== -->

    @if($sale->returns->count())

        <div class="card-section">

            <h2 class="h6 fw-bold mb-3">

                <i class="fa-solid fa-rotate-left me-2"></i>

                Retours effectués

            </h2>


            @foreach($sale->returns as $return)

                <div class="border rounded p-3 mb-2">

                    <div class="d-flex justify-content-between">

                        <strong>
                            {{ $return->number }}
                        </strong>

                        <span>
                            {{ $return->return_date->format('d/m/Y') }}
                        </span>

                    </div>


                    <div class="mt-2">

                        Montant :
                        <strong>
                            {{ number_format(
                                $return->total,
                                0,
                                ',',
                                ' '
                            ) }}
                            FCFA
                        </strong>

                    </div>

                    @if($return->reason)

                        <div class="small text-muted mt-1">
                            {{ $return->reason }}
                        </div>

                    @endif

                </div>

            @endforeach

        </div>

    @endif

</div>

</body>

</html>