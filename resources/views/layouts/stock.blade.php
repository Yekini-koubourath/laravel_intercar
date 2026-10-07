<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Stock') - INTERCAR</title>

    <!-- =========================================================
         BOOTSTRAP
    ========================================================== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- =========================================================
         BOOTSTRAP ICONS
    ========================================================== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- =========================================================
         FONT AWESOME
    ========================================================== -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- =========================================================
         GOOGLE FONT - INTER
    ========================================================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>

        /* =========================================================
           VARIABLES
        ========================================================== */

        :root {
            --purple: #6f42c1;
            --purple-dark: #512d91;
            --purple-light: #f1ebfb;
            --purple-border: #ddd0f2;

            --bg-body: #f5f6f8;
            --text: #2d3748;
            --muted: #718096;
            --border: #e2e8f0;

            --sidebar-width: 250px;
        }


        /* =========================================================
           BASE
        ========================================================== */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg-body);
            font-family: 'Inter', sans-serif;
            color: var(--text);
            font-size: .875rem;
        }


        /* =========================================================
           SIDEBAR
        ========================================================== */

        .sidebar {
            width: var(--sidebar-width);
            background-color: #30173D;

            min-height: 100vh;
            height: 100vh;

            position: fixed;
            top: 0;
            left: 0;

            z-index: 1100;

            overflow-y: auto;

            transition: transform .25s ease;
        }


        .sidebar-brand {
            padding: 1.5rem 1rem 1rem;
        }


        .sidebar .nav-link {
            color: rgba(255, 255, 255, .7);

            font-size: .85rem;
            font-weight: 500;

            padding: .65rem 1rem;

            border-radius: 8px;

            margin-bottom: 3px;

            display: flex;
            align-items: center;

            gap: 12px;
        }


        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, .08);
        }


        .sidebar .nav-link.active {
            color: #fff;
            background-color: #F37021;
            font-weight: 600;
        }


        /* =========================================================
           OVERLAY MOBILE
        ========================================================== */

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


        /* =========================================================
           MAIN
        ========================================================== */

        .main-wrapper {
            margin-left: var(--sidebar-width);

            min-height: 100vh;

            padding: 1.5rem 2rem 7rem;
        }


        /* =========================================================
           TOPBAR
        ========================================================== */

        .stock-topbar {
            background: #fff;

            border: 1px solid var(--border);

            border-radius: 14px;

            padding: .75rem 1.25rem;

            margin-bottom: 1.5rem;

            box-shadow: 0 2px 8px rgba(0, 0, 0, .03);

            position: sticky;
            top: 1rem;

            z-index: 900;
        }


        /* =========================================================
           BURGER
        ========================================================== */

        #sidebarToggle {
            width: 42px;
            height: 42px;

            display: none;

            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 9px;
        }


        /* =========================================================
           TITRES
        ========================================================== */

        .page-title {
            font-size: 1.45rem;
            font-weight: 700;
        }


        .page-subtitle {
            color: var(--muted);
            font-size: .84rem;
        }


        /* =========================================================
           CARDS
        ========================================================== */

        .section-card {
            background: #fff;

            border: 1px solid var(--border);

            border-radius: 14px;

            box-shadow: 0 2px 8px rgba(0, 0, 0, .025);

            margin-bottom: 1rem;

            overflow: hidden;
        }


        .section-header {
            display: flex;
            align-items: center;

            gap: .75rem;

            padding: 1rem 1.25rem;

            border-bottom: 1px solid var(--border);
        }


        .section-number {
            width: 34px;
            height: 34px;

            flex-shrink: 0;

            border-radius: 9px;

            background: var(--purple-light);

            color: var(--purple);

            display: flex;
            align-items: center;
            justify-content: center;

            font-weight: 700;
        }


        .section-title {
            margin: 0;

            font-size: .95rem;

            font-weight: 700;
        }


        .section-description {
            margin: 2px 0 0;

            color: var(--muted);

            font-size: .75rem;
        }


        .section-body {
            padding: 1.25rem;
        }


        /* =========================================================
           FORMULAIRES
        ========================================================== */

        .form-label {
            margin-bottom: .4rem;

            color: #4a5568;

            font-size: .78rem;

            font-weight: 600;
        }


        .required {
            color: #dc3545;
        }


        .form-control,
        .form-select {
            min-height: 42px;

            border-color: #dfe3e8;

            border-radius: 8px;

            font-size: .82rem;
        }


        .form-control:focus,
        .form-select:focus {
            border-color: var(--purple);

            box-shadow: 0 0 0 .2rem rgba(111, 66, 193, .12);
        }


        .input-group-text {
            background: #f8f9fb;

            border-color: #dfe3e8;

            color: var(--muted);

            font-size: .8rem;
        }


        /* =========================================================
           PRODUITS
        ========================================================== */

        .product-search-wrapper {
            position: relative;
        }


        .product-results {
            position: absolute;

            top: calc(100% + 5px);

            left: 0;
            right: 0;

            z-index: 1000;

            display: none;

            max-height: 280px;

            overflow-y: auto;

            background: #fff;

            border: 1px solid var(--border);

            border-radius: 10px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, .12);
        }


        .product-results.show {
            display: block;
        }


        .product-result-item {
            padding: .75rem .9rem;

            border-bottom: 1px solid #f0f1f3;

            cursor: pointer;
        }


        .product-result-item:hover {
            background: var(--purple-light);
        }


        .selected-product {
            display: none;

            margin-top: .75rem;

            padding: .85rem;

            background: #faf8ff;

            border: 1px solid var(--purple-border);

            border-radius: 10px;
        }


        .selected-product.show {
            display: block;
        }


        /* =========================================================
           CALCUL
        ========================================================== */

        .calculation-box {
            padding: .9rem 1rem;

            background: #fafafa;

            border: 1px solid var(--border);

            border-radius: 10px;
        }


        .calculation-row {
            display: flex;

            justify-content: space-between;

            padding: .4rem 0;
        }


        .calculation-row.total {
            border-top: 1px solid var(--border);

            margin-top: .4rem;

            padding-top: .75rem;

            font-weight: 700;
        }


        /* =========================================================
           STOCK
        ========================================================== */

        .sticky-side {
            position: sticky;
            top: 1rem;
        }


        .stock-preview {
            padding: 1rem;

            background: linear-gradient(135deg, #f7f2ff, #fff);

            border: 1px solid var(--purple-border);

            border-radius: 12px;

            text-align: center;
        }


        .stock-number {
            color: var(--purple);

            font-size: 2rem;

            font-weight: 700;
        }


        .stat-number {
            font-size: 1.5rem;

            font-weight: 700;
        }


        .info-line {
            display: flex;

            justify-content: space-between;

            gap: 1rem;

            padding: .55rem 0;

            border-bottom: 1px solid #f0f1f3;
        }


        .info-line:last-child {
            border-bottom: 0;
        }


        /* =========================================================
           BOUTONS
        ========================================================== */

        .btn-purple {
            background: var(--purple);

            border-color: var(--purple);

            color: #fff;

            font-weight: 600;
        }


        .btn-purple:hover {
            background: var(--purple-dark);

            border-color: var(--purple-dark);

            color: #fff;
        }


        /* =========================================================
           BOTTOM ACTIONS
        ========================================================== */

        .bottom-actions {
            position: fixed;

            right: 0;
            bottom: 0;
            left: var(--sidebar-width);

            z-index: 900;

            padding: .85rem 2rem;

            background: rgba(255, 255, 255, .97);

            border-top: 1px solid var(--border);
        }


        /* =========================================================
           TABLEAUX
        ========================================================== */

        .table {
            font-size: .82rem;
        }


        .table th {
            font-size: .76rem;
            font-weight: 600;

            white-space: nowrap;
        }


        .table td {
            vertical-align: middle;
        }


        /* =========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 991.98px) {

            .sidebar {
                transform: translateX(-100%);
                max-width: 85vw;
            }


            .sidebar.open {
                transform: translateX(0);
            }


            .main-wrapper {
                margin-left: 0;

                padding: 1rem 1rem 7rem;
            }


            .bottom-actions {
                left: 0;

                padding: .75rem 1rem;
            }


            .sticky-side {
                position: static;
            }


            #sidebarToggle {
                display: inline-flex;
            }


            .stock-topbar {
                top: .75rem;

                padding: .65rem .75rem;
            }
        }


        @media (max-width: 575.98px) {

            .main-wrapper {
                padding-left: .75rem;
                padding-right: .75rem;
            }


            .stock-topbar {
                border-radius: 10px;
            }
        }

    </style>

    @stack('styles')

</head>


<body>

    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}

    @include('auth.partials.sidebar')


    {{-- =========================================================
         OVERLAY MOBILE
    ========================================================== --}}

    <div class="sidebar-overlay" id="sidebarOverlay"></div>


    {{-- =========================================================
         CONTENU PRINCIPAL
    ========================================================== --}}

    <main class="main-wrapper">


        {{-- =====================================================
             TOPBAR
        ====================================================== --}}

        <header class="stock-topbar d-flex align-items-center justify-content-between gap-2">

            <div class="d-flex align-items-center gap-2">

                <button
                    type="button"
                    class="btn btn-light border"
                    id="sidebarToggle"
                    aria-label="Ouvrir le menu"
                    aria-expanded="false"
                >
                    <i class="fa-solid fa-bars"></i>
                </button>


                <div>
                    <div class="fw-semibold">
                        Gestion du stock
                    </div>

                    <div class="small text-muted">
                        @yield('crumb')
                    </div>
                </div>

            </div>


            {{-- =================================================
                 UTILISATEUR
            ================================================== --}}

            <div class="d-flex align-items-center gap-2">

                <div
                    class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold"
                    style="width:36px;height:36px;background:#30173D;"
                >
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

                <span class="fw-semibold d-none d-sm-inline">
                    {{ Auth::user()->name }}
                </span>

            </div>

        </header>


        {{-- =====================================================
             MESSAGES
        ====================================================== --}}

        @if(session('success'))

            <div class="alert alert-success">

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger">

                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                {{ session('error') }}

            </div>

        @endif


        @if($errors->any())

            <div class="alert alert-danger">

                <strong>Une erreur est survenue :</strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- =====================================================
             CONTENU DE LA PAGE
        ====================================================== --}}

        @yield('content')


    </main>


    <!-- =========================================================
         BOOTSTRAP JS
    ========================================================== -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- =========================================================
         SIDEBAR MOBILE
    ========================================================== -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggle = document.getElementById('sidebarToggle');

            if (!sidebar || !overlay || !toggle) {
                return;
            }


            function openMenu() {

                sidebar.classList.add('open');

                overlay.classList.add('show');

                toggle.setAttribute('aria-expanded', 'true');

                document.body.style.overflow = 'hidden';
            }


            function closeMenu() {

                sidebar.classList.remove('open');

                overlay.classList.remove('show');

                toggle.setAttribute('aria-expanded', 'false');

                document.body.style.overflow = '';
            }


            toggle.addEventListener('click', function () {

                if (sidebar.classList.contains('open')) {

                    closeMenu();

                } else {

                    openMenu();

                }

            });


            overlay.addEventListener('click', closeMenu);


            window.addEventListener('resize', function () {

                if (window.innerWidth > 991.98) {

                    closeMenu();

                }

            });

        });

    </script>


    @stack('scripts')

</body>
</html>