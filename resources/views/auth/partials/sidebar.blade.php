<aside class="sidebar d-flex flex-column justify-content-between p-3" id="sidebar">

    <div>

        <!-- Logo Header -->
        <div class="sidebar-brand text-center">

            <!-- Bouton fermer (mobile / tablette) -->
            <button type="button"
                    class="btn btn-sm text-white-50 d-lg-none position-absolute top-0 end-0 m-2"
                    id="sidebarClose"
                    aria-label="Fermer le menu">
                <i class="fa-solid fa-xmark fs-5"></i>
            </button>

            <img src="{{ asset('images/logo-intercar.png') }}"
                 alt="INTERCAR"
                 class="img-fluid"
                 style="max-height: 48px;"
                 onerror="this.src='https://via.placeholder.com/180x45/30173D/FFFFFF?text=INTERCAR'">

        </div>

        <!-- Menu -->
        <nav class="nav flex-column mt-3">

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i>
                <span>Tableau de bord</span>
            </a>

            <a href="{{ route('products.index') }}"
               class="nav-link">
                <i class="fa-solid fa-box"></i>
                <span>Produits</span>
            </a>

            <a href="#"
               class="nav-link">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Achats & prix de revient</span>
            </a>

            <a href="{{ route('stock.index') }}"
               class="nav-link">
                <i class="fa-solid fa-cubes"></i>
                <span>Stock</span>
            </a>

            <a href="#"
               class="nav-link">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <span>Ventes & facturation</span>
            </a>

            <a href="#"
               class="nav-link">
                <i class="fa-solid fa-cash-register"></i>
                <span>Caisse</span>
            </a>

            <a href="#"
               class="nav-link">
                <i class="fa-solid fa-users"></i>
                <span>Clients</span>
            </a>

            <a href="#"
               class="nav-link">
                <i class="fa-solid fa-truck"></i>
                <span>Fournisseurs</span>
            </a>

            <a href="#"
               class="nav-link">
                <i class="fa-solid fa-user-gear"></i>
                <span>Utilisateurs & rôles</span>
            </a>

            <a href="#"
               class="nav-link">
                <i class="fa-solid fa-chart-line"></i>
                <span>Rapports</span>
            </a>

            <a href="#"
               class="nav-link">
                <i class="fa-solid fa-gear"></i>
                <span>Configuration</span>
            </a>

        </nav>

    </div>

    <!-- Sidebar Footer -->
    <div class="text-center text-white-50 pt-3 border-top border-white border-opacity-10 mt-3">

        <i class="fa-solid fa-car fs-5 mb-1 text-white-50"></i>

        <p class="small mb-0 fw-semibold text-white" style="font-size: 0.8rem;">
            INTERCAR
        </p>

        <p class="text-white-50 mb-2" style="font-size: 0.68rem;">
            Véhicules & pièces détachées
        </p>

        <span class="badge bg-white bg-opacity-10 text-white-50 font-normal"
              style="font-size: 0.65rem;">
            Version 1.0
        </span>

    </div>

</aside>

<!-- Fond sombre derrière le menu mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>