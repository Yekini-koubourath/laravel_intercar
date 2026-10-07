<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>{{ $return->number }} - INTERCAR</title>

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
            background: #fff;
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
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

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <div class="text-muted small">
                Ventes / Retours / Détail
            </div>

            <h1 class="h4 fw-bold">
                {{ $return->number }}
            </h1>

        </div>


        <div class="d-flex gap-2">

            <a
                href="{{ route('sales.returns.index') }}"
                class="btn btn-outline-secondary"
            >

                <i class="fa-solid fa-arrow-left me-1"></i>

                Retour

            </a>


            <a
                href="{{ route('sales.show', $return->sale) }}"
                class="btn btn-dark"
            >

                Voir la vente

            </a>

        </div>

    </div>


    <!-- =====================================================
         INFORMATIONS
    ====================================================== -->

    <div class="card-section">

        <div class="row g-4">

            <div class="col-md-3">

                <small class="text-muted d-block">
                    N° retour
                </small>

                <strong>
                    {{ $return->number }}
                </strong>

            </div>


            <div class="col-md-3">

                <small class="text-muted d-block">
                    Vente
                </small>

                <strong>
                    {{ $return->sale->number }}
                </strong>

            </div>


            <div class="col-md-3">

                <small class="text-muted d-block">
                    Date
                </small>

                <strong>
                    {{ $return->return_date->format('d/m/Y') }}
                </strong>

            </div>


            <div class="col-md-3">

                <small class="text-muted d-block">
                    Enregistré par
                </small>

                <strong>
                    {{ $return->user->name ?? '—' }}
                </strong>

            </div>

        </div>

    </div>


    <!-- =====================================================
         PRODUITS
    ====================================================== -->

    <div class="card-section">

        <h2 class="h6 fw-bold mb-4">

            <i class="fa-solid fa-box me-2"></i>

            Produits retournés

        </h2>


        <div class="table-responsive">

            <table class="table align-middle">

                <thead class="table-light">

                    <tr>

                        <th>
                            Produit
                        </th>

                        <th>
                            Référence
                        </th>

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

                    @foreach($return->items as $item)

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

        <div class="col-lg-4">

            <div class="card-section">

                <div class="d-flex justify-content-between">

                    <strong>
                        Total retourné
                    </strong>

                    <strong class="fs-5">

                        {{ number_format(
                            $return->total,
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


    @if($return->reason)

        <div class="card-section">

            <h2 class="h6 fw-bold">
                Motif du retour
            </h2>

            <p class="mb-0 text-muted">
                {{ $return->reason }}
            </p>

        </div>

    @endif

</div>

</body>

</html>