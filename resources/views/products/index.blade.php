<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Produits - INTERCAR</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Google Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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

        /* SIDEBAR */

        .sidebar {
            width: 250px;
            background-color: var(--purple-sidebar);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            height: 100vh;
            height: 100dvh;
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

        /* MAIN */

        .main-wrapper {
            margin-left: 250px;
            padding: 1.25rem 2rem 2rem 2rem;
        }

        /* TOP BAR */

        .top-bar {
            background-color: #FFFFFF;
            border-radius: 12px;
            padding: 0.5rem 1.25rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
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

        /* CARDS */

        .card-custom {
            background-color: #FFFFFF;
            border: none;
            border-radius: var(--card-border-radius);
            padding: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }

        /* TABLE */

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

        /* BOUTON */

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

        /* OVERLAY MOBILE */

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

        /* RESPONSIVE */

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

            .card-custom {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    @include('auth.partials.sidebar')


    <!-- CONTENU PRINCIPAL -->
    <main class="main-wrapper">
@if(session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger" id="error-alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
    setTimeout(() => {
        const successAlert = document.getElementById('success-alert');
        const errorAlert = document.getElementById('error-alert');

        if (successAlert) {
            successAlert.remove();
        }

        if (errorAlert) {
            errorAlert.remove();
        }
    }, 2000);
</script>

        <!-- TOP BAR -->
        <header class="top-bar d-flex align-items-center justify-content-between gap-2 mb-4">

            <!-- Bouton menu mobile -->
            <button type="button"
                    class="btn btn-light border d-lg-none flex-shrink-0"
                    id="sidebarToggle"
                    aria-label="Ouvrir le menu">

                <i class="fa-solid fa-bars"></i>

            </button>


            <!-- Recherche générale -->
            <div class="search-box d-flex align-items-center px-3 py-1-5 flex-grow-1">

                <i class="fa-solid fa-magnifying-glass text-muted me-2"></i>

                <input type="text"
                       class="form-control bg-transparent border-0 p-0 fs-6"
                       placeholder="Rechercher un produit, une référence, un client...">

            </div>


            <!-- Actions -->
            <div class="d-flex align-items-center gap-3 flex-shrink-0">

                <!-- Magasin -->
                <div class="d-none d-md-flex align-items-center gap-2 bg-light px-3 py-2 rounded-3 border"
                     style="font-size: 0.8rem;">

                    <i class="fa-solid fa-location-dot text-muted"></i>

                    <div>
                        <div class="fw-semibold lh-1">
                            Magasin principal
                        </div>

                        <div class="text-muted" style="font-size: 0.7rem;">
                            Cotonou, Bénin
                        </div>
                    </div>

                    <i class="fa-solid fa-chevron-down text-muted ms-2"
                       style="font-size: 0.7rem;"></i>

                </div>


                <!-- Notifications -->
                <button class="btn btn-light rounded-circle p-2 position-relative border">

                    <i class="fa-regular fa-bell text-secondary"></i>

                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>

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


        <!-- TITRE DE LA PAGE -->
        <div class="d-flex align-items-center justify-content-between gap-3 mb-4">

            <div class="d-flex align-items-center gap-3">

                <div class="rounded-3 text-white d-flex align-items-center justify-content-center flex-shrink-0"
                     style="background-color: var(--purple-sidebar);
                            width: 42px;
                            height: 42px;">

                    <i class="fa-solid fa-box fs-5"></i>

                </div>

                <div>

                    <h4 class="fw-bold mb-0" style="color: #1A202C;">
                        Produits
                    </h4>

                    <p class="text-muted small mb-0">
                        Gérez vos véhicules et pièces détachées.
                    </p>

                </div>

            </div>


            <!-- Bouton ajouter -->
            <button type="button"
                    class="btn btn-purple"
                    data-bs-toggle="modal"
                    data-bs-target="#addProductModal">

                <i class="fa-solid fa-plus me-2"></i>

                Ajouter un produit

            </button>

        </div>


        <!-- STATISTIQUES -->
        <div class="row g-3 mb-4">

            <!-- Total -->
            <div class="col-12 col-md-4">

                <div class="card-custom h-100">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Total produits
                            </p>

                            <h3 class="fw-bold mb-0">
                                {{ $products->count() }}
                            </h3>

                        </div>

                        <div class="rounded-circle bg-light p-3">

                            <i class="fa-solid fa-box fs-4 text-primary"></i>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Pièces -->
            <div class="col-12 col-md-4">

                <div class="card-custom h-100">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Pièces détachées
                            </p>

                            <h3 class="fw-bold mb-0">
                                {{ $products->where('type', 'piece')->count() }}
                            </h3>

                        </div>

                        <div class="rounded-circle bg-light p-3">

                            <i class="fa-solid fa-gears fs-4 text-warning"></i>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Véhicules -->
            <div class="col-12 col-md-4">

                <div class="card-custom h-100">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Véhicules
                            </p>

                            <h3 class="fw-bold mb-0">
                                {{ $products->where('type', 'vehicule')->count() }}
                            </h3>

                        </div>

                        <div class="rounded-circle bg-light p-3">

                            <i class="fa-solid fa-car fs-4 text-success"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- TABLEAU DES PRODUITS -->
        <div class="card-custom">

            <!-- Recherche et filtres -->
            <div class="row g-3 mb-4">

                <div class="col-12 col-md-6">

                    <div class="input-group">

                        <span class="input-group-text bg-white">

                            <i class="fa-solid fa-magnifying-glass text-muted"></i>

                        </span>

                        <input type="text"
                               class="form-control"
                               id="searchProduct"
                               placeholder="Rechercher un produit...">

                    </div>

                </div>


                <div class="col-12 col-md-3">

                    <select class="form-select" id="filterType">

                        <option value="">
                            Tous les types
                        </option>

                        <option value="piece">
                            Pièces
                        </option>

                        <option value="vehicule">
                            Véhicules
                        </option>

                    </select>

                </div>


                <div class="col-12 col-md-3">

                    <select class="form-select" id="filterStatus">

                        <option value="">
                            Tous les statuts
                        </option>

                        <option value="actif">
                            Actif
                        </option>

                        <option value="inactif">
                            Inactif
                        </option>

                    </select>

                </div>

            </div>


            <!-- TABLE -->
            <div class="table-responsive">

                <table class="table table-custom align-middle mb-0"
                       id="productsTable">

                    <thead>

                        <tr>

                            <th>Référence</th>
                            <th>Produit</th>
                            <th>Catégorie</th>
                            <th>Type</th>
                            <th>Stock</th>
                            <th>Seuil minimum</th>
                            <th>Statut</th>
                            <th class="text-end">Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($products as $product)

                            <tr>

                                <td class="fw-semibold">
                                    {{ $product->reference }}
                                </td>


                                <td>
                                    {{ $product->name }}
                                </td>


                                <td>
                                    {{ $product->category }}
                                </td>


                                <td>

                                    @if($product->type === 'piece')

                                        <span class="badge bg-warning text-dark">
                                            Pièce
                                        </span>

                                    @else

                                        <span class="badge bg-info text-dark">
                                            Véhicule
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <span class="fw-semibold">
                                        {{ $product->quantity }}
                                    </span>

                                    @if(
                                        $product->type === 'piece' &&
                                        $product->quantity <= $product->stock_minimum
                                    )

                                        <span class="badge bg-danger ms-1">
                                            Stock faible
                                        </span>

                                    @endif

                                </td>


                                <td>
                                    {{ $product->stock_minimum }}
                                </td>


                                <td>

                                    @if($product->status === 'actif')

                                        <span class="badge bg-success">
                                            Actif
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Inactif
                                        </span>

                                    @endif

                                </td>


                                <td class="text-end">

                                    <button type="button"
                                            class="btn btn-sm btn-light border"
                                            title="Modifier">

                                        <i class="fa-solid fa-pen"></i>

                                    </button>

                                    <button type="button"
                                            class="btn btn-sm btn-light border text-danger"
                                            title="Supprimer">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center py-5">

                                    <div class="mb-3">

                                        <i class="fa-solid fa-box-open fs-1 text-muted"></i>

                                    </div>

                                    <h5 class="fw-semibold">
                                        Aucun produit
                                    </h5>

                                    <p class="text-muted mb-0">
                                        Aucun produit n'a encore été enregistré.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </main>


    <!-- MODAL AJOUTER PRODUIT -->
    <div class="modal fade"
         id="addProductModal"
         tabindex="-1"
         aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title fw-bold">

                        <i class="fa-solid fa-plus me-2"></i>

                        Ajouter un produit

                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Fermer">
                    </button>

                </div>


                <form method="POST" action="{{ route('products.store') }}">
    @csrf

                    <div class="modal-body">

                        <div class="row g-3">

                            <!-- Référence -->
                            <div class="col-md-6">

                                <label class="form-label">
                                    Référence
                                </label>

                                <input type="text"
                                       class="form-control"
                                       name="reference"
                                       placeholder="Ex : PIE-001">

                            </div>


                            <!-- Nom -->
                            <div class="col-md-6">

                                <label class="form-label">
                                    Nom du produit
                                </label>

                                <input type="text"
                                       class="form-control"
                                       name="name"
                                       placeholder="Ex : Filtre à huile">

                            </div>


                            <!-- Catégorie -->
                            <div class="col-md-6">

                                <label class="form-label">
                                    Catégorie
                                </label>

                                <input type="text"
                                       class="form-control"
                                       name="category"
                                       placeholder="Ex : Moteur">

                            </div>


                            <!-- Type -->
                            <div class="col-md-6">

                                <label class="form-label">
                                    Type
                                </label>

                                <select class="form-select"
                                        name="type">

                                    <option value="">
                                        Sélectionner
                                    </option>

                                    <option value="piece">
                                        Pièce détachée
                                    </option>

                                    <option value="vehicule">
                                        Véhicule
                                    </option>

                                </select>

                            </div>


                            <!-- Quantité -->
                            <div class="col-md-6">

                                <label class="form-label">
                                    Quantité initiale
                                </label>

                                <input type="number"
                                       class="form-control"
                                       name="quantity"
                                       min="0"
                                       value="0">

                                <small class="text-muted">
                                    Cette quantité correspond au stock initial.
                                </small>

                            </div>


                            <!-- Seuil minimum -->
                            <div class="col-md-6">

                                <label class="form-label">
                                    Seuil minimum
                                </label>

                                <input type="number"
                                       class="form-control"
                                       name="stock_minimum"
                                       min="0"
                                       value="0">

                                <small class="text-muted">
                                    Une alerte sera affichée lorsque le stock sera inférieur ou égal à ce seuil.
                                </small>

                            </div>


                            <!-- Statut -->
                            <div class="col-md-6">

                                <label class="form-label">
                                    Statut
                                </label>

                                <select class="form-select"
                                        name="status">

                                    <option value="actif">
                                        Actif
                                    </option>

                                    <option value="inactif">
                                        Inactif
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-light border"
                                data-bs-dismiss="modal">

                            Annuler

                        </button>

                        <button type="submit"
                                class="btn btn-purple">

                            <i class="fa-solid fa-check me-2"></i>

                            Enregistrer

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- MENU MOBILE -->
    <script>

        (function () {

            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggle = document.getElementById('sidebarToggle');
            const close = document.getElementById('sidebarClose');


            function openMenu() {

                sidebar.classList.add('open');

                overlay.classList.add('show');

                document.body.style.overflow = 'hidden';

            }


            function closeMenu() {

                sidebar.classList.remove('open');

                overlay.classList.remove('show');

                document.body.style.overflow = '';

            }


            toggle.addEventListener('click', openMenu);

            close.addEventListener('click', closeMenu);

            overlay.addEventListener('click', closeMenu);


            document.addEventListener('keydown', function (e) {

                if (e.key === 'Escape') {

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


    <!-- RECHERCHE ET FILTRES PRODUITS -->
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput = document.getElementById('searchProduct');

            const filterType = document.getElementById('filterType');

            const filterStatus = document.getElementById('filterStatus');

            const rows = document.querySelectorAll('#productsTable tbody tr');


            function filterProducts() {

                const search = searchInput.value.toLowerCase();

                const type = filterType.value.toLowerCase();

                const status = filterStatus.value.toLowerCase();


                rows.forEach(function (row) {

                    const text = row.textContent.toLowerCase();


                    const matchesSearch = text.includes(search);


                    const matchesType =
                        !type ||
                        text.includes(
                            type === 'piece'
                                ? 'pièce'
                                : 'véhicule'
                        );


                    const matchesStatus =
                        !status ||
                        text.includes(
                            status === 'actif'
                                ? 'actif'
                                : 'inactif'
                        );


                    row.style.display =
                        matchesSearch &&
                        matchesType &&
                        matchesStatus
                            ? ''
                            : 'none';

                });

            }


            searchInput.addEventListener(
                'input',
                filterProducts
            );

            filterType.addEventListener(
                'change',
                filterProducts
            );

            filterStatus.addEventListener(
                'change',
                filterProducts
            );

        });

    </script>

</body>
</html>