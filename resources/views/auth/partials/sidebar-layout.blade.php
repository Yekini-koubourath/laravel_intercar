<style>

/* =========================================================
   MISE EN PAGE AVEC LE SIDEBAR (partagée par toutes les pages)
========================================================= */

:root {
    --sidebar-width: 250px;
}

/* Sécurité : anciens éléments des pages, neutralisés s'il en reste */
.sidebar-overlay {
    display: none !important;
}

.main-wrapper #sidebarToggle,
.main-wrapper .sidebar-toggle {
    display: none !important;
}

/* Taille du texte des liens principaux (avant, elle venait des pages) */
#sidebar .sidebar-main-link,
#sidebar .sidebar-menu-toggle {
    font-size: 0.85rem;
    font-weight: 500;
    gap: 12px;
}


/* =========================================================
   GRANDS ÉCRANS (≥ 992px) : sidebar fixe de 250px
========================================================= */

@media (min-width: 992px) {

    #sidebar.sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--sidebar-width);
        height: 100vh;
        height: 100dvh;
        overflow-y: auto;
        z-index: 1000;
    }

    #sidebar .sidebar-brand {
        padding: 1.5rem 1rem 1rem;
    }

    .main-wrapper {
        margin-left: var(--sidebar-width);
    }
}


/* =========================================================
   TABLETTES → TÉLÉPHONES (< 992px) : barre de 72px
========================================================= */

@media (max-width: 991.98px) {

    .main-wrapper {
        margin-left: var(--sb-rail-width, 72px) !important;
    }

    .bottom-actions {
        left: var(--sb-rail-width, 72px) !important;
    }
}

</style>