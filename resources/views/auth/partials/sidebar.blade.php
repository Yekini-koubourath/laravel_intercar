<aside class="sidebar d-flex flex-column justify-content-between p-3" id="sidebar">

    <div class="sidebar-top">

        <!-- =========================================================
             EN-TÊTE : bouton agrandir (tablette/mobile) + LOGO
        ========================================================== -->
        <div class="sidebar-header">

            <!-- Bouton pour agrandir / réduire (visible seulement < lg) -->
            <button type="button"
                    class="sidebar-toggle-btn d-lg-none"
                    id="sidebarToggle"
                    aria-label="Agrandir ou réduire le menu"
                    aria-expanded="false">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="sidebar-brand">

                <!-- ⬇️⬇️ LOGO INTERCAR (version complète) : desktop + menu agrandi ⬇️⬇️ -->
                <img src="{{ asset('images/logo-intercar.jpeg') }}"
                     alt="INTERCAR"
                     class="brand-logo-full"
                     onerror="this.src='https://via.placeholder.com/180x45/F3E8FF/6B21A8?text=INTERCAR'">

                <!-- ⬇️⬇️ LOGO INTERCAR (version carrée / icône) : barre réduite tablette-mobile ⬇️⬇️
                     Si tu n'as pas encore de version carrée, ça reprend automatiquement le logo normal -->
                <img src="{{ asset('images/logo-intercar.jpeg') }}"
                     alt="INTERCAR"
                     class="brand-logo-mini"
                     onerror="this.onerror=null; this.src='{{ asset('images/logo-intercar.png') }}'">

            </div>

        </div>


        <!-- =========================================================
             MENU
        ========================================================== -->
        <nav class="nav flex-column mt-3 sidebar-nav">

            <!-- TABLEAU DE BORD -->
            <a href="{{ route('dashboard') }}"
               title="Tableau de bord"
               class="nav-link sidebar-main-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="sidebar-menu-content">
                    <i class="fa-solid fa-border-all"></i>
                    <span class="sidebar-label">Tableau de bord</span>
                </span>
            </a>

              <!-- STOCK -->
            <div class="sidebar-menu-group">
                <button type="button" class="nav-link sidebar-menu-toggle" data-menu="stock" aria-expanded="false">
                    <span class="sidebar-menu-content">
                        <i class="fa-solid fa-cubes"></i>
                        <span class="sidebar-label">Stock</span>
                    </span>
                    <i class="fa-solid fa-chevron-down sidebar-chevron"></i>
                </button>

                <div class="sidebar-submenu {{ request()->routeIs('stock.*') ? 'open' : '' }}" id="stock">
                    <div class="sidebar-submenu-title">Stock</div>


                    <a href="{{ route('products.index') }}"
                       class="nav-link sidebar-submenu-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-box"></i>
                        <span>Produits</span>
                    </a>

                    <a href="{{ route('stock.index') }}"
                       class="nav-link sidebar-submenu-link {{ request()->routeIs('stock.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-cubes"></i>
                        <span>Stock actuel</span>
                    </a>

                    <a href="{{ route('stock.movements.index') }}"
                       class="nav-link sidebar-submenu-link {{ request()->routeIs('stock.movements.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        <span>Mouvements de stock</span>
                    </a>

                    <a href="#" class="nav-link sidebar-submenu-link">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Alertes stock faible</span>
                    </a>
                </div>
            </div>


            <!-- CATALOGUE -->
            <div class="sidebar-menu-group">
                <button type="button" class="nav-link sidebar-menu-toggle" data-menu="catalogue" aria-expanded="false">
                    <span class="sidebar-menu-content">
                        <i class="fa-solid fa-box"></i>
                        <span class="sidebar-label">Catalogue</span>
                    </span>
                    <i class="fa-solid fa-chevron-down sidebar-chevron"></i>
                </button>

                <div class="sidebar-submenu {{ request()->routeIs('products.*') ? 'open' : '' }}" id="catalogue">
                    <div class="sidebar-submenu-title">Catalogue</div>


                    <a href="#" class="nav-link sidebar-submenu-link">
                        <i class="fa-solid fa-car"></i>
                        <span>Véhicules</span>
                    </a>

                    <a href="#" class="nav-link sidebar-submenu-link">
                        <i class="fa-solid fa-gears"></i>
                        <span>Pièces</span>
                    </a>
                </div>
            </div>


            <!-- APPROVISIONNEMENT -->
            <div class="sidebar-menu-group">
                <button type="button" class="nav-link sidebar-menu-toggle" data-menu="approvisionnement" aria-expanded="false">
                    <span class="sidebar-menu-content">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="sidebar-label">Approvisionnement</span>
                    </span>
                    <i class="fa-solid fa-chevron-down sidebar-chevron"></i>
                </button>

                <div class="sidebar-submenu" id="approvisionnement">
                    <div class="sidebar-submenu-title">Approvisionnement</div>

                    <a href="#" class="nav-link sidebar-submenu-link">
                        <i class="fa-solid fa-truck"></i>
                        <span>Fournisseurs</span>
                    </a>

                    <a href="#" class="nav-link sidebar-submenu-link">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Achats</span>
                    </a>

                    <a href="#" class="nav-link sidebar-submenu-link">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span>Frais annexes</span>
                    </a>

                    <a href="#" class="nav-link sidebar-submenu-link">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                        <span>Taux de change</span>
                    </a>
                </div>
            </div>


            <!-- VENTES -->
            <div class="sidebar-menu-group">
                <button type="button" class="nav-link sidebar-menu-toggle" data-menu="ventes" aria-expanded="false">
                    <span class="sidebar-menu-content">
                        <i class="fa-solid fa-file-invoice-dollar"></i>
                        <span class="sidebar-label">Ventes</span>
                    </span>
                    <i class="fa-solid fa-chevron-down sidebar-chevron"></i>
                </button>

                <div class="sidebar-submenu {{ request()->routeIs('sales.*') ? 'open' : '' }}" id="ventes">
                    <div class="sidebar-submenu-title">Ventes</div>

                    <a href="{{ route('sales.create') }}"
                       class="nav-link sidebar-submenu-link {{ request()->routeIs('sales.create') ? 'active' : '' }}">
                        <i class="fa-solid fa-plus"></i>
                        <span>Nouvelle vente</span>
                    </a>

                    <a href="{{ route('sales.index') }}"
                       class="nav-link sidebar-submenu-link {{ request()->routeIs('sales.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-list"></i>
                        <span>Liste des ventes</span>
                    </a>

                    <a href="{{ $sale ?? '#' }}"
                       class="nav-link sidebar-submenu-link {{ request()->routeIs('sales.show') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-lines"></i>
                        <span>Détail d'une vente</span>
                    </a>

                    <a href="{{ route('sales.returns.index') }}"
                       class="nav-link sidebar-submenu-link {{ request()->routeIs('sales.returns.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Retours</span>
                    </a>
                </div>
            </div>


            <!-- TARIFICATION -->
            <div class="sidebar-menu-group">
                <button type="button" class="nav-link sidebar-menu-toggle" data-menu="tarification" aria-expanded="false">
                    <span class="sidebar-menu-content">
                        <i class="fa-solid fa-tags"></i>
                        <span class="sidebar-label">Tarification</span>
                    </span>
                    <i class="fa-solid fa-chevron-down sidebar-chevron"></i>
                </button>

                <div class="sidebar-submenu" id="tarification">
                    <div class="sidebar-submenu-title">Tarification</div>

                    <a href="#" class="nav-link sidebar-submenu-link">
                        <i class="fa-solid fa-calculator"></i>
                        <span>Prix de revient</span>
                    </a>

                    <a href="#" class="nav-link sidebar-submenu-link">
                        <i class="fa-solid fa-tag"></i>
                        <span>Prix de vente</span>
                    </a>

                    <a href="#" class="nav-link sidebar-submenu-link">
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
    <div class="sidebar-footer text-center pt-3 mt-3">

        <!-- ⬇️⬇️ LOGO INTERCAR ICI : il remplace l'ancien texte "INTERCAR" et l'icône voiture ⬇️⬇️ -->
        <img src="{{ asset('images/logo-intercar.png') }}"
             alt="INTERCAR"
             class="sidebar-footer-logo"
             onerror="this.src='https://via.placeholder.com/140x40/F3E8FF/6B21A8?text=INTERCAR'">

        <p class="sidebar-footer-subtitle mb-2">Véhicules &amp; pièces détachées</p>

        <span class="sidebar-footer-badge">Version 1.0</span>

    </div>

</aside>

<!-- Fond sombre quand le menu est agrandi (tablette / mobile) -->
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>



<style>

:root {
    --sb-rail-width: 72px;
    --sb-expanded-width: 272px;
}

/* =========================================================
   BASE (GRANDS ÉCRANS) : fond #F3E8FF / icônes #6B21A8
========================================================= */

#sidebar.sidebar {
    --sb-bg: #F3E8FF;
    --sb-icon: #6B21A8;
    --sb-text: #3B0764;
    --sb-hover: rgba(107, 33, 168, 0.10);
    --sb-line: rgba(107, 33, 168, 0.18);
    --sb-accent: #ff9800;

    background-color: var(--sb-bg) !important;
    color: var(--sb-text);
}

#sidebar .sidebar-top {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    min-height: 0;
}

#sidebar .sidebar-nav {
    flex: 1 1 auto;
    min-height: 0;
    overflow-y: auto;
    overflow-x: hidden;
    flex-wrap: nowrap;
    scrollbar-width: thin;
    scrollbar-color: rgba(107, 33, 168, 0.3) transparent;
}

/* ---------- En-tête / logo ---------- */

#sidebar .sidebar-header {
    display: flex;
    align-items: center;
    justify-content: center;
}

#sidebar .sidebar-brand {
    display: flex;
    align-items: center;
    justify-content: center;
}

#sidebar .brand-logo-full {
    max-height: 48px;
    max-width: 100%;
    object-fit: contain;
}

#sidebar .brand-logo-mini {
    display: none;
}

#sidebar .sidebar-toggle-btn {
    display: none;
}

/* ---------- Liens principaux et grands menus ---------- */

#sidebar .sidebar-main-link,
#sidebar .sidebar-menu-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    min-height: 44px;
    padding: 0.55rem 1rem;
    margin-bottom: 4px;
    border: 0;
    border-radius: 10px;
    background: transparent;
    color: var(--sb-text) !important;
    text-align: left;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.2s ease, color 0.2s ease;
}

#sidebar .sidebar-menu-group {
    width: 100%;
}

#sidebar .sidebar-menu-content {
    display: flex;
    align-items: center;
    min-width: 0;
}

#sidebar .sidebar-menu-content > i {
    width: 24px;
    min-width: 24px;
    margin-right: 10px;
    text-align: center;
    font-size: 1.05rem;
    color: var(--sb-icon) !important;
    transition: color 0.2s ease;
}

#sidebar .sidebar-label {
    white-space: nowrap;
}

#sidebar .sidebar-main-link:hover,
#sidebar .sidebar-menu-toggle:hover {
    background-color: var(--sb-hover);
}

/* Tableau de bord actif */
#sidebar .sidebar-main-link.active {
    background-color: var(--sb-accent) !important;
    color: #ffffff !important;
}

#sidebar .sidebar-main-link.active .sidebar-menu-content > i {
    color: #ffffff !important;
}

/* Pas d'orange quand un grand menu est ouvert */
#sidebar .sidebar-menu-toggle.open {
    background-color: transparent;
}

#sidebar .sidebar-menu-toggle.open:hover {
    background-color: var(--sb-hover);
}

/* ---------- Chevron ---------- */

#sidebar .sidebar-chevron {
    margin-left: auto;
    flex-shrink: 0;
    font-size: 0.7rem;
    color: var(--sb-icon);
    transition: transform 0.25s ease;
}

#sidebar .sidebar-menu-toggle.open .sidebar-chevron {
    transform: rotate(180deg);
}

/* ---------- Sous-menus (accordéon) ---------- */

#sidebar .sidebar-submenu {
    display: none;
    overflow: hidden;
    padding-left: 0.75rem;
}

#sidebar .sidebar-submenu.open {
    display: block;
    animation: sbSlideDown 0.22s ease-out;
}

#sidebar .sidebar-submenu-title {
    display: none;
}

#sidebar .sidebar-submenu-link {
    display: flex;
    align-items: center;
    width: 100%;
    padding: 0.5rem 1rem 0.5rem 2.5rem !important;
    margin-bottom: 3px;
    border-radius: 10px;
    font-size: 0.9rem;
    color: var(--sb-text) !important;
    text-decoration: none;
    transition: background-color 0.2s ease, color 0.2s ease;
}

#sidebar .sidebar-submenu-link i {
    margin-right: 8px;
    font-size: 0.8rem;
    color: var(--sb-icon);
}

#sidebar .sidebar-submenu-link:hover {
    background-color: var(--sb-hover);
}

#sidebar .sidebar-submenu-link.active,
#sidebar .sidebar-submenu-link.active:hover {
    background-color: var(--sb-accent) !important;
    color: #ffffff !important;
}

#sidebar .sidebar-submenu-link.active i {
    color: #ffffff !important;
}

/* ---------- Footer ---------- */

#sidebar .sidebar-footer {
    border-top: 1px solid var(--sb-line);
}

#sidebar .sidebar-footer-logo {
    max-height: 38px;
    max-width: 100%;
    object-fit: contain;
    margin-bottom: 6px;
}

#sidebar .sidebar-footer-subtitle {
    font-size: 0.68rem;
    color: var(--sb-icon);
    opacity: 0.8;
}

#sidebar .sidebar-footer-badge {
    display: inline-block;
    padding: 0.25rem 0.6rem;
    border-radius: 999px;
    background: rgba(107, 33, 168, 0.12);
    color: var(--sb-icon);
    font-size: 0.65rem;
}

/* Backdrop caché sur grand écran */
.sidebar-backdrop {
    display: none;
}

@keyframes sbSlideDown {
    from { opacity: 0; transform: translateY(-4px); }
    to   { opacity: 1; transform: translateY(0); }
}

@keyframes sbFlyoutIn {
    from { opacity: 0; transform: translateX(-8px); }
    to   { opacity: 1; transform: translateX(0); }
}


/* =========================================================
   TABLETTES → TÉLÉPHONES (< 992px)
   Barre d'icônes, fond #6B21A8, icônes blanches
========================================================= */

@media (max-width: 991.98px) {

    #sidebar.sidebar {
        --sb-bg: #6B21A8;
        --sb-icon: #ffffff;
        --sb-text: #ffffff;
        --sb-hover: rgba(255, 255, 255, 0.14);
        --sb-line: rgba(255, 255, 255, 0.18);

        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        bottom: 0 !important;
        transform: none !important;
        visibility: visible !important;

        height: 100vh;
        height: 100dvh;
        width: var(--sb-rail-width) !important;
        min-width: 0;
        max-width: none;
        padding: 12px 10px !important;
        overflow: hidden;
        z-index: 1040;

        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                    box-shadow 0.3s ease;
    }

    /* ----- Menu agrandi ----- */
    #sidebar.sidebar.is-expanded {
        width: min(var(--sb-expanded-width), 86vw) !important;
        box-shadow: 8px 0 32px rgba(0, 0, 0, 0.3);
    }

    .sidebar-backdrop {
        display: block;
        position: fixed;
        inset: 0;
        background: rgba(30, 6, 50, 0.5);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        z-index: 1035;
    }

    .sidebar-backdrop.show {
        opacity: 1;
        pointer-events: auto;
    }

    /* ----- En-tête ----- */
    #sidebar .sidebar-header {
        flex-direction: column;
        gap: 10px;
        justify-content: flex-start;
    }

    #sidebar.is-expanded .sidebar-header {
        flex-direction: row;
        gap: 8px;
    }

    #sidebar .sidebar-toggle-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 52px;
        height: 44px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: #ffffff;
        font-size: 1.2rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    #sidebar .sidebar-toggle-btn:hover {
        background-color: var(--sb-hover);
    }

    /* Logo : mini dans la barre réduite, complet quand agrandi */
    #sidebar:not(.is-expanded) .brand-logo-full {
        display: none;
    }

    #sidebar:not(.is-expanded) .brand-logo-mini {
        display: block;
        width: 40px;
        height: 40px;
        object-fit: contain;
    }

    #sidebar.is-expanded .brand-logo-full {
        max-height: 40px;
        max-width: 150px;
    }

    /* Le logo doit rester lisible sur fond violet */
    #sidebar .brand-logo-full,
    #sidebar .brand-logo-mini {
        background: #ffffff;
        border-radius: 10px;
        padding: 4px;
    }

    /* ----- Liens : l'icône reste au même endroit réduit ou agrandi ----- */
    #sidebar .sidebar-main-link,
    #sidebar .sidebar-menu-toggle {
        padding: 0.55rem 0 0.55rem 14px;
        justify-content: flex-start;
    }

    #sidebar .sidebar-menu-content {
        width: 100%;
    }

    #sidebar .sidebar-chevron {
        margin-right: 12px;
    }

    /* ----- Barre réduite : seulement les icônes ----- */
    #sidebar:not(.is-expanded) .sidebar-label {
        width: 0;
        opacity: 0;
        overflow: hidden;
    }

    #sidebar:not(.is-expanded) .sidebar-menu-content > i {
        margin-right: 0;
    }

    #sidebar:not(.is-expanded) .sidebar-chevron,
    #sidebar:not(.is-expanded) .sidebar-footer {
        display: none;
    }

    #sidebar.is-expanded .sidebar-label {
        opacity: 1;
        transition: opacity 0.25s ease 0.1s;
    }

    /* Groupe contenant la page active (barre réduite) */
    #sidebar:not(.is-expanded) .sidebar-menu-toggle.has-active,
    #sidebar:not(.is-expanded) .sidebar-menu-toggle.flyout-open {
        background-color: rgba(255, 255, 255, 0.18);
    }

    #sidebar:not(.is-expanded) .sidebar-menu-toggle.has-active {
        position: relative;
    }

    #sidebar:not(.is-expanded) .sidebar-menu-toggle.has-active::before {
        content: "";
        position: absolute;
        left: 0;
        top: 12px;
        bottom: 12px;
        width: 3px;
        border-radius: 3px;
        background: var(--sb-accent);
    }

    /* =====================================================
       PANNEAU FLOTTANT DES SOUS-MENUS (barre réduite)
    ====================================================== */

    #sidebar:not(.is-expanded) .sidebar-submenu {
        display: none !important;
    }

    #sidebar:not(.is-expanded) .sidebar-submenu.flyout-open {
        display: block !important;
        position: fixed;
        left: calc(var(--sb-rail-width) + 8px);
        top: 12px;
        min-width: 230px;
        padding: 8px;
        overflow: visible;
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 14px 36px rgba(59, 7, 100, 0.35);
        z-index: 1050;
        animation: sbFlyoutIn 0.18s ease-out;
    }

    /* Pont invisible pour ne pas perdre le survol */
    #sidebar:not(.is-expanded) .sidebar-submenu.flyout-open::before {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: -16px;
        width: 16px;
    }

    #sidebar:not(.is-expanded) .sidebar-submenu-title {
        display: block;
        padding: 6px 12px 8px;
        margin-bottom: 6px;
        border-bottom: 1px solid #F3E8FF;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #6B21A8;
    }

    #sidebar:not(.is-expanded) .sidebar-submenu-link {
        padding: 0.55rem 0.75rem !important;
        white-space: nowrap;
        color: #3B0764 !important;
    }

    #sidebar:not(.is-expanded) .sidebar-submenu-link i {
        width: 20px;
        text-align: center;
        color: #6B21A8;
    }

    #sidebar:not(.is-expanded) .sidebar-submenu-link:hover {
        background-color: #F3E8FF;
    }

    #sidebar:not(.is-expanded) .sidebar-submenu-link.active,
    #sidebar:not(.is-expanded) .sidebar-submenu-link.active:hover {
        background-color: #ff9800 !important;
        color: #ffffff !important;
    }

    #sidebar:not(.is-expanded) .sidebar-submenu-link.active i {
        color: #ffffff;
    }
}

@media (prefers-reduced-motion: reduce) {
    #sidebar, #sidebar * , .sidebar-backdrop {
        transition: none !important;
        animation: none !important;
    }
}

</style>



<script>

document.addEventListener('DOMContentLoaded', function () {

    const sidebar   = document.getElementById('sidebar');
    if (!sidebar) return;

    const backdrop  = document.getElementById('sidebarBackdrop');
    const toggleBtn = document.getElementById('sidebarToggle');
    const nav       = sidebar.querySelector('.sidebar-nav');
    const buttons   = sidebar.querySelectorAll('.sidebar-menu-toggle');
    const groups    = sidebar.querySelectorAll('.sidebar-menu-group');

    const compactMq = window.matchMedia('(max-width: 991.98px)');
    const hoverMq   = window.matchMedia('(hover: hover) and (pointer: fine)');

    let closeTimer = null;

    const isCompact  = () => compactMq.matches;
    const isRail     = () => isCompact() && !sidebar.classList.contains('is-expanded');
    const getMenu    = (btn) => document.getElementById(btn.dataset.menu);


    /* ---------- État initial ---------- */

    buttons.forEach(function (btn) {
        const menu = getMenu(btn);
        if (!menu) return;

        // Groupe contenant la page active
        if (menu.querySelector('.sidebar-submenu-link.active')) {
            btn.classList.add('has-active');
        }

        // Ouverture automatique du menu actif (mode accordéon)
        if (menu.classList.contains('open')) {
            btn.classList.add('open');
            btn.setAttribute('aria-expanded', 'true');
        }
    });


    /* ---------- Panneau flottant (barre réduite) ---------- */

    function closeFlyouts() {
        sidebar.querySelectorAll('.sidebar-submenu.flyout-open').forEach(function (m) {
            m.classList.remove('flyout-open');
        });
        buttons.forEach(function (b) {
            if (b.classList.contains('flyout-open')) {
                b.classList.remove('flyout-open');
                b.setAttribute('aria-expanded', 'false');
            }
        });
    }

    function openFlyout(btn) {
        const menu = getMenu(btn);
        if (!menu) return;

        closeFlyouts();

        menu.classList.add('flyout-open');
        btn.classList.add('flyout-open');
        btn.setAttribute('aria-expanded', 'true');

        // Position verticale alignée sur l'icône, sans dépasser l'écran
        const rect = btn.getBoundingClientRect();
        const h    = menu.offsetHeight;
        let top    = rect.top - 6;

        top = Math.min(top, window.innerHeight - h - 8);
        top = Math.max(top, 8);

        menu.style.top = top + 'px';
    }


    /* ---------- Accordéon (desktop + menu agrandi) ---------- */

    function toggleAccordion(btn) {
        const menu = getMenu(btn);
        if (!menu) return;

        const wasOpen = menu.classList.contains('open');

        sidebar.querySelectorAll('.sidebar-submenu').forEach(function (m) {
            m.classList.remove('open');
        });

        buttons.forEach(function (b) {
            b.classList.remove('open');
            b.setAttribute('aria-expanded', 'false');
        });

        if (!wasOpen) {
            menu.classList.add('open');
            btn.classList.add('open');
            btn.setAttribute('aria-expanded', 'true');
        }
    }


    /* ---------- Clic sur un grand menu ---------- */

    buttons.forEach(function (btn) {

        btn.addEventListener('click', function (e) {
            e.stopPropagation();

            if (isRail()) {
                const menu = getMenu(btn);
                const alreadyOpen = menu && menu.classList.contains('flyout-open');

                // Avec une souris, le survol l'a déjà ouvert : on le laisse ouvert
                if (alreadyOpen && !hoverMq.matches) {
                    closeFlyouts();
                } else {
                    openFlyout(btn);
                }
            } else {
                toggleAccordion(btn);
            }
        });

    });


    /* ---------- Survol (souris uniquement) ---------- */

    groups.forEach(function (group) {

        const btn = group.querySelector('.sidebar-menu-toggle');
        if (!btn) return;

        group.addEventListener('mouseenter', function () {
            if (!isRail() || !hoverMq.matches) return;

            clearTimeout(closeTimer);

            const menu = getMenu(btn);
            if (menu && !menu.classList.contains('flyout-open')) {
                openFlyout(btn);
            }
        });

        group.addEventListener('mouseleave', function () {
            if (!isRail() || !hoverMq.matches) return;

            clearTimeout(closeTimer);
            closeTimer = setTimeout(closeFlyouts, 160);
        });

    });

    // Quand on survole un lien sans sous-menu (ex. Tableau de bord), on ferme le panneau
    sidebar.querySelectorAll('.sidebar-main-link').forEach(function (link) {
        link.addEventListener('mouseenter', function () {
            if (isRail() && hoverMq.matches) closeFlyouts();
        });
    });


    /* ---------- Agrandir / réduire la barre ---------- */

    function setExpanded(value) {
        sidebar.classList.toggle('is-expanded', value);

        if (backdrop)  backdrop.classList.toggle('show', value);
        if (toggleBtn) toggleBtn.setAttribute('aria-expanded', String(value));

        closeFlyouts();
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            setExpanded(!sidebar.classList.contains('is-expanded'));
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', function () {
            setExpanded(false);
        });
    }

    // Tout bouton externe avec l'attribut data-sidebar-toggle peut aussi agrandir le menu
    document.querySelectorAll('[data-sidebar-toggle]').forEach(function (el) {
        el.addEventListener('click', function () {
            if (isCompact()) setExpanded(!sidebar.classList.contains('is-expanded'));
        });
    });


    /* ---------- Fermetures ---------- */

    document.addEventListener('click', function (e) {
        if (isRail() && !e.target.closest('.sidebar-menu-group')) {
            closeFlyouts();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeFlyouts();
            if (sidebar.classList.contains('is-expanded')) setExpanded(false);
        }
    });

    if (nav) nav.addEventListener('scroll', closeFlyouts);
    window.addEventListener('resize', closeFlyouts);

    // Passage tablette <-> ordinateur : on remet tout à zéro
    const onBreakpointChange = function () {
        setExpanded(false);
    };

    if (compactMq.addEventListener) {
        compactMq.addEventListener('change', onBreakpointChange);
    } else if (compactMq.addListener) {
        compactMq.addListener(onBreakpointChange);
    }

});

</script>