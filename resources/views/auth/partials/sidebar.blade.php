<aside class="sidebar d-flex flex-column justify-content-between p-3" id="sidebar">

    <div>

        <!-- =========================================================
             LOGO
        ========================================================== -->

        <div class="sidebar-brand text-center">

            <!-- Bouton fermer sur mobile / tablette -->
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


        <!-- =========================================================
             MENU
        ========================================================== -->

        <nav class="nav flex-column mt-3">


            <!-- =====================================================
                 TABLEAU DE BORD
            ====================================================== -->

            <a href="{{ route('dashboard') }}"
               class="nav-link sidebar-main-link
               {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <span class="sidebar-menu-content">

                    <i class="fa-solid fa-border-all"></i>

                    <span>Tableau de bord</span>

                </span>

            </a>



            <!-- =====================================================
                 CATALOGUE
            ====================================================== -->

            <div class="sidebar-menu-group">

                <button type="button"
                        class="nav-link sidebar-menu-toggle"
                        data-menu="catalogue">

                    <span class="sidebar-menu-content">

                        <i class="fa-solid fa-box"></i>

                        <span>Catalogue</span>

                    </span>

                    <i class="fa-solid fa-chevron-down sidebar-chevron"></i>

                </button>


                <div class="sidebar-submenu
                    {{ request()->routeIs('products.*') ? 'open' : '' }}"
                     id="catalogue">


                    <!-- Produits -->

                    <a href="{{ route('products.index') }}"
                       class="nav-link sidebar-submenu-link
                       {{ request()->routeIs('products.*') ? 'active' : '' }}">

                        <i class="fa-solid fa-box"></i>

                        <span>Produits</span>

                    </a>


                    <!-- Véhicules -->

                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-car"></i>

                        <span>Véhicules</span>

                    </a>


                    <!-- Pièces -->

                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-gears"></i>

                        <span>Pièces</span>

                    </a>

                </div>

            </div>



            <!-- =====================================================
                 APPROVISIONNEMENT
            ====================================================== -->

            <div class="sidebar-menu-group">

                <button type="button"
                        class="nav-link sidebar-menu-toggle"
                        data-menu="approvisionnement">

                    <span class="sidebar-menu-content">

                        <i class="fa-solid fa-cart-shopping"></i>

                        <span>Approvisionnement</span>

                    </span>

                    <i class="fa-solid fa-chevron-down sidebar-chevron"></i>

                </button>


                <div class="sidebar-submenu"
                     id="approvisionnement">


                    <!-- Fournisseurs -->

                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-truck"></i>

                        <span>Fournisseurs</span>

                    </a>


                    <!-- Achats -->

                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-cart-shopping"></i>

                        <span>Achats</span>

                    </a>


                    <!-- Frais annexes -->

                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-file-invoice-dollar"></i>

                        <span>Frais annexes</span>

                    </a>


                    <!-- Taux de change -->

                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-money-bill-transfer"></i>

                        <span>Taux de change</span>

                    </a>

                </div>

            </div>



            <!-- =====================================================
                 STOCK
            ====================================================== -->

            <div class="sidebar-menu-group">

                <button type="button"
                        class="nav-link sidebar-menu-toggle"
                        data-menu="stock">

                    <span class="sidebar-menu-content">

                        <i class="fa-solid fa-cubes"></i>

                        <span>Stock</span>

                    </span>

                    <i class="fa-solid fa-chevron-down sidebar-chevron"></i>

                </button>


                <div class="sidebar-submenu
                    {{ request()->routeIs('stock.*') ? 'open' : '' }}"
                     id="stock">


                    <!-- Stock actuel -->

                    <a href="{{ route('stock.index') }}"
                       class="nav-link sidebar-submenu-link
                       {{ request()->routeIs('stock.index') ? 'active' : '' }}">

                        <i class="fa-solid fa-cubes"></i>

                        <span>Stock actuel</span>

                    </a>


                    <!-- Mouvements -->

                    <a href="{{ route('stock.movements.index') }}"
                       class="nav-link sidebar-submenu-link
                       {{ request()->routeIs('stock.movements.*') ? 'active' : '' }}">

                        <i class="fa-solid fa-arrow-right-arrow-left"></i>

                        <span>Mouvements</span>

                    </a>


                    <!-- Alertes stock faible -->

                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-triangle-exclamation"></i>

                        <span>Alertes stock faible</span>

                    </a>

                </div>

            </div>


<!-- =====================================================
     VENTES
====================================================== -->

<div class="sidebar-menu-group">

    <button type="button"
            class="nav-link sidebar-menu-toggle"
            data-menu="ventes">

        <span class="sidebar-menu-content">

            <i class="fa-solid fa-file-invoice-dollar"></i>

            <span>Ventes</span>

        </span>

        <i class="fa-solid fa-chevron-down sidebar-chevron"></i>

    </button>


    <div class="sidebar-submenu
        {{ request()->routeIs('sales.*') ? 'open' : '' }}"
         id="ventes">


        <!-- Nouvelle vente -->

        <a href="{{ route('sales.create') }}"
           class="nav-link sidebar-submenu-link
           {{ request()->routeIs('sales.create') ? 'active' : '' }}">

            <i class="fa-solid fa-plus"></i>

            <span>Nouvelle vente</span>

        </a>


        <!-- Liste des ventes -->

        <a href="{{ route('sales.index') }}"
           class="nav-link sidebar-submenu-link
           {{ request()->routeIs('sales.index') ? 'active' : '' }}">

            <i class="fa-solid fa-list"></i>

            <span>Liste des ventes</span>

        </a>


        <!-- Détail d'une vente -->

        <a href="{{ $sale ?? '#' }}"
           class="nav-link sidebar-submenu-link
           {{ request()->routeIs('sales.show') ? 'active' : '' }}">

            <i class="fa-solid fa-file-lines"></i>

            <span>Détail d'une vente</span>

        </a>


        <!-- Retours -->

        <a href="{{ route('sales.returns.index') }}"
           class="nav-link sidebar-submenu-link
           {{ request()->routeIs('sales.returns.*') ? 'active' : '' }}">

            <i class="fa-solid fa-rotate-left"></i>

            <span>Retours</span>

        </a>

    </div>

</div>


            <!-- =====================================================
                 TARIFICATION
            ====================================================== -->

            <div class="sidebar-menu-group">

                <button type="button"
                        class="nav-link sidebar-menu-toggle"
                        data-menu="tarification">

                    <span class="sidebar-menu-content">

                        <i class="fa-solid fa-tags"></i>

                        <span>Tarification</span>

                    </span>

                    <i class="fa-solid fa-chevron-down sidebar-chevron"></i>

                </button>


                <div class="sidebar-submenu"
                     id="tarification">


                    <!-- Prix de revient -->

                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-calculator"></i>

                        <span>Prix de revient</span>

                    </a>


                    <!-- Prix de vente -->

                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-tag"></i>

                        <span>Prix de vente</span>

                    </a>


                    <!-- Marges -->

                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-chart-line"></i>

                        <span>Marges</span>

                    </a>

                </div>

            </div>

        </nav>

    </div>



    <!-- =============================================================
         FOOTER SIDEBAR
    ============================================================== -->

    <div class="text-center text-white-50 pt-3 border-top border-white border-opacity-10 mt-3">

        <i class="fa-solid fa-car fs-5 mb-1 text-white-50"></i>

        <p class="small mb-0 fw-semibold text-white"
           style="font-size: 0.8rem;">

            INTERCAR

        </p>

        <p class="text-white-50 mb-2"
           style="font-size: 0.68rem;">

            Véhicules & pièces détachées

        </p>

        <span class="badge bg-white bg-opacity-10 text-white-50 font-normal"
              style="font-size: 0.65rem;">

            Version 1.0

        </span>

    </div>

</aside>



<style>

/* =========================================================
   GROUPES DU MENU
========================================================= */

.sidebar-menu-group {
    width: 100%;
}


/* =========================================================
   LIENS PRINCIPAUX
   Tableau de bord
========================================================= */

.sidebar-main-link {
    width: 100%;
    border-radius: 8px;
    margin-bottom: 4px;
    color: #ffffff !important;
    background-color: transparent;
    transition: background-color 0.2s ease;
}


/* =========================================================
   CONTENU DES MENUS
========================================================= */

.sidebar-menu-content {
    display: flex;
    align-items: center;
    min-width: 0;
}


/* =========================================================
   LARGEUR DES ICONES
========================================================= */

.sidebar-menu-content > i:first-child,
.sidebar-main-link > i:first-child {
    width: 24px;
    min-width: 24px;
    text-align: center;
    margin-right: 10px;
}


/* =========================================================
   TABLEAU DE BORD ACTIF
========================================================= */

.sidebar-main-link.active {
    background-color: #ff9800 !important;
    color: #ffffff !important;
}


/* =========================================================
   GRAND MENU
========================================================= */

.sidebar-menu-toggle {

    width: 100%;

    border: 0;

    background: transparent;

    color: #ffffff !important;

    text-align: left;

    display: flex;

    align-items: center;

    justify-content: space-between;

    cursor: pointer;

    border-radius: 8px;

    margin-bottom: 4px;

    padding: 0.5rem 1rem;

    transition: background-color 0.2s ease;

}


/* Aucun orange lorsque le grand menu est ouvert */

.sidebar-menu-toggle.open {
    background-color: transparent !important;
    color: #ffffff !important;
}


/* Hover des grands menus */

.sidebar-menu-toggle:hover {
    background-color: rgba(255, 152, 0, 0.12);
    color: #ffffff !important;
}


/* =========================================================
   CHEVRON
========================================================= */

.sidebar-chevron {

    font-size: 0.7rem;

    margin-left: auto;

    transition: transform 0.25s ease;

    flex-shrink: 0;

}


/* Chevron vers le haut */

.sidebar-menu-toggle.open .sidebar-chevron {
    transform: rotate(180deg);
}


/* =========================================================
   SOUS-MENUS
========================================================= */

.sidebar-submenu {

    display: none;

    overflow: hidden;

    padding-left: 0.75rem;

}


.sidebar-submenu.open {
    display: block;
}


/* =========================================================
   LIENS DES SOUS-MENUS
========================================================= */

.sidebar-submenu-link {

    width: 100%;

    padding-left: 2.5rem !important;

    padding-top: 0.5rem;

    padding-bottom: 0.5rem;

    font-size: 0.9rem;

    color: #ffffff !important;

    border-radius: 8px;

    margin-bottom: 3px;

    transition: background-color 0.2s ease;

}


/* =========================================================
   ICONES DES SOUS-MENUS
========================================================= */

.sidebar-submenu-link i {

    font-size: 0.8rem;

    margin-right: 8px;

}


/* =========================================================
   SOUS-MENU ACTIF
   MÊME COULEUR QUE TABLEAU DE BORD
========================================================= */

.sidebar-submenu-link.active {

    background-color: #ff9800 !important;

    color: #ffffff !important;

}


/* Icone du sous-menu actif */

.sidebar-submenu-link.active i {

    color: #ffffff !important;

}


/* =========================================================
   HOVER SOUS-MENU
========================================================= */

.sidebar-submenu-link:hover {

    background-color: rgba(255, 152, 0, 0.12);

    color: #ffffff !important;

    text-decoration: none;

}


/* =========================================================
   LE LIEN ACTIF DOIT RESTER ORANGE MÊME AU HOVER
========================================================= */

.sidebar-submenu-link.active:hover {

    background-color: #ff9800 !important;

    color: #ffffff !important;

}

</style>



<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       RÉCUPÉRER TOUS LES GRANDS MENUS
    ========================================================== */

    const menuButtons = document.querySelectorAll(
        '.sidebar-menu-toggle'
    );


    /* =========================================================
       OUVRIR AUTOMATIQUEMENT LE MENU ACTIF
    ========================================================== */

    document.querySelectorAll(
        '.sidebar-submenu.open'
    ).forEach(function (menu) {

        const button = document.querySelector(
            '.sidebar-menu-toggle[data-menu="' +
            menu.id +
            '"]'
        );

        if (button) {

            button.classList.add('open');

        }

    });


    /* =========================================================
       CLIQUE SUR UN GRAND MENU
    ========================================================== */

    menuButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const menuId = this.getAttribute(
                'data-menu'
            );

            const currentMenu = document.getElementById(
                menuId
            );


            if (!currentMenu) {
                return;
            }


            const isCurrentlyOpen =
                currentMenu.classList.contains('open');


            /* =================================================
               FERMER TOUS LES SOUS-MENUS
            ================================================== */

            document.querySelectorAll(
                '.sidebar-submenu'
            ).forEach(function (menu) {

                menu.classList.remove('open');

            });


            /* =================================================
               REMETTRE TOUS LES CHEVRONS À L'ÉTAT NORMAL
            ================================================== */

            document.querySelectorAll(
                '.sidebar-menu-toggle'
            ).forEach(function (menuButton) {

                menuButton.classList.remove('open');

            });


            /* =================================================
               OUVRIR LE MENU CLIQUÉ
            ================================================== */

            if (!isCurrentlyOpen) {

                currentMenu.classList.add('open');

                this.classList.add('open');

            }

        });

    });

});

</script>