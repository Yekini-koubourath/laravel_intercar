<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Tableau de bord - INTERCAR</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Google Font Inter -->
    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">


    <style>

        :root {
            --purple-sidebar: #30173D;
            --purple-main: #5B2C6F;
            --purple-btn: #512264;
            --orange-active: #F37021;
            --bg-body: #F4F5F8;
            --card-border-radius: 12px;
        }


        body {
            background-color: var(--bg-body);
            font-family: 'Inter', sans-serif;
            color: #2D3748;
            font-size: 0.875rem;
        }


        /* =========================================================
           SIDEBAR
        ========================================================== */

        .sidebar {
            width: 250px;
            background-color: var(--purple-sidebar);
            min-height: 100vh;
            min-height: 100dvh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.25s ease;
        }


        .sidebar-brand {
            padding: 1.5rem 1rem 1rem 1rem;
        }


        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.65rem 1rem;
            border-radius: 8px;
            margin-bottom: 3px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
        }


        .sidebar .nav-link:hover {
            color: #FFFFFF;
            background-color: rgba(255, 255, 255, 0.08);
        }


        .sidebar .nav-link.active {
            color: #FFFFFF;
            background-color: var(--orange-active);
            font-weight: 600;
        }


        /* =========================================================
           OVERLAY MOBILE
        ========================================================== */

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(26, 11, 46, 0.55);
            z-index: 999;
        }


        .sidebar-overlay.show {
            display: block;
        }


        /* =========================================================
           MAIN CONTENT
        ========================================================== */

        .main-wrapper {
            margin-left: 250px;
            padding: 1.25rem 2rem 2rem 2rem;
        }


        /* =========================================================
           TOP BAR
        ========================================================== */

        .top-bar {
            background-color: #FFFFFF;
            border-radius: 12px;
            padding: 0.5rem 1.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }


        .search-box {
            background-color: #F8F9FA;
            border-radius: 8px;
            border: 1px solid #E9ECEF;
            min-width: 0;
            max-width: 480px;
        }


        .search-box input {
            min-width: 0;
        }


        .search-box input::placeholder {
            color: #A0AEC0;
            font-size: 0.825rem;
        }


        /* =========================================================
           KPI CARDS
        ========================================================== */

        .card-kpi {
            background-color: #FFFFFF;
            border: none;
            border-radius: var(--card-border-radius);
            padding: 1.25rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }


        .kpi-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }


        .kpi-icon-purple {
            background-color: #F3E8FF;
            color: #6B21A8;
        }


        .kpi-icon-orange {
            background-color: #FFEDD5;
            color: #EA580C;
        }


        .kpi-icon-purple-alt {
            background-color: #F0E8FF;
            color: #5B2C6F;
        }


        .kpi-icon-red {
            background-color: #FEE2E2;
            color: #DC2626;
        }


        /* =========================================================
           GENERAL CARDS
        ========================================================== */

        .card-custom {
            background-color: #FFFFFF;
            border: none;
            border-radius: var(--card-border-radius);
            padding: 1.25rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }


        /* =========================================================
           BADGES
        ========================================================== */

        .badge-rupture {
            background-color: #FCE8E6;
            color: #E53E3E;
            font-weight: 500;
            padding: 0.35em 0.75em;
        }


        .badge-faible {
            background-color: #FEF3C7;
            color: #D97706;
            font-weight: 500;
            padding: 0.35em 0.75em;
        }


        .badge-taux {
            background-color: #DCFCE7;
            color: #166534;
            font-size: 0.75rem;
            font-weight: 500;
        }


        .badge-non-configure {
            background-color: #F3F4F6;
            color: #6B7280;
            font-size: 0.75rem;
            font-weight: 500;
        }


        /* =========================================================
           TABLES
        ========================================================== */

        .table-custom th {
            color: #718096;
            font-weight: 500;
            font-size: 0.75rem;
            border-bottom: 1px solid #EDF2F7;
            background-color: #FAFAFA;
            padding: 0.6rem 0.75rem;
        }


        .table-custom td {
            padding: 0.65rem 0.75rem;
            border-bottom: 1px solid #EDF2F7;
            vertical-align: middle;
            font-size: 0.825rem;
        }


        .product-img-placeholder {
            width: 32px;
            height: 32px;
            background-color: #4A5568;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.75rem;
        }


        /* =========================================================
           BUTTONS
        ========================================================== */

        .btn-purple {
            background-color: var(--purple-btn);
            color: white;
            border: none;
            font-size: 0.825rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
        }


        .btn-purple:hover {
            background-color: #3D184C;
            color: white;
        }


        /* =========================================================
           DONUT
        ========================================================== */

        .donut-wrapper {
            position: relative;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background:
                conic-gradient(
                    #5B2C6F 0% {{ min(100, max(0, $marginRate)) }}%,
                    #E2E8F0 {{ min(100, max(0, $marginRate)) }}% 100%
                );
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
        }


        .donut-center {
            width: 62px;
            height: 62px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            color: #331842;
        }


        /* =========================================================
           VARIATIONS
        ========================================================== */

        .variation-positive {
            color: #16A34A;
        }


        .variation-negative {
            color: #DC2626;
        }


        .variation-neutral {
            color: #6B7280;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================== */

        .card-custom .d-flex.justify-content-between {
            flex-wrap: wrap;
            gap: 0.5rem;
        }


        @media (min-width: 1200px) and (max-width: 1399.98px) {

            .card-kpi h4 {
                font-size: 1.1rem;
            }

        }


        @media (max-width: 991.98px) {

            .sidebar {
                transform: translateX(-100%);
                max-width: 85vw;
            }


            .sidebar.open {
                transform: translateX(0);
                box-shadow: 8px 0 24px rgba(0, 0, 0, 0.25);
            }


            .main-wrapper {
                margin-left: 0;
                padding: 1rem;
            }

        }


        @media (max-width: 575.98px) {

            .main-wrapper {
                padding: 0.75rem;
            }


            .top-bar {
                padding: 0.5rem 0.75rem;
            }


            .top-bar > .d-flex.gap-3 {
                gap: 0.5rem !important;
            }


            .card-kpi,
            .card-custom {
                padding: 1rem;
            }

        }

    </style>

</head>


<body>


    <!-- =========================================================
         OVERLAY MOBILE
    ========================================================== -->

    <div class="sidebar-overlay"
         id="sidebarOverlay"></div>


    <!-- =========================================================
         SIDEBAR
    ========================================================== -->

    @include('auth.partials.sidebar')


    <!-- =========================================================
         MAIN CONTENT
    ========================================================== -->

    <main class="main-wrapper">


        <!-- =====================================================
             TOP BAR
        ====================================================== -->

        <header class="top-bar d-flex align-items-center justify-content-between gap-2 mb-4">


            <!-- Bouton menu mobile -->

            <button type="button"
                    class="btn btn-light border d-lg-none flex-shrink-0"
                    id="sidebarToggle"
                    aria-label="Ouvrir le menu">

                <i class="fa-solid fa-bars"></i>

            </button>


            <!-- Recherche -->

            <div class="search-box d-flex align-items-center px-3 py-1-5 flex-grow-1">

                <i class="fa-solid fa-magnifying-glass text-muted me-2"></i>

                <input type="text"
                       class="form-control bg-transparent border-0 p-0 fs-6"
                       placeholder="Rechercher un produit, une référence, un client...">

            </div>


            <!-- Actions droite -->

            <div class="d-flex align-items-center gap-3 flex-shrink-0">


                <!-- Localisation -->

                <div class="d-none d-md-flex align-items-center gap-2 bg-light px-3 py-2 rounded-3 border"
                     style="font-size: 0.8rem;">

                    <i class="fa-solid fa-location-dot text-muted"></i>

                    <div>

                        <div class="fw-semibold lh-1">
                            Magasin principal
                        </div>

                        <div class="text-muted"
                             style="font-size: 0.7rem;">
                            Cotonou, Bénin
                        </div>

                    </div>

                    <i class="fa-solid fa-chevron-down text-muted ms-2"
                       style="font-size: 0.7rem;"></i>

                </div>


                <!-- Notifications -->

                <button class="btn btn-light rounded-circle p-2 position-relative border">

                    <i class="fa-regular fa-bell text-secondary"></i>

                    @if($stockAlerts > 0)

                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>

                    @endif

                </button>


                <!-- Profil -->

                <div class="d-flex align-items-center gap-2">

                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold"
                         style="width: 36px;
                                height: 36px;
                                background-color: var(--purple-sidebar);
                                font-size: 0.85rem;">

                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                    </div>


                    <span class="fw-semibold d-none d-sm-inline"
                          style="font-size: 0.85rem;">

                        {{ Auth::user()->name }}

                    </span>


                    <form method="POST"
                          action="{{ route('logout') }}"
                          class="m-0">

                        @csrf

                        <button type="submit"
                                class="btn btn-light btn-sm border ms-2"
                                title="Se déconnecter">

                            <i class="fa-solid fa-right-from-bracket"></i>

                        </button>

                    </form>

                </div>

            </div>

        </header>


        <!-- =====================================================
             TITRE
        ====================================================== -->

        <div class="d-flex align-items-center gap-3 mb-4">

            <div class="p-2-5 rounded-3 text-white d-flex align-items-center justify-content-center flex-shrink-0"
                 style="background-color: var(--purple-sidebar);
                        width: 42px;
                        height: 42px;">

                <i class="fa-solid fa-border-all fs-5"></i>

            </div>


            <div>

                <h4 class="fw-bold mb-0"
                    style="color: #1A202C;">

                    Tableau de bord

                </h4>


                <p class="text-muted small mb-0">

                    Vue d'ensemble de votre activité —
                    {{ $periodLabel }}

                </p>

            </div>

        </div>


        <!-- =====================================================
             4 KPI
        ====================================================== -->

        <div class="row g-3 mb-4">


            <!-- CA -->

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card-kpi h-100">

                    <div class="kpi-icon kpi-icon-purple mb-3">

                        <i class="fa-solid fa-wallet"></i>

                    </div>


                    <p class="text-muted small mb-1 fw-medium">

                        Chiffre d'affaires

                    </p>


                    <h4 class="fw-bold mb-2"
                        style="color: #111827;">

                        {{ number_format($currentRevenue, 0, ',', ' ') }}
                        FCFA

                    </h4>


                    <div class="d-flex align-items-center gap-1"
                         style="font-size: 0.75rem;">

                        @if($previousRevenue == 0 && $currentRevenue > 0)

                            <span class="variation-neutral fw-semibold">

                                <i class="fa-solid fa-sparkles"></i>
                                Nouveau

                            </span>

                        @elseif($revenueVariation > 0)

                            <span class="variation-positive fw-semibold">

                                <i class="fa-solid fa-arrow-up"></i>
                                +{{ number_format($revenueVariation, 1, ',', ' ') }}%

                            </span>

                        @elseif($revenueVariation < 0)

                            <span class="variation-negative fw-semibold">

                                <i class="fa-solid fa-arrow-down"></i>
                                {{ number_format($revenueVariation, 1, ',', ' ') }}%

                            </span>

                        @else

                            <span class="variation-neutral fw-semibold">

                                <i class="fa-solid fa-minus"></i>
                                0%

                            </span>

                        @endif


                        <span class="text-muted">

                            par rapport à la période précédente

                        </span>

                    </div>

                </div>

            </div>


            <!-- MARGES -->

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card-kpi h-100">

                    <div class="kpi-icon kpi-icon-orange mb-3">

                        <i class="fa-solid fa-chart-line"></i>

                    </div>


                    <p class="text-muted small mb-1 fw-medium">

                        Marges réalisées

                    </p>


                    <h4 class="fw-bold mb-2"
                        style="color: #111827;">

                        {{ number_format($currentMargin, 0, ',', ' ') }}
                        FCFA

                    </h4>


                    <div class="d-flex align-items-center gap-1"
                         style="font-size: 0.75rem;">

                        @if($previousMargin == 0 && $currentMargin > 0)

                            <span class="variation-neutral fw-semibold">

                                <i class="fa-solid fa-sparkles"></i>
                                Nouveau

                            </span>

                        @elseif($marginVariation > 0)

                            <span class="variation-positive fw-semibold">

                                <i class="fa-solid fa-arrow-up"></i>
                                +{{ number_format($marginVariation, 1, ',', ' ') }}%

                            </span>

                        @elseif($marginVariation < 0)

                            <span class="variation-negative fw-semibold">

                                <i class="fa-solid fa-arrow-down"></i>
                                {{ number_format($marginVariation, 1, ',', ' ') }}%

                            </span>

                        @else

                            <span class="variation-neutral fw-semibold">

                                <i class="fa-solid fa-minus"></i>
                                0%

                            </span>

                        @endif


                        <span class="text-muted">

                            par rapport à la période précédente

                        </span>

                    </div>

                </div>

            </div>


            <!-- STOCK -->

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card-kpi h-100">

                    <div class="kpi-icon kpi-icon-purple-alt mb-3">

                        <i class="fa-solid fa-box"></i>

                    </div>


                    <p class="text-muted small mb-1 fw-medium">

                        Produits en stock

                    </p>


                    <h4 class="fw-bold mb-2"
                        style="color: #111827;">

                        {{ number_format($totalStock, 0, ',', ' ') }}

                    </h4>


                    <div class="d-flex align-items-center gap-1"
                         style="font-size: 0.75rem;">

                        <span class="text-muted">

                            Quantité totale disponible

                        </span>

                    </div>

                </div>

            </div>


            <!-- ALERTES -->

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card-kpi h-100">

                    <div class="kpi-icon kpi-icon-red mb-3">

                        <i class="fa-solid fa-triangle-exclamation"></i>

                    </div>


                    <p class="text-muted small mb-1 fw-medium">

                        Alertes stock

                    </p>


                    <h4 class="fw-bold mb-2"
                        style="color: #111827;">

                        {{ number_format($stockAlerts, 0, ',', ' ') }}

                    </h4>


                    <div class="text-danger d-flex align-items-center gap-1"
                         style="font-size: 0.75rem;">

                        <i class="fa-solid fa-circle-exclamation"></i>

                        <span>

                            Produits en rupture ou sous le seuil

                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================================
             GRAPHIQUES
        ====================================================== -->

        <div class="row g-3 mb-4">


            <!-- GRAPHIQUE CA -->

            <div class="col-12 col-xl-8">

                <div class="card-custom h-100">

                    <div class="d-flex align-items-center justify-content-between mb-4">

                        <h6 class="fw-bold mb-0"
                            style="color: #1A202C;">

                            Évolution du chiffre d'affaires

                        </h6>


                        <div class="btn-group btn-group-sm bg-light p-1 rounded-2">

                            <button class="btn btn-sm rounded-2 text-white fw-medium"
                                    style="background-color: var(--purple-sidebar);">

                                7 jours

                            </button>


                            <button class="btn btn-sm rounded-2 text-muted fw-medium border-0">

                                30 jours

                            </button>


                            <button class="btn btn-sm rounded-2 text-muted fw-medium border-0">

                                3 mois

                            </button>

                        </div>

                    </div>


                    <!-- GRAPHE -->

                    <div class="pt-2">

                        @php

                            $chartValues = $salesChart->pluck('amount')->toArray();

                            $maxChartValue = max($chartValues ?: [0]);

                            if ($maxChartValue <= 0) {
                                $maxChartValue = 1;
                            }

                            $chartPoints = [];

                            $count = count($salesChart);

                            if ($count > 0) {

                                foreach ($salesChart as $index => $day) {

                                    $x = $count === 1
                                        ? 250
                                        : 10 + ($index * (480 / ($count - 1)));

                                    $ratio = $day['amount'] / $maxChartValue;

                                    $y = 140 - ($ratio * 115);

                                    $chartPoints[] = [
                                        'x' => round($x, 2),
                                        'y' => round($y, 2),
                                    ];

                                }

                            }

                            $polylinePoints = collect($chartPoints)
                                ->map(fn ($point) => $point['x'] . ',' . $point['y'])
                                ->implode(' ');

                            $areaPoints = $polylinePoints;

                            if (!empty($chartPoints)) {

                                $areaPoints .= ' ' .
                                    $chartPoints[count($chartPoints) - 1]['x'] .
                                    ',160 ' .
                                    $chartPoints[0]['x'] .
                                    ',160';

                            }

                        @endphp


                        <svg viewBox="0 0 500 170"
                             class="w-100"
                             style="max-height: 200px;">


                            <defs>

                                <linearGradient id="chartGradient"
                                                x1="0"
                                                y1="0"
                                                x2="0"
                                                y2="1">

                                    <stop offset="0%"
                                          stop-color="#5B2C6F"
                                          stop-opacity="0.25"/>

                                    <stop offset="100%"
                                          stop-color="#5B2C6F"
                                          stop-opacity="0"/>

                                </linearGradient>

                            </defs>


                            <!-- Lignes -->

                            <line x1="0"
                                  y1="20"
                                  x2="500"
                                  y2="20"
                                  stroke="#F1F5F9"
                                  stroke-dasharray="4"/>


                            <line x1="0"
                                  y1="60"
                                  x2="500"
                                  y2="60"
                                  stroke="#F1F5F9"
                                  stroke-dasharray="4"/>


                            <line x1="0"
                                  y1="100"
                                  x2="500"
                                  y2="100"
                                  stroke="#F1F5F9"
                                  stroke-dasharray="4"/>


                            <line x1="0"
                                  y1="140"
                                  x2="500"
                                  y2="140"
                                  stroke="#F1F5F9"
                                  stroke-dasharray="4"/>


                            @if(!empty($chartPoints))

                                <!-- Zone -->

                                <polygon points="{{ $areaPoints }}"
                                         fill="url(#chartGradient)"/>


                                <!-- Ligne -->

                                <polyline points="{{ $polylinePoints }}"
                                          fill="none"
                                          stroke="#5B2C6F"
                                          stroke-width="2.5"/>


                                <!-- Points -->

                                @foreach($chartPoints as $point)

                                    <circle cx="{{ $point['x'] }}"
                                            cy="{{ $point['y'] }}"
                                            r="3.5"
                                            fill="#5B2C6F"/>

                                @endforeach

                            @endif

                        </svg>


                        <div class="d-flex justify-content-between text-muted small mt-2"
                             style="font-size: 0.725rem;">

                            @foreach($salesChart as $day)

                                <span>
                                    {{ $day['date'] }}
                                </span>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>


            <!-- RÉSUMÉ MARGES -->

            <div class="col-12 col-xl-4">

                <div class="card-custom h-100">

                    <h6 class="fw-bold mb-3"
                        style="color: #1A202C;">

                        Résumé des marges

                    </h6>


                    <div class="row align-items-center my-3">

                        <div class="col-5">

                            <div class="donut-wrapper">

                                <div class="donut-center">

                                    {{ number_format($marginRate, 0, ',', ' ') }}%

                                </div>

                            </div>

                        </div>


                        <div class="col-7">


                            <!-- COÛT -->

                            <div class="mb-3">

                                <div class="d-flex align-items-center gap-1 text-muted small">

                                    <span class="rounded-circle d-inline-block"
                                          style="width:8px;
                                                 height:8px;
                                                 background-color:#CBD5E1;"></span>

                                    <span>
                                        Coût d'achat
                                    </span>

                                </div>


                                <div class="fw-bold"
                                     style="font-size: 0.85rem;">

                                    {{ number_format($costOfSales, 0, ',', ' ') }}
                                    FCFA

                                    <span class="text-muted fw-normal">

                                        {{ $currentRevenue > 0
                                            ? number_format(($costOfSales / $currentRevenue) * 100, 0, ',', ' ')
                                            : 0
                                        }}%

                                    </span>

                                </div>

                            </div>


                            <!-- MARGE -->

                            <div>

                                <div class="d-flex align-items-center gap-1 text-muted small">

                                    <span class="rounded-circle d-inline-block"
                                          style="width:8px;
                                                 height:8px;
                                                 background-color:#5B2C6F;"></span>

                                    <span>
                                        Marges
                                    </span>

                                </div>


                                <div class="fw-bold"
                                     style="font-size: 0.85rem;">

                                    {{ number_format($currentMargin, 0, ',', ' ') }}
                                    FCFA

                                    <span class="text-muted fw-normal">

                                        {{ number_format($marginRate, 0, ',', ' ') }}%

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="pt-3 border-top d-flex justify-content-between align-items-center"
                         style="font-size: 0.8rem;">

                        <span class="text-muted">
                            Chiffre d'affaires
                        </span>


                        <span class="fw-bold">

                            {{ number_format($currentRevenue, 0, ',', ' ') }}
                            FCFA

                            <span class="text-muted fw-normal">
                                100%
                            </span>

                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================================
             WIDGETS
        ====================================================== -->

        <div class="row g-3 mb-4">


            <!-- TAUX DE CHANGE -->

            <div class="col-12 col-md-6">

                <div class="card-custom h-100">

                    <div class="d-flex align-items-center justify-content-between mb-2">

                        <span class="fw-semibold text-muted"
                              style="font-size: 0.8rem;">

                            Taux de change NGN → XOF

                        </span>


                        <i class="fa-solid fa-rotate text-muted"
                           style="font-size: 0.75rem;"></i>

                    </div>


                    @if($exchangeRate)

                        <h5 class="fw-bold mb-1"
                            style="color: #1A202C;">

                            1 NGN =
                            {{ number_format($exchangeRate->rate, 2, ',', ' ') }}
                            FCFA

                        </h5>


                        <p class="text-muted small mb-2"
                           style="font-size: 0.725rem;">

                            (taux {{ $exchangeRate->source === 'api'
                                ? 'automatique'
                                : 'manuel'
                            }})

                        </p>


                        @if($exchangeRate->isStale())

                            <div class="d-inline-flex align-items-center gap-1 badge-faible px-2 py-1 rounded-2 mb-1">

                                <i class="fa-solid fa-triangle-exclamation"></i>

                                <span>
                                    Taux à actualiser
                                </span>

                            </div>

                        @else

                            <div class="d-inline-flex align-items-center gap-1 badge-taux px-2 py-1 rounded-2 mb-1">

                                <i class="fa-solid fa-circle-check"></i>

                                <span>
                                    Taux à jour
                                </span>

                            </div>

                        @endif


                        <p class="text-muted mb-0"
                           style="font-size: 0.68rem;">

                            Dernière mise à jour :
                            {{ $exchangeRate->rate_date->format('d/m/Y') }}

                        </p>

                    @else

                        <h5 class="fw-bold mb-2"
                            style="color: #1A202C;">

                            Aucun taux enregistré

                        </h5>


                        <div class="d-inline-flex align-items-center gap-1 badge-non-configure px-2 py-1 rounded-2">

                            <i class="fa-solid fa-circle-info"></i>

                            <span>
                                Taux non configuré
                            </span>

                        </div>

                    @endif

                </div>

            </div>


            <!-- CAISSE -->

            <div class="col-12 col-md-6">

                <div class="card-custom h-100">

                    <div class="d-flex align-items-center gap-2 mb-3">

                        <i class="fa-solid fa-cash-register text-muted"></i>

                        <span class="fw-semibold text-muted"
                              style="font-size: 0.8rem;">

                            Caisse

                            <span class="fw-normal">
                                (session actuelle)
                            </span>

                        </span>

                    </div>


                    <div class="d-flex justify-content-between align-items-center gap-3">

                        <div>

                            <h6 class="fw-bold mb-1"
                                style="color: #1A202C;">

                                Module caisse non configuré

                            </h6>


                            <p class="text-muted mb-0"
                               style="font-size: 0.725rem;">

                                Les ventes sont enregistrées, mais aucune session de caisse n'est encore disponible.

                            </p>

                        </div>


                        <span class="badge-non-configure px-2 py-1 rounded-2 flex-shrink-0">

                            À venir

                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================================
             TABLEAUX
        ====================================================== -->

        <div class="row g-3 mb-4">


            <!-- PRODUITS LES PLUS VENDUS -->

            <div class="col-12 col-xl-7">

                <div class="card-custom h-100">


                    <div class="d-flex align-items-center justify-content-between mb-3">

                        <div class="d-flex align-items-center gap-2">

                            <i class="fa-solid fa-trophy text-warning fs-6"></i>

                            <h6 class="fw-bold mb-0">

                                Produits les plus vendus

                            </h6>

                        </div>


                        <a href="{{ route('sales.index') }}"
                           class="small text-decoration-none fw-semibold"
                           style="color: var(--purple-main);">

                            Voir tout →

                        </a>

                    </div>


                    <div class="table-responsive">

                        <table class="table table-custom mb-0">

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Produit</th>

                                    <th>Catégorie</th>

                                    <th>Quantité vendue</th>

                                    <th class="text-end">
                                        CA (FCFA)
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($topProducts as $index => $item)

                                    @php
                                        $product = $item['product'];
                                    @endphp


                                    <tr>

                                        <td>
                                            {{ $index + 1 }}
                                        </td>


                                        <td>

                                            <div class="d-flex align-items-center gap-2">

                                                <div class="product-img-placeholder">

                                                    @if($product->type === 'vehicule')

                                                        <i class="fa-solid fa-car"></i>

                                                    @else

                                                        <i class="fa-solid fa-box"></i>

                                                    @endif

                                                </div>


                                                <div>

                                                    <span class="fw-medium">

                                                        {{ $product->name }}

                                                    </span>


                                                    <div class="text-muted"
                                                         style="font-size: 0.68rem;">

                                                        {{ $product->reference }}

                                                    </div>

                                                </div>

                                            </div>

                                        </td>


                                        <td class="text-muted">

                                            {{ $product->category ?: '—' }}

                                        </td>


                                        <td>

                                            {{ number_format($item['quantity'], 0, ',', ' ') }}

                                        </td>


                                        <td class="text-end fw-semibold">

                                            {{ number_format($item['revenue'], 0, ',', ' ') }}

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="5"
                                            class="text-center text-muted py-4">

                                            Aucune vente enregistrée sur la période.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            <!-- ALERTES STOCK -->

            <div class="col-12 col-xl-5">

                <div class="card-custom h-100">


                    <div class="d-flex align-items-center justify-content-between mb-3">

                        <div class="d-flex align-items-center gap-2">

                            <i class="fa-solid fa-triangle-exclamation text-danger fs-6"></i>

                            <h6 class="fw-bold mb-0">

                                Alertes de stock

                            </h6>

                        </div>


                        <a href="{{ route('stock.index') }}"
                           class="small text-decoration-none fw-semibold"
                           style="color: var(--purple-main);">

                            Voir tout →

                        </a>

                    </div>


                    <div class="table-responsive">

                        <table class="table table-custom mb-0">

                            <thead>

                                <tr>

                                    <th>Produit</th>

                                    <th>Stock actuel</th>

                                    <th>Seuil</th>

                                    <th>Statut</th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($stockAlertProducts as $product)

                                    <tr>

                                        <td class="fw-medium">

                                            {{ $product->name }}

                                        </td>


                                        <td class="{{ $product->quantity <= 0 ? 'text-danger fw-bold' : 'text-warning fw-bold' }}">

                                            {{ number_format($product->quantity, 0, ',', ' ') }}

                                        </td>


                                        <td>

                                            {{ number_format($product->stock_minimum, 0, ',', ' ') }}

                                        </td>


                                        <td>

                                            @if($product->quantity <= 0)

                                                <span class="badge badge-rupture rounded-pill">

                                                    Rupture

                                                </span>

                                            @else

                                                <span class="badge badge-faible rounded-pill">

                                                    Faible

                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="4"
                                            class="text-center text-muted py-4">

                                            <i class="fa-solid fa-circle-check text-success me-1"></i>

                                            Aucun produit en alerte.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>


        <!-- =====================================================
             FOOTER BANNER
        ====================================================== -->

        <div class="card-custom d-flex align-items-center justify-content-between flex-wrap gap-2">

            <div class="d-flex align-items-center gap-3">

                <i class="fa-regular fa-lightbulb text-warning fs-5"></i>


                <span class="text-muted small">

                    Pensez à mettre à jour régulièrement le taux de change pour assurer une conversion automatique correcte des devises (NGN → FCFA).

                </span>

            </div>


            <a href="{{ route('stock.entries.create') }}"
               class="btn btn-purple ms-auto">

                <i class="fa-solid fa-plus me-1"></i>

                Nouvelle entrée de stock

            </a>

        </div>


    </main>


    <!-- =========================================================
         MOBILE SIDEBAR
    ========================================================== -->

    <script>

        (function () {

            const sidebar = document.getElementById('sidebar');

            const overlay = document.getElementById('sidebarOverlay');

            const toggle = document.getElementById('sidebarToggle');

            const close = document.getElementById('sidebarClose');


            if (!sidebar || !toggle) {
                return;
            }


            function openMenu() {

                sidebar.classList.add('open');

                if (overlay) {
                    overlay.classList.add('show');
                }

                document.body.style.overflow = 'hidden';

            }


            function closeMenu() {

                sidebar.classList.remove('open');

                if (overlay) {
                    overlay.classList.remove('show');
                }

                document.body.style.overflow = '';

            }


            toggle.addEventListener('click', openMenu);


            if (close) {
                close.addEventListener('click', closeMenu);
            }


            if (overlay) {
                overlay.addEventListener('click', closeMenu);
            }


            document.addEventListener('keydown', function (event) {

                if (event.key === 'Escape') {

                    closeMenu();

                }

            });


            window.addEventListener('resize', function () {

                if (window.innerWidth >= 992) {

                    closeMenu();

                }

            });

        })();

    </script>


</body>

</html>