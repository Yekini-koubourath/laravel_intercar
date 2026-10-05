<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - INTERCAR</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Google Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

        /* --- SIDEBAR --- */
        .sidebar {
            width: 250px;
            background-color: var(--purple-sidebar);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
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

        /* --- MAIN CONTENT --- */
        .main-wrapper {
            margin-left: 250px;
            padding: 1.25rem 2rem 2rem 2rem;
        }

        /* Top Header */
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
        }

        .search-box input::placeholder {
            color: #A0AEC0;
            font-size: 0.825rem;
        }

        /* KPI Cards */
        .card-kpi {
            background-color: #FFFFFF;
            border: none;
            border-radius: var(--card-border-radius);
            padding: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
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

        .kpi-icon-purple { background-color: #F3E8FF; color: #6B21A8; }
        .kpi-icon-orange { background-color: #FFEDD5; color: #EA580C; }
        .kpi-icon-purple-alt { background-color: #F0E8FF; color: #5B2C6F; }
        .kpi-icon-red { background-color: #FEE2E2; color: #DC2626; }

        /* General Cards */
        .card-custom {
            background-color: #FFFFFF;
            border: none;
            border-radius: var(--card-border-radius);
            padding: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }

        /* Badges */
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

        /* Tables */
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
            display: inline-block;
        }

        /* Custom buttons */
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

        /* Donut Chart Mock */
        .donut-wrapper {
            position: relative;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: conic-gradient(#5B2C6F 0% 30%, #E2E8F0 30% 100%);
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
           RESPONSIVE
           ========================================================= */

        /* Base : sidebar défilable + animation d'ouverture */
        .sidebar {
            height: 100vh;
            height: 100dvh;
            overflow-y: auto;
            transition: transform 0.25s ease;
        }

        /* Fond sombre derrière le menu mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(26, 11, 46, 0.55);
            z-index: 999;
        }
        .sidebar-overlay.show { display: block; }

        /* La recherche peut rétrécir sans casser la barre du haut */
        .search-box { min-width: 0; max-width: 480px; }
        .search-box input { min-width: 0; }

        /* Les en-têtes de cartes passent à la ligne si besoin */
        .card-custom .d-flex.justify-content-between {
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        /* Écrans moyens-larges : montants plus petits pour ne pas déborder */
        @media (min-width: 1200px) and (max-width: 1399.98px) {
            .card-kpi h4 { font-size: 1.1rem; }
        }

        /* Tablette et mobile (< 992px) : menu latéral caché, ouvert via le bouton */
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

        /* Petits mobiles (< 576px) */
        @media (max-width: 575.98px) {
            .main-wrapper { padding: 0.75rem; }
            .top-bar { padding: 0.5rem 0.75rem; }
            .top-bar > .d-flex.gap-3 { gap: 0.5rem !important; }
            .card-kpi, .card-custom { padding: 1rem; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
 @include('auth.partials.sidebar')

    <!-- MAIN CONTENT AREA -->
    <main class="main-wrapper">

        <!-- TOP BAR -->
        <header class="top-bar d-flex align-items-center justify-content-between gap-2 mb-4">
            <!-- Bouton menu (visible seulement sur mobile / tablette) -->
            <button type="button" class="btn btn-light border d-lg-none flex-shrink-0" id="sidebarToggle" aria-label="Ouvrir le menu">
                <i class="fa-solid fa-bars"></i>
            </button>

            <!-- Search -->
            <div class="search-box d-flex align-items-center px-3 py-1-5 flex-grow-1">
                <i class="fa-solid fa-magnifying-glass text-muted me-2"></i>
                <input type="text" class="form-control bg-transparent border-0 p-0 fs-6" placeholder="Rechercher un produit, une référence, un client...">
            </div>

            <!-- Actions Right -->
            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                <!-- Location Selector (caché sur petits écrans) -->
                <div class="d-none d-md-flex align-items-center gap-2 bg-light px-3 py-2 rounded-3 border" style="font-size: 0.8rem;">
                    <i class="fa-solid fa-location-dot text-muted"></i>
                    <div>
                        <div class="fw-semibold lh-1">Magasin principal</div>
                        <div class="text-muted" style="font-size: 0.7rem;">Cotonou, Bénin</div>
                    </div>
                    <i class="fa-solid fa-chevron-down text-muted ms-2" style="font-size: 0.7rem;"></i>
                </div>

                <!-- Notifications -->
                <button class="btn btn-light rounded-circle p-2 position-relative border">
                    <i class="fa-regular fa-bell text-secondary"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                </button>

                <!-- Profile -->
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold"
                         style="width: 36px; height: 36px; background-color: var(--purple-sidebar); font-size: 0.85rem;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="fw-semibold d-none d-sm-inline" style="font-size: 0.85rem;">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm border ms-2" title="Se déconnecter">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- PAGE TITLE -->
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="p-2-5 rounded-3 text-white d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: var(--purple-sidebar); width: 42px; height: 42px;">
                <i class="fa-solid fa-border-all fs-5"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-0" style="color: #1A202C;">Tableau de bord</h4>
                <p class="text-muted small mb-0">Vue d'ensemble de votre activité</p>
            </div>
        </div>

        <!-- 4 KPI CARDS -->
        <div class="row g-3 mb-4">
            <!-- Chiffre d'affaires -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card-kpi h-100">
                    <div class="kpi-icon kpi-icon-purple mb-3">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <p class="text-muted small mb-1 fw-medium">Chiffre d'affaires</p>
                    <h4 class="fw-bold mb-2" style="color: #111827;">12 458 000 FCFA</h4>
                    <div class="d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                        <span class="text-success fw-semibold"><i class="fa-solid fa-arrow-up"></i> +18%</span>
                        <span class="text-muted">par rapport à la période précédente</span>
                    </div>
                </div>
            </div>

            <!-- Marges réalisées -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card-kpi h-100">
                    <div class="kpi-icon kpi-icon-orange mb-3">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <p class="text-muted small mb-1 fw-medium">Marges réalisées</p>
                    <h4 class="fw-bold mb-2" style="color: #111827;">3 742 500 FCFA</h4>
                    <div class="d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                        <span class="text-success fw-semibold"><i class="fa-solid fa-arrow-up"></i> +12%</span>
                        <span class="text-muted">par rapport à la période précédente</span>
                    </div>
                </div>
            </div>

            <!-- Produits en stock -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card-kpi h-100">
                    <div class="kpi-icon kpi-icon-purple-alt mb-3">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <p class="text-muted small mb-1 fw-medium">Produits en stock</p>
                    <h4 class="fw-bold mb-2" style="color: #111827;">1 248</h4>
                    <div class="d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                        <span class="text-success fw-semibold"><i class="fa-solid fa-arrow-up"></i> +5%</span>
                        <span class="text-muted">par rapport à la période précédente</span>
                    </div>
                </div>
            </div>

            <!-- Alertes stock -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card-kpi h-100">
                    <div class="kpi-icon kpi-icon-red mb-3">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <p class="text-muted small mb-1 fw-medium">Alertes stock</p>
                    <h4 class="fw-bold mb-2" style="color: #111827;">23</h4>
                    <div class="text-danger d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>Produits en rupture ou en dessous du seuil</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHARTS SECTION -->
        <div class="row g-3 mb-4">
            <!-- Graphique principal -->
            <div class="col-12 col-xl-8">
                <div class="card-custom h-100">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="fw-bold mb-0" style="color: #1A202C;">Évolution du chiffre d'affaires</h6>
                        <div class="btn-group btn-group-sm bg-light p-1 rounded-2">
                            <button class="btn btn-sm rounded-2 text-white fw-medium" style="background-color: var(--purple-sidebar);">7 jours</button>
                            <button class="btn btn-sm rounded-2 text-muted fw-medium border-0">30 jours</button>
                            <button class="btn btn-sm rounded-2 text-muted fw-medium border-0">3 mois</button>
                        </div>
                    </div>

                    <!-- Graphe SVG -->
                    <div class="pt-2">
                        <svg viewBox="0 0 500 170" class="w-100" style="max-height: 200px;">
                            <defs>
                                <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#5B2C6F" stop-opacity="0.25"/>
                                    <stop offset="100%" stop-color="#5B2C6F" stop-opacity="0.0"/>
                                </linearGradient>
                            </defs>
                            <!-- Lignes horizontales -->
                            <line x1="0" y1="20" x2="500" y2="20" stroke="#F1F5F9" stroke-dasharray="4"/>
                            <line x1="0" y1="60" x2="500" y2="60" stroke="#F1F5F9" stroke-dasharray="4"/>
                            <line x1="0" y1="100" x2="500" y2="100" stroke="#F1F5F9" stroke-dasharray="4"/>
                            <line x1="0" y1="140" x2="500" y2="140" stroke="#F1F5F9" stroke-dasharray="4"/>

                            <!-- Area -->
                            <polygon points="10,140 80,120 150,100 220,90 290,90 360,50 430,65 490,25 490,160 10,160" fill="url(#chartGradient)"/>

                            <!-- Line -->
                            <polyline points="10,140 80,120 150,100 220,90 290,90 360,50 430,65 490,25" fill="none" stroke="#5B2C6F" stroke-width="2.5"/>

                            <!-- Dots -->
                            <circle cx="10" cy="140" r="3.5" fill="#5B2C6F"/>
                            <circle cx="80" cy="120" r="3.5" fill="#5B2C6F"/>
                            <circle cx="150" cy="100" r="3.5" fill="#5B2C6F"/>
                            <circle cx="220" cy="90" r="3.5" fill="#5B2C6F"/>
                            <circle cx="290" cy="90" r="3.5" fill="#5B2C6F"/>
                            <circle cx="360" cy="50" r="3.5" fill="#5B2C6F"/>
                            <circle cx="430" cy="65" r="3.5" fill="#5B2C6F"/>
                            <circle cx="490" cy="25" r="3.5" fill="#5B2C6F"/>
                        </svg>
                        <div class="d-flex justify-content-between text-muted small mt-2" style="font-size: 0.725rem;">
                            <span>21/09</span>
                            <span>22/09</span>
                            <span>23/09</span>
                            <span>24/09</span>
                            <span>25/09</span>
                            <span>26/09</span>
                            <span>27/09</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Résumé des Marges -->
            <div class="col-12 col-xl-4">
                <div class="card-custom h-100">
                    <h6 class="fw-bold mb-3" style="color: #1A202C;">Résumé des marges</h6>

                    <div class="row align-items-center my-3">
                        <div class="col-5">
                            <div class="donut-wrapper">
                                <div class="donut-center">30%</div>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="mb-3">
                                <div class="d-flex align-items-center gap-1 text-muted small">
                                    <span class="rounded-circle d-inline-block" style="width:8px; height:8px; background-color:#CBD5E1;"></span>
                                    <span>Coût d'achat</span>
                                </div>
                                <div class="fw-bold" style="font-size: 0.85rem;">8 710 900 FCFA <span class="text-muted fw-normal">70%</span></div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center gap-1 text-muted small">
                                    <span class="rounded-circle d-inline-block" style="width:8px; height:8px; background-color:#5B2C6F;"></span>
                                    <span>Marges</span>
                                </div>
                                <div class="fw-bold" style="font-size: 0.85rem;">3 742 500 FCFA <span class="text-muted fw-normal">30%</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex justify-content-between align-items-center" style="font-size: 0.8rem;">
                        <span class="text-muted">Chiffre d'affaires</span>
                        <span class="fw-bold">12 458 000 FCFA <span class="text-muted fw-normal">100%</span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- WIDGETS LOWER ROW -->
        <div class="row g-3 mb-4">
            <!-- Taux de change -->
            <div class="col-12 col-md-6">
                <div class="card-custom h-100">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-semibold text-muted" style="font-size: 0.8rem;">Taux de change NGN → XOF</span>
                        <i class="fa-solid fa-rotate text-muted" style="font-size: 0.75rem; cursor: pointer;"></i>
                    </div>
                    <h5 class="fw-bold mb-1" style="color: #1A202C;">1 NGN = 0,64 FCFA</h5>
                    <p class="text-muted small mb-2" style="font-size: 0.725rem;">(taux indicatif)</p>
                    <div class="d-inline-flex align-items-center gap-1 badge-taux px-2 py-1 rounded-2 mb-1">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>Taux à jour</span>
                    </div>
                    <p class="text-muted mb-0" style="font-size: 0.68rem;">Dernière mise à jour : 27/09/2026 14:32</p>
                </div>
            </div>

            <!-- Caisse -->
            <div class="col-12 col-md-6">
                <div class="card-custom h-100">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa-solid fa-cash-register text-muted"></i>
                        <span class="fw-semibold text-muted" style="font-size: 0.8rem;">Caisse <span class="fw-normal">(session actuelle)</span></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div>
                            <p class="text-muted small mb-1" style="font-size: 0.75rem;">Montant en caisse</p>
                            <h5 class="fw-bold mb-2" style="color: #1A202C;">2 850 000 FCFA</h5>
                            <p class="text-muted mb-0" style="font-size: 0.725rem;">Nombre de ventes : <strong class="text-dark">18</strong></p>
                            <p class="text-muted mb-0" style="font-size: 0.725rem;">Ouverture : <strong class="text-dark">08:12</strong></p>
                        </div>
                        <button class="btn btn-purple">
                            Clôturer la caisse
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLES SECTION -->
        <div class="row g-3 mb-4">
            <!-- Produits les plus vendus -->
            <div class="col-12 col-xl-7">
                <div class="card-custom h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-trophy text-warning fs-6"></i>
                            <h6 class="fw-bold mb-0">Produits les plus vendus</h6>
                        </div>
                        <a href="#" class="small text-decoration-none fw-semibold" style="color: var(--purple-main);">Voir tout →</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Produit</th>
                                    <th>Catégorie</th>
                                    <th>Quantité vendue</th>
                                    <th class="text-end">CA (FCFA)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="product-img-placeholder"></div>
                                            <span class="fw-medium">Huile moteur 5W30 (1L)</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">Pièces détachées</td>
                                    <td>42</td>
                                    <td class="text-end fw-semibold">1 995 000</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="product-img-placeholder"></div>
                                            <span class="fw-medium">Plaquettes de frein</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">Pièces détachées</td>
                                    <td>28</td>
                                    <td class="text-end fw-semibold">1 456 000</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="product-img-placeholder"></div>
                                            <span class="fw-medium">Filtre à huile</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">Pièces détachées</td>
                                    <td>25</td>
                                    <td class="text-end fw-semibold">875 000</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="product-img-placeholder"></div>
                                            <span class="fw-medium">Batterie 12V 70Ah</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">Pièces détachées</td>
                                    <td>18</td>
                                    <td class="text-end fw-semibold">2 160 000</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="product-img-placeholder"></div>
                                            <span class="fw-medium">Pneus 185/65 R15</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">Pneus</td>
                                    <td>12</td>
                                    <td class="text-end fw-semibold">1 020 000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Alertes de stock -->
            <div class="col-12 col-xl-5">
                <div class="card-custom h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-danger fs-6"></i>
                            <h6 class="fw-bold mb-0">Alertes de stock</h6>
                        </div>
                        <a href="#" class="small text-decoration-none fw-semibold" style="color: var(--purple-main);">Voir tout →</a>
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
                                <tr>
                                    <td class="fw-medium">Plaquettes de frein</td>
                                    <td class="text-danger fw-bold">3</td>
                                    <td>10</td>
                                    <td><span class="badge badge-rupture rounded-pill">Rupture</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Filtre à air</td>
                                    <td>7</td>
                                    <td>15</td>
                                    <td><span class="badge badge-faible rounded-pill">Faible</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Batterie 12V 70Ah</td>
                                    <td class="text-danger fw-bold">2</td>
                                    <td>5</td>
                                    <td><span class="badge badge-rupture rounded-pill">Rupture</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Amortisseur arrière</td>
                                    <td>8</td>
                                    <td>15</td>
                                    <td><span class="badge badge-faible rounded-pill">Faible</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Balai d'essuie-glace</td>
                                    <td>12</td>
                                    <td>20</td>
                                    <td><span class="badge badge-faible rounded-pill">Faible</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER BANNER -->
        <div class="card-custom d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3">
                <i class="fa-regular fa-lightbulb text-warning fs-5"></i>
                <span class="text-muted small">
                    Pensez à mettre à jour régulièrement le taux de change pour assurer une conversion automatique correcte des devises (NGN → FCFA).
                </span>
            </div>
            <button class="btn btn-purple ms-auto">
                <i class="fa-solid fa-gear me-1"></i> Voir la configuration
            </button>
        </div>

    </main>

    <!-- Ouverture / fermeture du menu latéral (mobile & tablette) -->
    <script>
    (function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle  = document.getElementById('sidebarToggle');
        const close   = document.getElementById('sidebarClose');

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

        // Fermer avec la touche Échap
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeMenu();
        });

        // Si on repasse en grand écran, on réinitialise
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) closeMenu();
        });
    })();
    </script>

</body>
</html>