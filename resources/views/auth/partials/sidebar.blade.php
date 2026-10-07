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

            <!-- ================================= -->
            <!-- TABLEAU DE BORD -->
            <!-- ================================= -->

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <i class="fa-solid fa-border-all"></i>

                <span>Tableau de bord</span>

            </a>


            <!-- ================================= -->
            <!-- CATALOGUE -->
            <!-- ================================= -->

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


            <!-- ================================= -->
            <!-- APPROVISIONNEMENT -->
            <!-- ================================= -->

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

                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-truck"></i>

                        <span>Fournisseurs</span>

                    </a>


                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-cart-shopping"></i>

                        <span>Achats</span>

                    </a>


                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-file-invoice-dollar"></i>

                        <span>Frais annexes</span>

                    </a>


                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-money-bill-transfer"></i>

                        <span>Taux de change</span>

                    </a>

                </div>

            </div>


            <!-- ================================= -->
            <!-- STOCK -->
            <!-- ================================= -->

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

                    <a href="{{ route('stock.index') }}"
                       class="nav-link sidebar-submenu-link
                       {{ request()->routeIs('stock.*') ? 'active' : '' }}">

                        <i class="fa-solid fa-cubes"></i>

                        <span>Stock actuel</span>

                    </a>


                    <a href="{{ route('stock.movements.index') }}"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-arrow-right-arrow-left"></i>

                        <span>Mouvements</span>

                    </a>


                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-triangle-exclamation"></i>

                        <span>Alertes stock faible</span>

                    </a>

                </div>

            </div>


            <!-- ================================= -->
            <!-- VENTES -->
            <!-- ================================= -->

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


                <div class="sidebar-submenu"
                     id="ventes">

                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-plus"></i>

                        <span>Nouvelle vente</span>

                    </a>


                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-list"></i>

                        <span>Liste des ventes</span>

                    </a>


                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-file-lines"></i>

                        <span>Détail d'une vente</span>

                    </a>


                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-rotate-left"></i>

                        <span>Retours</span>

                    </a>

                </div>

            </div>


            <!-- ================================= -->
            <!-- TARIFICATION -->
            <!-- ================================= -->

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

                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-calculator"></i>

                        <span>Prix de revient</span>

                    </a>


                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-tag"></i>

                        <span>Prix de vente</span>

                    </a>


                    <a href="#"
                       class="nav-link sidebar-submenu-link">

                        <i class="fa-solid fa-chart-line"></i>

                        <span>Marges</span>

                    </a>

                </div>

            </div>

        </nav>

    </div>


    <!-- ================================= -->
    <!-- SIDEBAR FOOTER -->
    <!-- ================================= -->

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

/* ========================================= */
/* GROUPES DU MENU */
/* ========================================= */

.sidebar-menu-group {
    width: 100%;
}


/* ========================================= */
/* GRAND MENU */
/* ========================================= */

.sidebar-menu-toggle {
    width: 100%;
    border: 0;
    background: transparent;
    text-align: left;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
}


/*
 * Même espace entre l'icône et le texte
 * que pour Tableau de bord.
 */

.sidebar-menu-content {
    display: flex;
    align-items: center;
    min-width: 0;
}


/*
 * Toutes les icônes des grands menus
 * ont exactement la même largeur.
 *
 * Cela aligne les textes :
 *
 * Tableau de bord
 * Catalogue
 * Approvisionnement
 * Stock
 * Ventes
 * Tarification
 */

.sidebar-menu-content > i:first-child {
    width: 24px;
    min-width: 24px;
    text-align: center;
    margin-right: 10px;
}


/* ========================================= */
/* CHEVRON */
/* ========================================= */

.sidebar-chevron {
    font-size: 0.7rem;
    margin-left: auto;
    transition: transform 0.25s ease;
    flex-shrink: 0;
}


/*
 * Chevron vers le haut lorsque
 * le sous-menu est ouvert.
 */

.sidebar-menu-toggle.open .sidebar-chevron {
    transform: rotate(180deg);
}


/* ========================================= */
/* SOUS-MENUS */
/* ========================================= */

.sidebar-submenu {
    display: none;
    overflow: hidden;
    padding-left: 0.75rem;
}


/*
 * Le sous-menu apparaît uniquement
 * lorsqu'on clique sur son grand menu.
 */

.sidebar-submenu.open {
    display: block;
}


/* ========================================= */
/* LIENS DES SOUS-MENUS */
/* ========================================= */

.sidebar-submenu-link {
    padding-left: 2.5rem !important;
    font-size: 0.9rem;
}


/* Icônes des sous-menus */

.sidebar-submenu-link i {
    font-size: 0.8rem;
}


/* ========================================= */
/* SOUS-MENU ACTIF */
/* ========================================= */

/*
 * SEUL le sous-menu actif devient orange.
 *
 * Le grand menu Catalogue, Stock, etc.
 * reste normal.
 */

.sidebar-submenu-link.active {
    background-color: #ff9800 !important;
    color: #ffffff !important;
}


/*
 * Icône du sous-menu actif en blanc.
 */

.sidebar-submenu-link.active i {
    color: #ffffff !important;
}


/* ========================================= */
/* HOVER DES GRANDS MENUS */
/* ========================================= */

/*
 * Aucun fond orange permanent sur
 * Catalogue / Stock / etc.
 */

.sidebar-menu-toggle:hover {
    text-decoration: none;
}


/* ========================================= */
/* HOVER DES SOUS-MENUS */
/* ========================================= */

.sidebar-submenu-link:hover {
    text-decoration: none;
}

</style>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const menuButtons = document.querySelectorAll('.sidebar-menu-toggle');


    /*
     * Ouvrir automatiquement le bon grand menu
     * lorsqu'une page de ce menu est active.
     */

    document.querySelectorAll('.sidebar-submenu.open').forEach(function (menu) {

        const button = document.querySelector(
            '.sidebar-menu-toggle[data-menu="' + menu.id + '"]'
        );

        if (button) {

            button.classList.add('open');

        }

    });


    /*
     * Gestion des clics sur les grands menus.
     */

    menuButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const menuId = this.getAttribute('data-menu');

            const currentMenu = document.getElementById(menuId);

            const isCurrentlyOpen =
                currentMenu.classList.contains('open');


            /*
             * Fermer tous les sous-menus.
             */

            document.querySelectorAll('.sidebar-submenu').forEach(function (menu) {

                menu.classList.remove('open');

            });


            /*
             * Remettre tous les chevrons
             * dans leur position normale.
             */

            document.querySelectorAll('.sidebar-menu-toggle').forEach(function (menuButton) {

                menuButton.classList.remove('open');

            });


            /*
             * Si le menu cliqué était fermé,
             * on l'ouvre.
             *
             * S'il était déjà ouvert,
             * il reste fermé.
             */

            if (!isCurrentlyOpen) {

                currentMenu.classList.add('open');

                this.classList.add('open');

            }

        });

    });

});

</script>
