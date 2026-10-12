<!DOCTYPE html>

<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Ventes - INTERCAR</title>

<!-- =========================================================
     BOOTSTRAP 5
========================================================== -->

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
>

<!-- =========================================================
     FONT AWESOME
========================================================== -->

<link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    rel="stylesheet"
>

<style>

    /* =====================================================
       GLOBAL
    ====================================================== */

    body {
        background: #f5f6fa;
        margin: 0;
    }


 
    /* =====================================================
       MAIN
    ====================================================== */

    .main-wrapper {
        margin-left: 250px;
        min-height: 100vh;
    }


    /* =====================================================
       TOPBAR
    ====================================================== */

    .topbar {
        height: 72px;
        background: #ffffff;
        border-bottom: 1px solid #eeeeee;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 30px;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .topbar-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }


    .topbar-title {
        font-size: 18px;
        font-weight: 700;
        color: #30173D;
    }

    .topbar-user {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .topbar-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #30173D;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }


    /* =====================================================
       CONTENT
    ====================================================== */

    .page-content {
        padding: 30px;
    }


    /* =====================================================
       PAGE CARDS
    ====================================================== */

    .page-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,.05);
    }

    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,.05);
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
    }


    /* =====================================================
       BOUTONS
    ====================================================== */

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


    /* =====================================================
       RESPONSIVE
    ====================================================== */

   @media (max-width: 991px) {

    .topbar {
        padding: 0 20px;
    }

    .page-content {
        padding: 20px;
    }
}


    @media (max-width: 575px) {

        .topbar {
            height: 64px;
            padding: 0 15px;
        }

        .topbar-title {
            font-size: 16px;
        }

        .page-content {
            padding: 15px;
        }

    }

</style>

@include('auth.partials.sidebar-layout')
</head>

<body>

<!-- =========================================================
     SIDEBAR
========================================================== -->
@include('auth.partials.sidebar')

<!-- =========================================================
     CONTENU PRINCIPAL
========================================================== -->

<div class="main-wrapper">

<!-- =====================================================
     TOPBAR
====================================================== -->

<header class="topbar">

    <div class="topbar-left">


        <div class="topbar-title">
            Ventes
        </div>

    </div>


    <div class="topbar-user">

        <div class="topbar-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
        </div>

        <div class="d-none d-sm-block">

            <div class="fw-semibold">
                {{ auth()->user()->name ?? 'Utilisateur' }}
            </div>

            <div class="text-muted small">
                Utilisateur
            </div>

        </div>

    </div>

</header>


<!-- =====================================================
     CONTENU
====================================================== -->

<main class="page-content">


    <!-- =================================================
         TITRE + ACTIONS
    ================================================== -->

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h1 class="h4 fw-bold mb-1">
                Ventes
            </h1>

            <p class="text-muted mb-0">
                Gestion des ventes et suivi des transactions.
            </p>

        </div>


        <div class="d-flex gap-2">

            <a
                href="{{ route('sales.returns.index') }}"
                class="btn btn-outline-secondary"
            >
                <i class="fa-solid fa-rotate-left me-1"></i>
                Retours
            </a>


            <a
                href="{{ route('sales.create') }}"
                class="btn btn-intercar"
            >
                <i class="fa-solid fa-plus me-1"></i>
                Nouvelle vente
            </a>

        </div>

    </div>


    <!-- =================================================
         MESSAGE SUCCESS
    ================================================== -->

    @if(session('success'))

        <div class="alert alert-success">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

        </div>

    @endif


    <!-- =================================================
         STATISTIQUES
    ================================================== -->

    <div class="row g-3 mb-4">


        <div class="col-md-3">

            <div class="stat-card">

                <div class="text-muted small">
                    Nombre de ventes
                </div>

                <div class="stat-value">
                    {{ $totalSales }}
                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="stat-card">

                <div class="text-muted small">
                    Montant total
                </div>

                <div class="stat-value">

                    {{ number_format($totalAmount, 0, ',', ' ') }}

                    FCFA

                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="stat-card">

                <div class="text-muted small">
                    Ventes terminées
                </div>

                <div class="stat-value text-success">
                    {{ $completedSales }}
                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="stat-card">

                <div class="text-muted small">
                    Avec retour
                </div>

                <div class="stat-value text-warning">
                    {{ $returnedSales }}
                </div>

            </div>

        </div>

    </div>


    <!-- =================================================
         FILTRES
    ================================================== -->

    <div class="page-card p-4 mb-4">

        <form method="GET">

            <div class="row g-3 align-items-end">


                <div class="col-lg-4">

                    <label class="form-label">
                        Recherche
                    </label>

                    <input
                        type="text"
                        name="q"
                        class="form-control"
                        value="{{ request('q') }}"
                        placeholder="N° vente, client, téléphone..."
                    >

                </div>


                <div class="col-lg-2">

                    <label class="form-label">
                        Statut
                    </label>

                    <select
                        name="status"
                        class="form-select"
                    >

                        <option value="">
                            Tous
                        </option>

                        <option
                            value="terminee"
                            @selected(request('status') === 'terminee')
                        >
                            Terminée
                        </option>

                        <option
                            value="partiellement_retournee"
                            @selected(request('status') === 'partiellement_retournee')
                        >
                            Retour partiel
                        </option>

                        <option
                            value="retournee"
                            @selected(request('status') === 'retournee')
                        >
                            Retournée
                        </option>

                        <option
                            value="annulee"
                            @selected(request('status') === 'annulee')
                        >
                            Annulée
                        </option>

                    </select>

                </div>


                <div class="col-lg-2">

                    <label class="form-label">
                        Du
                    </label>

                    <input
                        type="date"
                        name="from"
                        class="form-control"
                        value="{{ request('from') }}"
                    >

                </div>


                <div class="col-lg-2">

                    <label class="form-label">
                        Au
                    </label>

                    <input
                        type="date"
                        name="to"
                        class="form-control"
                        value="{{ request('to') }}"
                    >

                </div>


                <div class="col-lg-2 d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-dark flex-grow-1"
                    >
                        Filtrer
                    </button>

                    <a
                        href="{{ route('sales.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>

                </div>

            </div>

        </form>

    </div>


    <!-- =================================================
         TABLEAU
    ================================================== -->

    <div class="page-card">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>N° vente</th>

                        <th>Date</th>

                        <th>Client</th>

                        <th>Produits</th>

                        <th>Total</th>

                        <th>Statut</th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($sales as $sale)

                        <tr>

                            <td>

                                <strong>
                                    {{ $sale->number }}
                                </strong>

                            </td>


                            <td>

                                {{ $sale->sale_date->format('d/m/Y') }}

                            </td>


                            <td>

                                {{ $sale->customer_name ?: 'Client comptoir' }}

                                @if($sale->customer_phone)

                                    <br>

                                    <small class="text-muted">

                                        {{ $sale->customer_phone }}

                                    </small>

                                @endif

                            </td>


                            <td>

                                {{ $sale->items_count }}

                            </td>


                            <td>

                                <strong>

                                    {{ number_format($sale->total, 0, ',', ' ') }}

                                    FCFA

                                </strong>

                            </td>


                            <td>

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

                            </td>


                            <td class="text-end">

                                <a
                                    href="{{ route('sales.show', $sale) }}"
                                    class="btn btn-sm btn-outline-dark"
                                    title="Voir"
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

                                <i class="fa-solid fa-file-invoice fa-2x mb-3"></i>

                                <p class="mb-0">
                                    Aucune vente trouvée.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($sales->hasPages())

            <div class="p-3">

                {{ $sales->links() }}

            </div>

        @endif

    </div>


</main>

</div>

<!-- =========================================================
     JAVASCRIPT SIDEBAR
========================================================== -->

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const sidebar = document.getElementById('appSidebar');
        const toggle = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('sidebarOverlay');


        if (!sidebar || !toggle || !overlay) {
            return;
        }


        function openSidebar() {

            sidebar.classList.add('show');
            overlay.classList.add('show');

        }


        function closeSidebar() {

            sidebar.classList.remove('show');
            overlay.classList.remove('show');

        }


        toggle.addEventListener('click', function () {

            if (sidebar.classList.contains('show')) {

                closeSidebar();

            } else {

                openSidebar();

            }

        });


        overlay.addEventListener('click', function () {

            closeSidebar();

        });


        window.addEventListener('resize', function () {

            if (window.innerWidth > 991) {

                closeSidebar();

            }

        });

    });

</script>

</body>

</html>
