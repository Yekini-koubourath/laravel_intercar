{{-- COLONNE GAUCHE : Image (50%) — partagée entre login et register --}}
<div class="col-12 col-lg-6 d-none d-lg-block position-relative"
     style="background-image: url('{{ asset('images/image-page-d-authentification.png') }}'); background-size: cover; background-position: center; min-height: 100vh;">

    {{-- Overlay sombre / violet --}}
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(26, 11, 46, 0.60);"></div>

    {{-- Contenu superposé --}}
    <div class="position-relative z-1 d-flex flex-column justify-content-between h-100 p-5 text-white">

        <div class="text-end">
            <small class="text-white-100 fw-light">Votre partenaire de confiance<br>pour tous vos véhicules et pièces détachées.</small>
        </div>

        <div class="my-auto">
            <h1 class="display-5 fw-bold text-white lh-base mb-3">
                Des véhicules fiables,<br>
                des pièces de qualité,<br>
                <span style="color: #F37021;">pour avancer ensemble.</span>
            </h1>
        </div>

        <div class="row g-3 pt-4 border-top border-white border-opacity-25">
            <div class="col-4 d-flex align-items-center gap-2">
                <i class="fa-solid fa-car fs-4" style="color: #F37021;"></i>
                <span class="small lh-sm">Véhicules neufs & occasion</span>
            </div>
            <div class="col-4 d-flex align-items-center gap-2">
                <i class="fa-solid fa-gears fs-4" style="color: #F37021;"></i>
                <span class="small lh-sm">Pièces toutes marques</span>
            </div>
            <div class="col-4 d-flex align-items-center gap-2">
                <i class="fa-solid fa-shield-halved fs-4" style="color: #F37021;"></i>
                <span class="small lh-sm">Service professionnel</span>
            </div>
        </div>

    </div>
</div>