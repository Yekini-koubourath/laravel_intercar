
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alertes stock faible - INTERCAR</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >

    @include('auth.partials.sidebar-layout')

    <style>
        body {
            background: #f5f6fa;
            color: #212529;
        }

        .main-wrapper {
            margin-left: 250px;
            padding: 30px;
            min-width: 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 28px;
        }

        .page-title {
            color: #30173D;
            font-weight: 700;
        }

        .card-stat {
            background: #fff;
            border-radius: 14px;
            padding: 22px;
            height: 100%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            margin-bottom: 14px;
            font-size: 18px;
        }

        .icon-purple {
            background: #f0e7f5;
            color: #6f42c1;
        }

        .icon-red {
            background: #fde8e8;
            color: #dc3545;
        }

        .icon-orange {
            background: #fff0df;
            color: #f37021;
        }

        .content-card {
            background: #fff;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .badge-rupture {
            background: #fde8e8;
            color: #b42318;
        }

        .badge-faible {
            background: #fff0df;
            color: #a34b00;
        }

        .btn-purple {
            background: #512264;
            border-color: #512264;
            color: #fff;
        }

        .btn-purple:hover {
            background: #30173D;
            border-color: #30173D;
            color: #fff;
        }

        .empty-state {
            padding: 48px 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 42px;
            color: #198754;
            margin-bottom: 16px;
        }

        @media (max-width: 991.98px) {
            .main-wrapper {
                margin-left: 72px;
                padding: 22px 16px;
            }
        }

        @media (max-width: 575.98px) {
            .main-wrapper {
                padding: 18px 12px;
            }

            .content-card {
                padding: 16px;
            }

            .page-header .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    @include('auth.partials.sidebar')

    <main class="main-wrapper">

        <!-- EN-TÊTE -->

        <div class="page-header">
            <div>
                <div class="text-muted small mb-1">
                    Stock / Alertes
                </div>

                <h1 class="h4 page-title mb-2">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>
                    Alertes stock faible
                </h1>

                <p class="text-muted mb-0">
                    Identifiez les produits à réapprovisionner.
                </p>
            </div>

            <a href="{{ route('stock.entries.create') }}"
               class="btn btn-purple">
                <i class="fa-solid fa-plus me-2"></i>
                Nouvelle entrée de stock
            </a>
        </div>


        <!-- INDICATEURS -->

        <div class="row g-3 mb-4">

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card-stat">
                    <div class="stat-icon icon-purple">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>

                    <p class="text-muted small mb-1">
                        Total des alertes
                    </p>

                    <h3 class="fw-bold mb-0">
                        {{ number_format($totalAlerts, 0, ',', ' ') }}
                    </h3>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card-stat">
                    <div class="stat-icon icon-red">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>

                    <p class="text-muted small mb-1">
                        Produits en rupture
                    </p>

                    <h3 class="fw-bold text-danger mb-0">
                        {{ number_format($ruptures, 0, ',', ' ') }}
                    </h3>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card-stat">
                    <div class="stat-icon icon-orange">
                        <i class="fa-solid fa-box-open"></i>
                    </div>

                    <p class="text-muted small mb-1">
                        Stocks faibles
                    </p>

                    <h3 class="fw-bold mb-0" style="color: #f37021;">
                        {{ number_format($stockFaible, 0, ',', ' ') }}
                    </h3>
                </div>
            </div>

        </div>


        <!-- TABLEAU DES ALERTES -->

        <div class="content-card">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                <div>
                    <h2 class="h6 fw-bold mb-1">
                        Produits nécessitant une attention
                    </h2>

                    <p class="text-muted small mb-0">
                        Les produits sont classés par quantité disponible.
                    </p>
                </div>

                <span class="badge rounded-pill text-bg-light">
                    {{ $totalAlerts }} produit(s)
                </span>
            </div>

            @if($products->isEmpty())

                <div class="empty-state">
                    <i class="fa-solid fa-circle-check d-block"></i>

                    <h3 class="h5 fw-bold">
                        Aucun stock à risque
                    </h3>

                    <p class="text-muted mb-0">
                        Tous les produits ont une quantité supérieure à leur seuil minimum.
                    </p>
                </div>

            @else

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Produit</th>
                                <th>Référence</th>
                                <th>Type</th>
                                <th class="text-center">Quantité disponible</th>
                                <th class="text-center">Seuil minimum</th>
                                <th>État</th>
                                <th>Emplacement</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($products as $product)

                                <tr>
                                    <td>
                                        <span class="fw-semibold">
                                            {{ $product->name }}
                                        </span>

                                        @if($product->brand)
                                            <div class="small text-muted">
                                                {{ $product->brand }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $product->reference ?: '—' }}
                                    </td>

                                    <td>
                                        @if($product->type === 'vehicule')
                                            Véhicule
                                        @elseif($product->type === 'piece')
                                            Pièce
                                        @else
                                            {{ $product->type ?: '—' }}
                                        @endif
                                    </td>

                                    <td class="text-center fw-bold
                                        {{ $product->quantity <= 0 ? 'text-danger' : 'text-warning' }}">
                                        {{ number_format($product->quantity, 0, ',', ' ') }}
                                    </td>

                                    <td class="text-center">
                                        {{ number_format($product->stock_minimum, 0, ',', ' ') }}
                                    </td>

                                    <td>
                                        @if($product->quantity <= 0)
                                            <span class="badge badge-rupture">
                                                <i class="fa-solid fa-circle-xmark me-1"></i>
                                                Rupture
                                            </span>
                                        @else
                                            <span class="badge badge-faible">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i>
                                                Stock faible
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $product->location ?: '—' }}
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>

                    </table>
                </div>

            @endif

        </div>

    </main>

</body>
</html>
