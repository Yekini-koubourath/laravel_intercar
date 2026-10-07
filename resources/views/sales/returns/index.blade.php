<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Retours - INTERCAR</title>


    <!-- =====================================================
         BOOTSTRAP
    ====================================================== -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- =====================================================
         FONT AWESOME
    ====================================================== -->

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >


    <style>

        /* =====================================================
           BASE
        ====================================================== */

        body {
            margin: 0;
            background: #f5f6fa;
            font-family: Inter, Arial, sans-serif;
        }


        /* =====================================================
           SIDEBAR
        ====================================================== */

        .app-sidebar {
            position: fixed;

            top: 0;
            left: 0;

            width: 250px;
            height: 100vh;

            overflow-y: auto;

            background: #30173D;

            z-index: 1100;

            transition: transform .25s ease;
        }


        /* =====================================================
           OVERLAY
        ====================================================== */

        .sidebar-overlay {
            display: none;

            position: fixed;

            inset: 0;

            background: rgba(26, 11, 46, .55);

            z-index: 1050;
        }


        .sidebar-overlay.show {
            display: block;
        }


        /* =====================================================
           MAIN
        ====================================================== */

        .main-wrapper {
            margin-left: 250px;

            min-height: 100vh;

            padding: 30px;
        }


        /* =====================================================
           TOPBAR
        ====================================================== */

        .topbar {
            background: #fff;

            border: 1px solid #e2e8f0;

            border-radius: 14px;

            padding: 12px 20px;

            margin-bottom: 25px;

            box-shadow: 0 2px 8px rgba(0, 0, 0, .03);

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;
        }


        .topbar-left {
            display: flex;

            align-items: center;

            gap: 12px;
        }


        .sidebar-toggle {
            width: 42px;
            height: 42px;

            display: none;

            align-items: center;
            justify-content: center;

            border-radius: 9px;
        }


        .topbar-title {
            font-weight: 600;

            color: #2d3748;
        }


        .topbar-subtitle {
            font-size: .78rem;

            color: #718096;
        }


        .topbar-user {
            display: flex;

            align-items: center;

            gap: 10px;
        }


        .topbar-avatar {
            width: 36px;
            height: 36px;

            border-radius: 50%;

            background: #30173D;

            color: #fff;

            display: flex;

            align-items: center;
            justify-content: center;

            font-weight: 700;
        }


        /* =====================================================
           CARDS
        ====================================================== */

        .card-page {
            background: #fff;

            border-radius: 14px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);

            overflow: hidden;
        }


        .stat-card {
            background: #fff;

            border-radius: 14px;

            padding: 20px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }


        /* =====================================================
           TABLE
        ====================================================== */

        .table {
            font-size: .86rem;
        }


        .table th {
            white-space: nowrap;

            font-size: .78rem;
        }


        /* =====================================================
           MOBILE
        ====================================================== */

        @media (max-width: 991.98px) {

            .app-sidebar {
                transform: translateX(-100%);

                max-width: 85vw;
            }


            .app-sidebar.open {
                transform: translateX(0);
            }


            .main-wrapper {
                margin-left: 0;

                padding: 20px;
            }


            .sidebar-toggle {
                display: inline-flex;
            }


            .topbar {
                padding: 10px 12px;
            }

        }


        @media (max-width: 575.98px) {

            .main-wrapper {
                padding: 12px;
            }


            .topbar {
                border-radius: 10px;
            }


            .topbar-user span {
                display: none;
            }

        }

    </style>

</head>


<body>


<!-- =========================================================
     SIDEBAR
========================================================== -->

<aside class="app-sidebar" id="appSidebar">

    @include('auth.partials.sidebar')

</aside>


<!-- =========================================================
     OVERLAY
========================================================== -->

<div
    class="sidebar-overlay"
    id="sidebarOverlay"
></div>


<!-- =========================================================
     CONTENU PRINCIPAL
========================================================== -->

<div class="main-wrapper">


    <!-- =====================================================
         TOPBAR
    ====================================================== -->

    <header class="topbar">


        <div class="topbar-left">


            <!-- BURGER -->

            <button
                type="button"
                class="btn btn-light border sidebar-toggle"
                id="sidebarToggle"
                aria-label="Ouvrir le menu"
            >

                <i class="fa-solid fa-bars"></i>

            </button>


            <!-- TITRE -->

            <div>

                <div class="topbar-title">
                    Gestion des ventes
                </div>

                <div class="topbar-subtitle">
                    Retours
                </div>

            </div>


        </div>


        <!-- UTILISATEUR -->

        <div class="topbar-user">

            <div class="topbar-avatar">

                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

            </div>


            <span class="fw-semibold">

                {{ Auth::user()->name }}

            </span>

        </div>


    </header>


    <!-- =====================================================
         EN-TÊTE
    ====================================================== -->

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">


        <div>

            <h1 class="h4 fw-bold mb-1">
                Retours
            </h1>

            <p class="text-muted mb-0">
                Gestion des produits retournés par les clients.
            </p>

        </div>


        <a
            href="{{ route('sales.index') }}"
            class="btn btn-warning"
        >

            <i class="fa-solid fa-arrow-right me-1"></i>

            Choisir une vente

        </a>


    </div>


    <!-- =====================================================
         MESSAGE SUCCÈS
    ====================================================== -->

    @if(session('success'))

        <div class="alert alert-success">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

        </div>

    @endif


    <!-- =====================================================
         STATS
    ====================================================== -->

    <div class="row g-3 mb-4">


        <div class="col-md-6">

            <div class="stat-card">

                <div class="text-muted small">
                    Nombre de retours
                </div>

                <div class="fs-4 fw-bold">
                    {{ $totalReturns }}
                </div>

            </div>

        </div>


        <div class="col-md-6">

            <div class="stat-card">

                <div class="text-muted small">
                    Montant total retourné
                </div>

                <div class="fs-4 fw-bold">

                    {{ number_format(
                        $totalAmount,
                        0,
                        ',',
                        ' '
                    ) }}

                    FCFA

                </div>

            </div>

        </div>


    </div>


    <!-- =====================================================
         RECHERCHE
    ====================================================== -->

    <div class="card-page p-4 mb-4">

        <form method="GET">


            <div class="row g-3">


                <div class="col-md-10">

                    <input
                        type="text"
                        name="q"
                        class="form-control"
                        value="{{ request('q') }}"
                        placeholder="N° retour, N° vente, client..."
                    >

                </div>


                <div class="col-md-2">

                    <button
                        type="submit"
                        class="btn btn-dark w-100"
                    >

                        Rechercher

                    </button>

                </div>


            </div>


        </form>

    </div>


    <!-- =====================================================
         TABLE
    ====================================================== -->

    <div class="card-page">


        <div class="table-responsive">


            <table class="table table-hover align-middle mb-0">


                <thead class="table-light">


                    <tr>

                        <th>N° retour</th>

                        <th>Vente</th>

                        <th>Date</th>

                        <th>Client</th>

                        <th>Montant</th>

                        <th>Enregistré par</th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>


                </thead>


                <tbody>


                    @forelse($returns as $return)


                        <tr>


                            <td>

                                <strong>
                                    {{ $return->number }}
                                </strong>

                            </td>


                            <td>

                                <a
                                    href="{{ route('sales.show', $return->sale) }}"
                                    class="text-decoration-none"
                                >

                                    {{ $return->sale->number }}

                                </a>

                            </td>


                            <td>

                                {{ $return->return_date->format('d/m/Y') }}

                            </td>


                            <td>

                                {{ $return->sale->customer_name ?: 'Client comptoir' }}

                            </td>


                            <td>

                                <strong>

                                    {{ number_format(
                                        $return->total,
                                        0,
                                        ',',
                                        ' '
                                    ) }}

                                    FCFA

                                </strong>

                            </td>


                            <td>

                                {{ $return->user->name ?? '—' }}

                            </td>


                            <td class="text-end">


                                <a
                                    href="{{ route('sales.returns.show', $return) }}"
                                    class="btn btn-sm btn-outline-dark"
                                >

                                    <i class="fa-solid fa-eye"></i>

                                </a>


                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5 text-muted"
                            >

                                <i class="fa-solid fa-rotate-left fa-2x mb-3"></i>

                                <p class="mb-0">
                                    Aucun retour enregistré.
                                </p>

                            </td>

                        </tr>


                    @endforelse


                </tbody>


            </table>


        </div>


        @if($returns->hasPages())

            <div class="p-3">

                {{ $returns->links() }}

            </div>

        @endif


    </div>


</div>


<!-- =========================================================
     JAVASCRIPT
========================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('appSidebar');

    const overlay = document.getElementById('sidebarOverlay');

    const toggle = document.getElementById('sidebarToggle');


    if (!sidebar || !overlay || !toggle) {
        return;
    }


    function openSidebar() {

        sidebar.classList.add('open');

        overlay.classList.add('show');

        document.body.style.overflow = 'hidden';

    }


    function closeSidebar() {

        sidebar.classList.remove('open');

        overlay.classList.remove('show');

        document.body.style.overflow = '';

    }


    toggle.addEventListener('click', function () {

        if (sidebar.classList.contains('open')) {

            closeSidebar();

        } else {

            openSidebar();

        }

    });


    overlay.addEventListener('click', closeSidebar);


    window.addEventListener('resize', function () {

        if (window.innerWidth > 991.98) {

            closeSidebar();

        }

    });

});

</script>


</body>

</html>