<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Produits - INTERCAR</title>

<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- BOOTSTRAP ICONS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- GOOGLE FONT -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

/* =========================================================
   VARIABLES
========================================================= */

:root{
  --purple-sidebar:#30173D;
  --purple-main:#6f42c1;
  --purple-btn:#512264;
  --orange-active:#F37021;
  --bg-body:#F4F5F8;
  --card-border-radius:12px;
}


/* =========================================================
   GLOBAL
========================================================= */

html,
body{
  margin:0;
  padding:0;
  min-height:100%;
}

body{
  background:var(--bg-body);
  font-family:'Inter',sans-serif;
  color:#2D3748;
  font-size:.875rem;
}


/* =========================================================
   CONTENU PRINCIPAL
   (le décalage à gauche vient de sidebar-layout)
========================================================= */

.main-wrapper{
  padding:1.25rem 2rem 2rem;
}


/* =========================================================
   TOP BAR
========================================================= */

.top-bar{
  background:#fff;
  border-radius:12px;
  padding:.5rem 1.25rem;
  box-shadow:0 2px 4px rgba(0,0,0,.02);
}

.search-box{
  background:#F8F9FA;
  border-radius:8px;
  border:1px solid #E9ECEF;
  min-width:0;
  max-width:480px;
}

.search-box input{
  min-width:0;
}

.search-box input::placeholder{
  color:#A0AEC0;
  font-size:.825rem;
}


/* =========================================================
   CARDS GENERALES
========================================================= */

.card-custom{
  background:#fff;
  border:none;
  border-radius:var(--card-border-radius);
  padding:1.25rem;
  box-shadow:0 2px 8px rgba(0,0,0,.03);
}


/* =========================================================
   GRILLE DES PRODUITS
========================================================= */

.product-card{
  display:flex;
  flex-direction:column;
  height:100%;
  background:#fff;
  border:1px solid #eceef3;
  border-radius:14px;
  overflow:hidden;
  box-shadow:0 2px 8px rgba(0,0,0,.03);
  transition:transform .22s ease, box-shadow .22s ease, border-color .22s ease;
}

.product-card:hover{
  transform:translateY(-4px);
  border-color:#ddd0f2;
  box-shadow:0 14px 30px rgba(48,23,61,.12);
}


/* ----- Photo ----- */

.product-card-media{
  position:relative;
  aspect-ratio:4 / 3;
  background:#F4F5F8;
  overflow:hidden;
}

.product-card-media img{
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
  transition:transform .4s ease;
}

.product-card:hover .product-card-media img{
  transform:scale(1.05);
}

.product-card-placeholder{
  width:100%;
  height:100%;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#B8BFCC;
  font-size:2.6rem;
}

.product-badge-top{
  position:absolute;
  top:10px;
  left:10px;
  display:flex;
  gap:6px;
  flex-wrap:wrap;
  max-width:calc(100% - 70px);
}

.product-badge-top .badge{
  font-weight:600;
  padding:.4em .65em;
  box-shadow:0 2px 6px rgba(0,0,0,.12);
}

.product-photo-count{
  position:absolute;
  right:10px;
  bottom:10px;
  background:rgba(26,11,46,.72);
  color:#fff;
  font-size:.7rem;
  font-weight:600;
  padding:.25rem .55rem;
  border-radius:999px;
  backdrop-filter:blur(4px);
}

.product-status-dot{
  position:absolute;
  top:10px;
  right:10px;
  font-size:.68rem;
  font-weight:600;
  padding:.3rem .6rem;
  border-radius:999px;
  background:#fff;
  box-shadow:0 2px 6px rgba(0,0,0,.12);
}

.product-status-dot.actif{ color:#198754; }
.product-status-dot.inactif{ color:#6c757d; }
.product-status-dot.brouillon{ color:#997404; }


/* ----- Corps ----- */

.product-card-body{
  display:flex;
  flex-direction:column;
  flex:1 1 auto;
  padding:1rem;
}

.product-card-ref{
  font-size:.7rem;
  font-weight:600;
  letter-spacing:.04em;
  color:#9A9FB0;
  text-transform:uppercase;
}

.product-card-title{
  margin:.15rem 0 .2rem;
  font-size:1rem;
  font-weight:700;
  color:#1A202C;
  line-height:1.3;
  display:-webkit-box;
  -webkit-line-clamp:2;
  -webkit-box-orient:vertical;
  overflow:hidden;
}

.product-card-sub{
  font-size:.8rem;
  color:#718096;
  margin-bottom:.7rem;
}

.product-specs{
  display:flex;
  flex-wrap:wrap;
  gap:.4rem;
  margin-bottom:.9rem;
}

.spec-chip{
  display:inline-flex;
  align-items:center;
  gap:.35rem;
  background:#F6F4FB;
  color:#4A3B63;
  font-size:.72rem;
  font-weight:500;
  padding:.3rem .6rem;
  border-radius:999px;
  white-space:nowrap;
}

.spec-chip i{
  color:var(--purple-main);
  font-size:.7rem;
}


/* ----- Prix ----- */

.product-prices{
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:.6rem;
  margin-top:auto;
  margin-bottom:.8rem;
}

.price-box{
  background:#FAFAFD;
  border:1px solid #ECEEF4;
  border-radius:10px;
  padding:.55rem .7rem;
  min-width:0;
}

.price-box.sell{
  background:#F8F5FF;
  border-color:#E2D6F7;
}

.price-label{
  font-size:.64rem;
  font-weight:600;
  letter-spacing:.03em;
  color:#8A90A2;
  text-transform:uppercase;
  line-height:1.2;
}

.price-value{
  margin-top:.15rem;
  font-size:.92rem;
  font-weight:700;
  color:#1A202C;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
}

.price-box.sell .price-value{
  color:var(--purple-btn);
}

.price-value small{
  font-size:.65rem;
  font-weight:600;
  color:#8A90A2;
}


/* ----- Stock + actions ----- */

.product-stock-line{
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:.5rem;
  font-size:.78rem;
  color:#4A5568;
  padding-top:.7rem;
  border-top:1px dashed #E5E7EE;
  margin-bottom:.8rem;
}

.product-card-actions{
  display:flex;
  gap:.5rem;
}

.btn-details{
  flex:1 1 auto;
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:.45rem;
  background:var(--purple-btn);
  color:#fff;
  border:none;
  font-size:.8rem;
  font-weight:600;
  padding:.55rem .8rem;
  border-radius:9px;
  transition:background .2s ease, transform .15s ease;
}

.btn-details:hover,
.btn-details:focus{
  background:#3D184C;
  color:#fff;
}

.btn-details:active{
  transform:scale(.98);
}

.btn-icon-soft{
  width:38px;
  flex-shrink:0;
  background:#fff;
  border:1px solid #E2E8F0;
  border-radius:9px;
  color:#6B7280;
  transition:all .2s ease;
}

.btn-icon-soft:hover{
  background:#F6F4FB;
  color:var(--purple-btn);
}

.btn-icon-soft.danger:hover{
  background:#FEF2F2;
  color:#DC2626;
  border-color:#FECACA;
}


/* ----- Etat vide ----- */

.empty-state{
  text-align:center;
  padding:3rem 1rem;
  color:#718096;
}


/* =========================================================
   BOUTON VIOLET
========================================================= */

.btn-purple{
  background:var(--purple-btn);
  color:#fff;
  border:none;
  font-size:.825rem;
  padding:.5rem 1rem;
  border-radius:8px;
  font-weight:500;
}

.btn-purple:hover,
.btn-purple:focus{
  background:#3D184C;
  color:#fff;
}


/* =========================================================
   MODAL DETAILS PRODUIT
========================================================= */

#detailModal .modal-content{
  border:none;
  border-radius:16px;
  overflow:hidden;
}

#detailModal .modal-header{
  border-bottom:1px solid #E9ECEF;
  padding:1rem 1.25rem;
}

#detailModal .modal-body{
  padding:1.25rem;
  background:#f6f7fb;
}

.detail-gallery-main{
  position:relative;
  aspect-ratio:4 / 3;
  background:#fff;
  border:1px solid #E5E7EE;
  border-radius:14px;
  overflow:hidden;
}

.detail-gallery-main img{
  width:100%;
  height:100%;
  object-fit:cover;
  display:block;
}

.detail-thumbs{
  display:flex;
  gap:.5rem;
  margin-top:.6rem;
  overflow-x:auto;
  padding-bottom:.25rem;
}

.detail-thumb{
  width:64px;
  height:64px;
  flex-shrink:0;
  border-radius:9px;
  object-fit:cover;
  border:2px solid transparent;
  cursor:pointer;
  opacity:.75;
  transition:all .2s ease;
}

.detail-thumb:hover{ opacity:1; }

.detail-thumb.active{
  border-color:var(--purple-main);
  opacity:1;
}

.detail-block{
  background:#fff;
  border:1px solid #E8E9EF;
  border-radius:14px;
  padding:1rem 1.1rem;
  margin-bottom:.9rem;
}

.detail-block-title{
  font-size:.72rem;
  font-weight:700;
  letter-spacing:.06em;
  color:var(--purple-main);
  text-transform:uppercase;
  margin-bottom:.6rem;
}

.detail-line{
  display:flex;
  justify-content:space-between;
  gap:1rem;
  padding:.5rem 0;
  border-bottom:1px solid #F0F1F5;
  font-size:.86rem;
}

.detail-line:last-child{ border-bottom:0; }
.detail-line .k{ color:#777b87; }
.detail-line .v{ font-weight:600; text-align:right; word-break:break-word; }

.detail-price-grid{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:.6rem;
}

.detail-price-grid .price-box{ padding:.7rem .8rem; }
.detail-price-grid .price-value{ font-size:1rem; }


/* =========================================================
   MODAL AJOUT PRODUIT
========================================================= */

#addProductModal .modal-dialog{
  max-width:1140px;
  margin:.75rem auto;
}

#addProductModal .modal-dialog-scrollable{
  height:calc(100dvh - 1.5rem);
  max-height:none;
}

#addProductModal .modal-dialog-scrollable .modal-content{
  height:100%;
  max-height:none;
  border:none;
  border-radius:14px;
  overflow:hidden;
  display:flex;
  flex-direction:column;
}

#productForm{
  display:flex;
  flex-direction:column;
  flex:1 1 auto;
  min-height:0;
  overflow:hidden;
}

#addProductModal .modal-header{
  border-bottom:1px solid #E9ECEF;
  padding:1rem 1.25rem;
  background:#fff;
  flex:0 0 auto;
}

#addProductModal .modal-dialog-scrollable .modal-body{
  flex:1 1 auto;
  min-height:0;
  overflow-y:auto;
  overflow-x:hidden;
  overscroll-behavior:contain;
  padding:1.25rem 1.25rem 2rem;
  -webkit-overflow-scrolling:touch;
  background:#f6f7fb;
  scrollbar-width:thin;
  scrollbar-color:#C9C0CE #F4F5F8;
}

#addProductModal .modal-dialog-scrollable .modal-body::-webkit-scrollbar{ width:8px; }
#addProductModal .modal-dialog-scrollable .modal-body::-webkit-scrollbar-track{ background:#F4F5F8; }
#addProductModal .modal-dialog-scrollable .modal-body::-webkit-scrollbar-thumb{ background:#C9C0CE; border-radius:10px; }
#addProductModal .modal-dialog-scrollable .modal-body::-webkit-scrollbar-thumb:hover{ background:var(--purple-main); }

#addProductModal .modal-footer{
  border-top:1px solid #E9ECEF;
  padding:1rem 1.25rem;
  background:#fff;
  flex:0 0 auto;
  gap:.5rem;
}


/* =========================================================
   FORMULAIRE
========================================================= */

#addProductModal .modal-body .card{
  border:1px solid #e8e9ef;
  border-radius:14px;
  box-shadow:0 2px 8px rgba(0,0,0,.03);
}

#addProductModal .modal-body .card-header{
  background:#fff;
  border-bottom:1px solid #eeeef3;
  padding:18px 20px;
  font-weight:600;
}

.form-label{
  font-size:.88rem;
  font-weight:600;
  margin-bottom:7px;
}

.form-control,
.form-select{
  min-height:44px;
  border-color:#dddfe7;
  border-radius:9px;
}

.form-control:focus,
.form-select:focus{
  border-color:#6f42c1;
  box-shadow:0 0 0 .2rem rgba(111,66,193,.1);
}

textarea.form-control{ min-height:110px; }

.required{ color:#dc3545; }


/* =========================================================
   TYPE PRODUIT
========================================================= */

.product-type{ position:relative; height:100%; }

.product-type input{
  position:absolute;
  opacity:0;
  pointer-events:none;
}

.product-type-card{
  display:flex;
  align-items:center;
  gap:15px;
  padding:18px;
  border:2px solid #e5e6ec;
  border-radius:12px;
  background:#fff;
  cursor:pointer;
  transition:all .2s;
  height:100%;
}

.product-type-card:hover{ border-color:#b9a4df; background:#faf9fd; }
.product-type-card.active{ border-color:#6f42c1; background:#f8f5ff; }

.type-icon{
  width:48px;
  height:48px;
  border-radius:12px;
  display:flex;
  align-items:center;
  justify-content:center;
  background:#f0ebfa;
  color:#6f42c1;
  font-size:22px;
  flex-shrink:0;
}

.product-type-card.active .type-icon{ background:#6f42c1; color:#fff; }

.type-title{ font-weight:600; margin-bottom:3px; }
.type-description{ font-size:.82rem; color:#777b87; margin:0; }


/* =========================================================
   SECTIONS DYNAMIQUES
========================================================= */

.dynamic-section{ display:none; }

.dynamic-section.show{
  display:block;
  animation:fadeIn .2s ease;
}

@keyframes fadeIn{
  from{ opacity:0; transform:translateY(5px); }
  to{ opacity:1; transform:translateY(0); }
}


/* =========================================================
   UPLOAD
========================================================= */

.upload-zone{
  display:block;
  border:2px dashed #d8dae3;
  border-radius:12px;
  padding:30px 20px;
  text-align:center;
  background:#fafafd;
  cursor:pointer;
  transition:.2s;
}

.upload-zone:hover{ border-color:#6f42c1; background:#f8f5ff; }

.upload-icon{ font-size:35px; color:#6f42c1; }


/* =========================================================
   PREVISUALISATION PHOTOS
========================================================= */

.image-preview-item{ position:relative; }

.image-preview-card{
  position:relative;
  overflow:hidden;
  border:1px solid #e1e3ea;
  border-radius:12px;
  background:#fff;
  padding:6px;
}

.image-preview-card img{
  width:100%;
  height:150px;
  object-fit:cover;
  display:block;
  border-radius:8px;
}

.image-preview-remove{
  position:absolute;
  top:10px;
  right:10px;
  width:30px;
  height:30px;
  border:none;
  border-radius:50%;
  background:#dc3545;
  color:#fff;
  display:flex;
  align-items:center;
  justify-content:center;
  cursor:pointer;
  z-index:2;
  box-shadow:0 2px 6px rgba(0,0,0,.2);
}

.image-preview-remove:hover{ background:#b02a37; }

.image-preview-name{
  font-size:.75rem;
  color:#6c757d;
  margin-top:6px;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
}

.image-preview-size{ font-size:.7rem; color:#9a9da5; }


/* =========================================================
   RESUME
========================================================= */

.summary-item{
  display:flex;
  justify-content:space-between;
  gap:15px;
  padding:9px 0;
  border-bottom:1px solid #eeeef2;
  font-size:.9rem;
}

.summary-item:last-child{ border-bottom:0; }
.summary-label{ color:#777b87; }
.summary-value{ font-weight:600; text-align:right; word-break:break-word; }


/* =========================================================
   STOCK / STATUT
========================================================= */

.stock-box{
  background:#fafafd;
  border:1px solid #e7e8ee;
  border-radius:10px;
  padding:15px;
}

.status-badge{
  background:#e9f7ef;
  color:#198754;
  font-size:.78rem;
  padding:5px 9px;
  border-radius:20px;
}


/* =========================================================
   BOUTONS MODAL
========================================================= */

#addProductModal .modal-footer .btn,
#addProductModal .modal-body .btn{
  border-radius:9px;
  min-height:42px;
  font-weight:500;
}

.btn-primary{ background:#6f42c1; border-color:#6f42c1; }
.btn-primary:hover{ background:#5e35aa; border-color:#5e35aa; }


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width:991.98px){

  .main-wrapper{ padding:1rem; }

  #addProductModal .modal-dialog{
    max-width:calc(100% - 1rem);
    margin:.5rem auto;
  }

  #addProductModal .modal-dialog-scrollable{
    height:calc(100dvh - 1rem);
  }
}


@media (max-width:575.98px){

  .main-wrapper{ padding:.75rem; }

  .top-bar{ padding:.5rem .75rem; }

  .card-custom{ padding:1rem; }

  .detail-price-grid{ grid-template-columns:1fr 1fr; }

  #addProductModal .modal-dialog,
  #addProductModal .modal-dialog-scrollable{
    width:100%;
    max-width:none;
    height:100dvh;
    min-height:100dvh;
    max-height:100dvh;
    margin:0;
  }

  #addProductModal .modal-dialog-scrollable .modal-content{
    height:100dvh;
    border-radius:0;
  }

  #addProductModal .modal-dialog-scrollable .modal-body{
    padding:1rem 1rem 2rem;
  }

  #addProductModal .modal-footer{ flex-wrap:wrap; }

  #addProductModal .modal-footer .btn{
    flex:1;
    min-width:130px;
  }
}

</style>

@include('auth.partials.sidebar-layout')
</head>


<body>

<!-- SIDEBAR -->
@include('auth.partials.sidebar')


@php
    /*
    |------------------------------------------------------------------
    | LIBELLES (utilisés par les cartes et par la fiche détail en JS)
    |------------------------------------------------------------------
    */
    $labels = [
        'fuel' => [
            'essence' => 'Essence', 'diesel' => 'Diesel',
            'hybride' => 'Hybride', 'electrique' => 'Électrique',
        ],
        'transmission' => [
            'manuelle' => 'Manuelle', 'automatique' => 'Automatique', 'cvt' => 'CVT',
        ],
        'condition' => [
            'neuf' => 'Neuf', 'occasion' => 'Occasion', 'reconditionne' => 'Reconditionné',
        ],
        'availability' => [
            'disponible' => 'Disponible', 'reserve' => 'Réservé', 'vendu' => 'Vendu',
        ],
        'warranty' => [
            'sans' => 'Sans garantie', '3_mois' => '3 mois', '6_mois' => '6 mois',
            '12_mois' => '12 mois', '24_mois' => '24 mois',
        ],
        'pieceCategory' => [
            'moteur' => 'Moteur', 'freinage' => 'Freinage', 'suspension' => 'Suspension',
            'electricite' => 'Électricité', 'carrosserie' => 'Carrosserie',
            'filtration' => 'Filtration', 'eclairage' => 'Éclairage',
            'accessoires' => 'Accessoires',
        ],
        'unit' => [
            'piece' => 'Pièce', 'kit' => 'Kit', 'lot' => 'Lot', 'paire' => 'Paire',
        ],
        'status' => [
            'actif' => 'Actif', 'inactif' => 'Inactif', 'brouillon' => 'Brouillon',
        ],
        'location' => [
            'boutique_principale' => 'Boutique principale',
        ],
    ];

    /*
    |------------------------------------------------------------------
    | DONNEES ENVOYEES AU JAVASCRIPT (fiche détail)
    |------------------------------------------------------------------
    */
    $productsData = $products->map(function ($p) {
        return [
            'id'                     => $p->id,
            'type'                   => $p->type,
            'reference'              => $p->reference,
            'name'                   => $p->name,
            'brand'                  => $p->brand,
            'category'               => $p->category,
            'description'            => $p->description,
            'status'                 => $p->status,
            'selling_price'          => (float) $p->selling_price,
            'purchase_price'         => $p->purchase_price !== null ? (float) $p->purchase_price : null,
            'quantity'               => (int) $p->quantity,
            'stock_minimum'          => (int) $p->stock_minimum,
            'location'               => $p->location,
            'images'                 => $p->images
                ->map(fn ($img) => route('product.image', ['path' => $img->path]))
                ->values(),

            'vehicle_model'          => $p->vehicle_model,
            'vehicle_year'           => $p->vehicle_year,
            'fuel'                   => $p->fuel,
            'transmission'           => $p->transmission,
            'mileage'                => $p->mileage,
            'doors'                  => $p->doors,
            'color'                  => $p->color,
            'condition'              => $p->condition,
            'availability'           => $p->availability,

            'manufacturer_reference' => $p->manufacturer_reference,
            'piece_category'         => $p->piece_category,
            'compatibility'          => $p->compatibility,
            'piece_brand'            => $p->piece_brand,
            'condition_piece'        => $p->condition_piece,
            'warranty'               => $p->warranty,
            'unit'                   => $p->unit,
        ];
    })->values();
@endphp


<!-- =========================================================
     CONTENU
========================================================= -->

<main class="main-wrapper">


  <!-- ALERTES -->

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


  <!-- TOP BAR -->

  <header class="top-bar d-flex align-items-center justify-content-between gap-2 mb-4">

    <div class="search-box d-flex align-items-center px-3 py-2 flex-grow-1">

      <i class="fa-solid fa-magnifying-glass text-muted me-2"></i>

      <input type="text"
             class="form-control bg-transparent border-0 p-0"
             placeholder="Rechercher un produit, une référence, un client...">

    </div>

    <div class="d-flex align-items-center gap-3 flex-shrink-0">

      <div class="d-none d-md-flex align-items-center gap-2 bg-light px-3 py-2 rounded-3 border"
           style="font-size:.8rem;">

        <i class="fa-solid fa-location-dot text-muted"></i>

        <div>
          <div class="fw-semibold lh-1">Boutique principale</div>
          <div class="text-muted" style="font-size:.7rem;">Cotonou, Bénin</div>
        </div>

        <i class="fa-solid fa-chevron-down text-muted ms-2" style="font-size:.7rem;"></i>

      </div>

      <button class="btn btn-light rounded-circle p-2 position-relative border"
              type="button"
              aria-label="Notifications">

        <i class="fa-regular fa-bell text-secondary"></i>

        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>

      </button>

      <div class="d-flex align-items-center gap-2">

        <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold"
             style="width:36px;height:36px;background:var(--purple-sidebar);font-size:.85rem;">

          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

        </div>

        <span class="fw-semibold d-none d-sm-inline" style="font-size:.85rem;">
          {{ Auth::user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}" class="m-0">
          @csrf
          <button type="submit" class="btn btn-light btn-sm border ms-2" title="Se déconnecter">
            <i class="fa-solid fa-right-from-bracket"></i>
          </button>
        </form>

      </div>

    </div>

  </header>


  <!-- TITRE -->

  <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">

    <div class="d-flex align-items-center gap-3">

      <div class="rounded-3 text-white d-flex align-items-center justify-content-center flex-shrink-0"
           style="background:var(--purple-sidebar);width:42px;height:42px;">
        <i class="fa-solid fa-box fs-5"></i>
      </div>

      <div>
        <h4 class="fw-bold mb-0" style="color:#1A202C;">Produits</h4>
        <p class="text-muted small mb-0">Gérez vos véhicules et pièces détachées.</p>
      </div>

    </div>

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

    <div class="col-12 col-md-4">
      <div class="card-custom h-100">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-muted mb-1">Total produits</p>
            <h3 class="fw-bold mb-0">{{ $products->count() }}</h3>
          </div>
          <div class="rounded-circle bg-light p-3">
            <i class="fa-solid fa-box fs-4 text-primary"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card-custom h-100">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-muted mb-1">Pièces détachées</p>
            <h3 class="fw-bold mb-0">{{ $products->where('type', 'piece')->count() }}</h3>
          </div>
          <div class="rounded-circle bg-light p-3">
            <i class="fa-solid fa-gears fs-4 text-warning"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-4">
      <div class="card-custom h-100">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-muted mb-1">Véhicules</p>
            <h3 class="fw-bold mb-0">{{ $products->where('type', 'vehicule')->count() }}</h3>
          </div>
          <div class="rounded-circle bg-light p-3">
            <i class="fa-solid fa-car fs-4 text-success"></i>
          </div>
        </div>
      </div>
    </div>

  </div>


  <!-- =======================================================
       FILTRES + GRILLE DES PRODUITS
  ======================================================== -->

  <div class="card-custom">

    <!-- FILTRES -->

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
          <option value="">Tous les types</option>
          <option value="piece">Pièces</option>
          <option value="vehicule">Véhicules</option>
        </select>
      </div>

      <div class="col-12 col-md-3">
        <select class="form-select" id="filterStatus">
          <option value="">Tous les statuts</option>
          <option value="actif">Actif</option>
          <option value="inactif">Inactif</option>
          <option value="brouillon">Brouillon</option>
        </select>
      </div>

    </div>


    @if($products->isEmpty())

      <div class="empty-state">
        <div class="mb-3"><i class="fa-solid fa-box-open fs-1 text-muted"></i></div>
        <h5 class="fw-semibold">Aucun produit</h5>
        <p class="mb-0">Aucun produit n'a encore été enregistré.</p>
      </div>

    @else

      <div class="row g-3" id="productsGrid">

        @foreach($products as $product)

          @php
              $isVehicle = $product->type === 'vehicule';
              $cover     = $product->images->first();
              $photoCnt  = $product->images->count();

              $condKey   = $isVehicle ? $product->condition : $product->condition_piece;
              $condLabel = $labels['condition'][$condKey] ?? null;
              $condClass = match ($condKey) {
                  'neuf'          => 'bg-success',
                  'occasion'      => 'bg-warning text-dark',
                  'reconditionne' => 'bg-info text-dark',
                  default         => 'bg-secondary',
              };

              $brand = $product->brand ?: ($product->piece_brand ?: null);

              $searchText = mb_strtolower(implode(' ', array_filter([
                  $product->reference, $product->name, $brand, $product->category,
                  $product->vehicle_model, $product->vehicle_year,
                  $product->manufacturer_reference, $product->piece_brand,
                  $product->compatibility,
              ])));

              $qty      = (int) $product->quantity;
              $lowStock = $qty > 0 && $qty <= (int) $product->stock_minimum && ! $isVehicle;
          @endphp

          <div class="col-12 col-sm-6 col-xl-4 col-xxl-3 product-col"
               data-type="{{ $product->type }}"
               data-status="{{ $product->status }}"
               data-search="{{ $searchText }}">

            <article class="product-card">

              <!-- PHOTO -->
              <div class="product-card-media">

                @if($cover)
                  <img src="{{ route('product.image', ['path' => $cover->path]) }}"
                       alt="{{ $product->name }}"
                       loading="lazy">
                @else
                  <div class="product-card-placeholder">
                    <i class="fa-solid {{ $isVehicle ? 'fa-car' : 'fa-gears' }}"></i>
                  </div>
                @endif

                <div class="product-badge-top">
                  @if($isVehicle)
                    <span class="badge bg-info text-dark">
                      <i class="fa-solid fa-car me-1"></i>Véhicule
                    </span>
                  @else
                    <span class="badge bg-warning text-dark">
                      <i class="fa-solid fa-gears me-1"></i>Pièce
                    </span>
                  @endif

                  @if($condLabel)
                    <span class="badge {{ $condClass }}">{{ $condLabel }}</span>
                  @endif
                </div>

                <span class="product-status-dot {{ $product->status }}">
                  {{ $labels['status'][$product->status] ?? $product->status }}
                </span>

                @if($photoCnt > 1)
                  <span class="product-photo-count">
                    <i class="fa-regular fa-images me-1"></i>{{ $photoCnt }}
                  </span>
                @endif

              </div>


              <!-- CORPS -->
              <div class="product-card-body">

                <div class="product-card-ref">{{ $product->reference }}</div>

                <h5 class="product-card-title" title="{{ $product->name }}">
                  {{ $product->name }}
                </h5>

                <div class="product-card-sub">
                  @if($isVehicle)
                    {{ collect([$brand, $product->vehicle_model, $product->vehicle_year])->filter()->implode(' · ') ?: '—' }}
                  @else
                    {{ collect([$brand, $labels['pieceCategory'][$product->piece_category] ?? $product->category])->filter()->implode(' · ') ?: '—' }}
                  @endif
                </div>

                <!-- Infos essentielles selon le type -->
                <div class="product-specs">

                  @if($isVehicle)

                    @if($product->fuel)
                      <span class="spec-chip">
                        <i class="fa-solid fa-gas-pump"></i>{{ $labels['fuel'][$product->fuel] ?? $product->fuel }}
                      </span>
                    @endif

                    @if($product->transmission)
                      <span class="spec-chip">
                        <i class="fa-solid fa-gears"></i>{{ $labels['transmission'][$product->transmission] ?? $product->transmission }}
                      </span>
                    @endif

                    @if($product->mileage !== null)
                      <span class="spec-chip">
                        <i class="fa-solid fa-gauge-high"></i>{{ number_format($product->mileage, 0, ',', ' ') }} km
                      </span>
                    @endif

                  @else

                    @if($product->manufacturer_reference)
                      <span class="spec-chip">
                        <i class="fa-solid fa-barcode"></i>{{ $product->manufacturer_reference }}
                      </span>
                    @endif

                    @if($product->warranty)
                      <span class="spec-chip">
                        <i class="fa-solid fa-shield-halved"></i>{{ $labels['warranty'][$product->warranty] ?? $product->warranty }}
                      </span>
                    @endif

                    @if($product->unit)
                      <span class="spec-chip">
                        <i class="fa-solid fa-cubes"></i>{{ $labels['unit'][$product->unit] ?? $product->unit }}
                      </span>
                    @endif

                  @endif

                </div>

                <!-- Prix -->
                <div class="product-prices">

                  <div class="price-box">
                    <div class="price-label">Prix d'achat unitaire</div>
                    <div class="price-value">
                      @if($product->purchase_price !== null && $product->purchase_price > 0)
                        {{ number_format($product->purchase_price, 0, ',', ' ') }} <small>FCFA</small>
                      @else
                        —
                      @endif
                    </div>
                  </div>

                  <div class="price-box sell">
                    <div class="price-label">Prix de vente</div>
                    <div class="price-value">
                      {{ number_format($product->selling_price, 0, ',', ' ') }} <small>FCFA</small>
                    </div>
                  </div>

                </div>

                <!-- Stock -->
                <div class="product-stock-line">
                  <span>
                    <i class="fa-solid fa-boxes-stacked me-1 text-muted"></i>
                    Stock : <strong>{{ $qty }}</strong>
                  </span>

                  @if($qty <= 0)
                    <span class="badge bg-danger">Rupture</span>
                  @elseif($lowStock)
                    <span class="badge bg-warning text-dark">Stock faible</span>
                  @else
                    <span class="badge bg-success">En stock</span>
                  @endif
                </div>

                <!-- Actions -->
                <div class="product-card-actions">

                  <button type="button"
                          class="btn-details btn-view-details"
                          data-id="{{ $product->id }}">
                    <i class="fa-regular fa-eye"></i>
                    Voir les détails
                  </button>

                  <button type="button" class="btn-icon-soft" title="Modifier">
                    <i class="fa-solid fa-pen"></i>
                  </button>

                  <button type="button" class="btn-icon-soft danger" title="Supprimer">
                    <i class="fa-solid fa-trash"></i>
                  </button>

                </div>

              </div>

            </article>

          </div>

        @endforeach

      </div>

      <div class="empty-state d-none" id="noResults">
        <div class="mb-3"><i class="fa-solid fa-magnifying-glass fs-1 text-muted"></i></div>
        <h5 class="fw-semibold">Aucun résultat</h5>
        <p class="mb-0">Aucun produit ne correspond à votre recherche.</p>
      </div>

    @endif

  </div>

</main>


<!-- =========================================================
     MODAL DETAILS PRODUIT
========================================================= -->

<div class="modal fade"
     id="detailModal"
     tabindex="-1"
     aria-labelledby="detailModalLabel"
     aria-hidden="true">

  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

    <div class="modal-content">

      <div class="modal-header">
        <div>
          <div class="text-muted small mb-1" id="detailRef">—</div>
          <h5 class="modal-title fw-bold" id="detailModalLabel">—</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>

      <div class="modal-body">
        <div class="row g-4">

          <div class="col-lg-5">
            <div class="detail-gallery-main" id="detailGallery"></div>
            <div class="detail-thumbs" id="detailThumbs"></div>
          </div>

          <div class="col-lg-7" id="detailInfo"></div>

        </div>
      </div>

      <div class="modal-footer bg-white">
        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Fermer</button>
      </div>

    </div>

  </div>

</div>


<!-- =========================================================
     MODAL AJOUT PRODUIT
========================================================= -->

<div class="modal fade"
     id="addProductModal"
     tabindex="-1"
     aria-labelledby="addProductModalLabel"
     aria-hidden="true">

  <div class="modal-dialog modal-xl modal-dialog-scrollable">

    <div class="modal-content">

      <div class="modal-header">
        <div>
          <div class="text-muted small mb-1">Produits / Catalogue</div>
          <h5 class="modal-title fw-bold" id="addProductModalLabel">Ajouter un produit</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>

      <form method="POST"
            action="{{ route('products.store') }}"
            id="productForm"
            enctype="multipart/form-data">

        @csrf

        <input type="hidden" name="stock_minimum" value="0">

        <div class="modal-body">

          <div class="row g-4">

            <!-- COLONNE GAUCHE -->

            <div class="col-lg-8">

              <!-- TYPE PRODUIT -->

              <div class="card mb-4">
                <div class="card-header">Type de produit</div>
                <div class="card-body">
                  <div class="row g-3">

                    <div class="col-md-6">
                      <div class="product-type">
                        <input type="radio" name="type" id="typeVehicle" value="vehicule" checked>
                        <label for="typeVehicle" id="vehicleTypeCard" class="product-type-card active">
                          <div class="type-icon"><i class="bi bi-car-front-fill"></i></div>
                          <div>
                            <div class="type-title">Véhicule</div>
                            <p class="type-description">Voiture, moto, camion, utilitaire...</p>
                          </div>
                        </label>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="product-type">
                        <input type="radio" name="type" id="typePiece" value="piece">
                        <label for="typePiece" id="pieceTypeCard" class="product-type-card">
                          <div class="type-icon"><i class="bi bi-gear-wide-connected"></i></div>
                          <div>
                            <div class="type-title">Pièce détachée</div>
                            <p class="type-description">Pièce automobile ou accessoire.</p>
                          </div>
                        </label>
                      </div>
                    </div>

                  </div>
                </div>
              </div>


              <!-- INFORMATIONS GENERALES -->

              <div class="card mb-4">
                <div class="card-header">Informations générales</div>
                <div class="card-body">
                  <div class="row g-3">

                    <div class="col-md-8">
                      <label class="form-label">Nom du produit <span class="required">*</span></label>
                      <input type="text" class="form-control" name="name" id="productName"
                             placeholder="Ex : Toyota Corolla 2022" required>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label">Référence <span class="required">*</span></label>
                      <input type="text" class="form-control" name="reference" id="productReference"
                             placeholder="Ex : PRD-00025" required>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Marque <span class="required">*</span></label>
                      <select class="form-select" name="brand" id="brand" required>
                        <option value="">Sélectionner une marque</option>
                        <option value="Toyota">Toyota</option>
                        <option value="Hyundai">Hyundai</option>
                        <option value="Mercedes-Benz">Mercedes-Benz</option>
                        <option value="Peugeot">Peugeot</option>
                        <option value="Renault">Renault</option>
                        <option value="Honda">Honda</option>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Catégorie <span class="required">*</span></label>
                      <select class="form-select" name="category" id="category" required>
                        <option value="">Sélectionner une catégorie</option>
                        <option value="Berline">Berline</option>
                        <option value="SUV">SUV</option>
                        <option value="Utilitaire">Utilitaire</option>
                        <option value="Moto">Moto</option>
                        <option value="Moteur">Moteur</option>
                        <option value="Freinage">Freinage</option>
                        <option value="Électricité">Électricité</option>
                      </select>
                    </div>

                    <div class="col-12">
                      <label class="form-label">Description</label>
                      <textarea class="form-control" name="description" id="description"
                                placeholder="Décrivez brièvement le produit..."></textarea>
                    </div>

                  </div>
                </div>
              </div>


              <!-- VEHICULE -->

              <div id="vehicleSection" class="dynamic-section show">
                <div class="card mb-4">

                  <div class="card-header">
                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-car-front text-primary"></i>
                      <span>Informations du véhicule</span>
                    </div>
                  </div>

                  <div class="card-body">
                    <div class="row g-3">

                      <div class="col-md-6">
                        <label class="form-label">Modèle</label>
                        <input type="text" class="form-control" name="vehicle_model" placeholder="Ex : Corolla">
                      </div>

                      <div class="col-md-3">
                        <label class="form-label">Année</label>
                        <select class="form-select" name="vehicle_year">
                          <option value="">Année</option>
                          @for($year = date('Y'); $year >= 1980; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                          @endfor
                        </select>
                      </div>

                      <div class="col-md-3">
                        <label class="form-label">Carburant</label>
                        <select class="form-select" name="fuel">
                          <option value="">Sélectionner</option>
                          <option value="essence">Essence</option>
                          <option value="diesel">Diesel</option>
                          <option value="hybride">Hybride</option>
                          <option value="electrique">Électrique</option>
                        </select>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Transmission</label>
                        <select class="form-select" name="transmission">
                          <option value="">Sélectionner</option>
                          <option value="manuelle">Manuelle</option>
                          <option value="automatique">Automatique</option>
                          <option value="cvt">CVT</option>
                        </select>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Kilométrage</label>
                        <div class="input-group">
                          <input type="number" class="form-control" name="mileage" min="0" placeholder="0">
                          <span class="input-group-text">km</span>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <label class="form-label">Nombre de portes</label>
                        <select class="form-select" name="doors">
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4" selected>4</option>
                          <option value="5">5</option>
                        </select>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Couleur</label>
                        <input type="text" class="form-control" name="color" placeholder="Ex : Noir">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">État</label>
                        <select class="form-select" name="condition">
                          <option value="neuf">Neuf</option>
                          <option value="occasion">Occasion</option>
                          <option value="reconditionne">Reconditionné</option>
                        </select>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Disponibilité</label>
                        <select class="form-select" name="availability">
                          <option value="disponible">Disponible</option>
                          <option value="reserve">Réservé</option>
                          <option value="vendu">Vendu</option>
                        </select>
                      </div>

                    </div>
                  </div>

                </div>
              </div>


              <!-- PIECE -->

              <div id="pieceSection" class="dynamic-section">
                <div class="card mb-4">

                  <div class="card-header">
                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-gear-wide-connected text-primary"></i>
                      <span>Informations de la pièce</span>
                    </div>
                  </div>

                  <div class="card-body">
                    <div class="row g-3">

                      <div class="col-md-6">
                        <label class="form-label">Référence fabricant</label>
                        <input type="text" class="form-control" name="manufacturer_reference"
                               placeholder="Ex : BOSCH-0986...">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Catégorie de pièce</label>
                        <select class="form-select" name="piece_category">
                          <option value="">Sélectionner</option>
                          <option value="moteur">Moteur</option>
                          <option value="freinage">Freinage</option>
                          <option value="suspension">Suspension</option>
                          <option value="electricite">Électricité</option>
                          <option value="carrosserie">Carrosserie</option>
                          <option value="filtration">Filtration</option>
                          <option value="eclairage">Éclairage</option>
                          <option value="accessoires">Accessoires</option>
                        </select>
                      </div>

                      <div class="col-12">
                        <label class="form-label">Compatibilité</label>
                        <textarea class="form-control" name="compatibility"
                                  placeholder="Ex : Toyota Corolla 2018-2022, moteur 1.8..."></textarea>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Marque de la pièce</label>
                        <input type="text" class="form-control" name="piece_brand" placeholder="Ex : Bosch">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">État</label>
                        <select class="form-select" name="condition_piece">
                          <option value="neuf">Neuf</option>
                          <option value="occasion">Occasion</option>
                          <option value="reconditionne">Reconditionné</option>
                        </select>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Garantie</label>
                        <select class="form-select" name="warranty">
                          <option value="sans">Sans garantie</option>
                          <option value="3_mois">3 mois</option>
                          <option value="6_mois">6 mois</option>
                          <option value="12_mois">12 mois</option>
                          <option value="24_mois">24 mois</option>
                        </select>
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Unité de vente</label>
                        <select class="form-select" name="unit">
                          <option value="piece">Pièce</option>
                          <option value="kit">Kit</option>
                          <option value="lot">Lot</option>
                          <option value="paire">Paire</option>
                        </select>
                      </div>

                    </div>
                  </div>

                </div>
              </div>


              <!-- PHOTOS -->

              <div class="card mb-4">
                <div class="card-header">Photos du produit</div>
                <div class="card-body">

                  <label class="upload-zone w-100" for="productImages">
                    <div class="upload-icon mb-2"><i class="bi bi-cloud-arrow-up"></i></div>
                    <div class="fw-semibold" id="photoUploadTitle">Ajouter des photos</div>
                    <div class="text-muted small mt-1">Vous pouvez sélectionner plusieurs images</div>
                    <div class="text-muted small">JPG, PNG ou WEBP — 5 Mo maximum par image</div>
                  </label>

                  <input type="file" id="productImages" name="images[]" class="d-none" multiple
                         accept="image/jpeg,image/png,image/webp">

                  <div id="imagePreview" class="row g-3 mt-3 d-none"></div>

                </div>
              </div>

            </div>


            <!-- COLONNE DROITE -->

            <div class="col-lg-4">

              <!-- PRIX ET STOCK -->

              <div class="card mb-4">
                <div class="card-header">Prix et stock</div>
                <div class="card-body">

                  <div class="mb-3">
                    <label class="form-label">Prix de vente <span class="required">*</span></label>
                    <div class="input-group">
                      <input type="number" class="form-control" name="selling_price" id="productPrice"
                             min="0" step="1" placeholder="0" required>
                      <span class="input-group-text">FCFA</span>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Prix d'achat unitaire</label>
                    <div class="input-group">
                      <input type="number" class="form-control" name="purchase_price"
                             min="0" step="1" placeholder="0">
                      <span class="input-group-text">FCFA</span>
                    </div>
                  </div>

                  <hr>

                  <div class="stock-box">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <div>
                        <div class="fw-semibold">Gestion du stock</div>
                        <div class="text-muted small">Facultatif pour le moment</div>
                      </div>
                      <i class="bi bi-box-seam fs-4 text-primary"></i>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Quantité initiale</label>
                      <input type="number" class="form-control" name="quantity" id="productQuantity"
                             value="0" min="0">
                    </div>

                    <div>
                      <label class="form-label">Emplacement</label>
                      <select class="form-select" name="location" id="productLocation">
                        <option value="">Aucun emplacement spécifié</option>
                        <option value="boutique_principale">Boutique principale</option>
                      </select>
                      <div class="form-text">
                        Vous pourrez ajouter d'autres magasins ou entrepôts ultérieurement.
                      </div>
                    </div>

                  </div>

                </div>
              </div>


              <!-- PUBLICATION -->

              <div class="card mb-4">
                <div class="card-header">Publication</div>
                <div class="card-body">

                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                      <div class="fw-semibold">Statut</div>
                      <div class="text-muted small">Visibilité du produit</div>
                    </div>
                    <span id="statusBadge" class="status-badge">Actif</span>
                  </div>

                  <select class="form-select" name="status" id="productStatus">
                    <option value="actif">Actif</option>
                    <option value="inactif">Inactif</option>
                    <option value="brouillon">Brouillon</option>
                  </select>

                </div>
              </div>


              <!-- RESUME -->

              <div class="card mb-4">
                <div class="card-header">Résumé</div>
                <div class="card-body">

                  <div class="summary-item">
                    <span class="summary-label">Type</span>
                    <span class="summary-value" id="summaryType">Véhicule</span>
                  </div>

                  <div class="summary-item">
                    <span class="summary-label">Produit</span>
                    <span class="summary-value" id="summaryName">—</span>
                  </div>

                  <div class="summary-item">
                    <span class="summary-label">Référence</span>
                    <span class="summary-value" id="summaryReference">—</span>
                  </div>

                  <div class="summary-item">
                    <span class="summary-label">Prix</span>
                    <span class="summary-value" id="summaryPrice">—</span>
                  </div>

                  <div class="summary-item">
                    <span class="summary-label">Stock</span>
                    <span class="summary-value" id="summaryQuantity">0</span>
                  </div>

                </div>
              </div>

            </div>

          </div>

        </div>


        <!-- FOOTER -->

        <div class="modal-footer">

          <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Annuler</button>

          <button type="button" class="btn btn-outline-primary" id="saveDraftBtn">
            <i class="bi bi-save me-1"></i>
            Enregistrer brouillon
          </button>

          <button type="submit" class="btn btn-primary px-4">
            <i class="bi bi-check-lg me-1"></i>
            Créer le produit
          </button>

        </div>

      </form>

    </div>

  </div>

</div>


<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function(){

  const $ = id => document.getElementById(id);


  /* =========================================================
     ALERTES
  ========================================================= */

  setTimeout(function(){
    ['success-alert','error-alert'].forEach(function(id){
      const element = $(id);
      if(element){ element.remove(); }
    });
  }, 3000);


  /* =========================================================
     DONNEES + OUTILS (fiche détail)
  ========================================================= */

  const LABELS   = @json($labels);
  const PRODUCTS = {};

  @json($productsData).forEach(function(p){ PRODUCTS[p.id] = p; });

  const nf = new Intl.NumberFormat('fr-FR');

  function esc(value){
    return String(value ?? '')
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function money(value){
    return (value === null || value === undefined || value === '' || Number(value) <= 0)
      ? '—'
      : nf.format(Number(value)) + ' <small>FCFA</small>';
  }

  function label(group, key){
    return (LABELS[group] && LABELS[group][key]) || key || '—';
  }

  function line(k, v){
    const empty = (v === null || v === undefined || v === '');
    return '<div class="detail-line"><span class="k">' + esc(k) + '</span>' +
           '<span class="v">' + (empty ? '—' : v) + '</span></div>';
  }

  function block(title, content){
    return '<div class="detail-block"><div class="detail-block-title">' +
           esc(title) + '</div>' + content + '</div>';
  }


  /* =========================================================
     FICHE DETAIL D'UN PRODUIT
  ========================================================= */

  const detailModalEl = $('detailModal');
  const detailModal   = detailModalEl ? bootstrap.Modal.getOrCreateInstance(detailModalEl) : null;

  function renderGallery(p){

    const gallery = $('detailGallery');
    const thumbs  = $('detailThumbs');

    gallery.innerHTML = '';
    thumbs.innerHTML  = '';

    if(!p.images.length){
      gallery.innerHTML =
        '<div class="product-card-placeholder"><i class="fa-solid ' +
        (p.type === 'vehicule' ? 'fa-car' : 'fa-gears') + '"></i></div>';
      return;
    }

    const main = document.createElement('img');
    main.src = p.images[0];
    main.alt = p.name;
    gallery.appendChild(main);

    if(p.images.length < 2){ return; }

    p.images.forEach(function(src, index){

      const thumb = document.createElement('img');
      thumb.src = src;
      thumb.alt = p.name + ' ' + (index + 1);
      thumb.className = 'detail-thumb' + (index === 0 ? ' active' : '');

      thumb.addEventListener('click', function(){
        main.src = src;
        thumbs.querySelectorAll('.detail-thumb').forEach(function(t){
          t.classList.remove('active');
        });
        thumb.classList.add('active');
      });

      thumbs.appendChild(thumb);
    });
  }

  function renderInfo(p){

    const isVehicle = p.type === 'vehicule';

    const margin = (p.purchase_price !== null && p.purchase_price > 0)
      ? p.selling_price - p.purchase_price
      : null;

    const marginPct = (margin !== null)
      ? (margin / p.purchase_price * 100)
      : null;

    let html = '';

    /* ----- Prix ----- */

    html += block('Prix',
      '<div class="detail-price-grid">' +
        '<div class="price-box"><div class="price-label">Prix d\'achat unitaire</div>' +
          '<div class="price-value">' + money(p.purchase_price) + '</div></div>' +
        '<div class="price-box sell"><div class="price-label">Prix de vente</div>' +
          '<div class="price-value">' + money(p.selling_price) + '</div></div>' +
        '<div class="price-box"><div class="price-label">Marge unitaire</div>' +
          '<div class="price-value" style="color:' +
            (margin !== null && margin < 0 ? '#DC2626' : '#16A34A') + '">' +
            (margin !== null
              ? nf.format(margin) + ' <small>FCFA (' + marginPct.toFixed(1).replace('.', ',') + ' %)</small>'
              : '—') +
          '</div></div>' +
      '</div>'
    );

    /* ----- Informations générales ----- */

    html += block('Informations générales',
      line('Type', isVehicle ? 'Véhicule' : 'Pièce détachée') +
      line('Marque', esc(p.brand || p.piece_brand)) +
      line('Catégorie', esc(p.category)) +
      line('Statut', esc(label('status', p.status)))
    );

    /* ----- Spécificités ----- */

    if(isVehicle){

      html += block('Caractéristiques du véhicule',
        line('Modèle', esc(p.vehicle_model)) +
        line('Année', esc(p.vehicle_year)) +
        line('Carburant', esc(label('fuel', p.fuel))) +
        line('Transmission', esc(label('transmission', p.transmission))) +
        line('Kilométrage', p.mileage !== null && p.mileage !== undefined
          ? nf.format(p.mileage) + ' km' : null) +
        line('Nombre de portes', esc(p.doors)) +
        line('Couleur', esc(p.color)) +
        line('État', esc(label('condition', p.condition))) +
        line('Disponibilité', esc(label('availability', p.availability)))
      );

    } else {

      html += block('Caractéristiques de la pièce',
        line('Référence fabricant', esc(p.manufacturer_reference)) +
        line('Catégorie de pièce', esc(label('pieceCategory', p.piece_category))) +
        line('Marque de la pièce', esc(p.piece_brand)) +
        line('État', esc(label('condition', p.condition_piece))) +
        line('Garantie', esc(label('warranty', p.warranty))) +
        line('Unité de vente', esc(label('unit', p.unit))) +
        line('Compatibilité', esc(p.compatibility))
      );
    }

    /* ----- Stock ----- */

    html += block('Stock',
      line('Quantité en stock', '<strong>' + esc(p.quantity) + '</strong>') +
      line('Seuil minimum', esc(p.stock_minimum)) +
      line('Emplacement', esc(label('location', p.location)))
    );

    /* ----- Description ----- */

    if(p.description){
      html += block('Description',
        '<p class="mb-0" style="white-space:pre-line;">' + esc(p.description) + '</p>'
      );
    }

    $('detailInfo').innerHTML = html;
  }

  document.querySelectorAll('.btn-view-details').forEach(function(button){

    button.addEventListener('click', function(){

      const product = PRODUCTS[this.dataset.id];

      if(!product || !detailModal){ return; }

      $('detailRef').textContent        = product.reference;
      $('detailModalLabel').textContent = product.name;

      renderGallery(product);
      renderInfo(product);

      detailModal.show();
    });

  });


  /* =========================================================
     ELEMENTS FORMULAIRE
  ========================================================= */

  const modal = $('addProductModal');
  const form  = $('productForm');

  const typeVehicle = $('typeVehicle');
  const typePiece   = $('typePiece');

  const vehicleCard = $('vehicleTypeCard');
  const pieceCard   = $('pieceTypeCard');

  const vehicleSection = $('vehicleSection');
  const pieceSection   = $('pieceSection');

  const summaryType      = $('summaryType');
  const summaryName      = $('summaryName');
  const summaryReference = $('summaryReference');
  const summaryPrice     = $('summaryPrice');
  const summaryQuantity  = $('summaryQuantity');

  const productName      = $('productName');
  const productReference = $('productReference');
  const productPrice     = $('productPrice');
  const productQuantity  = $('productQuantity');

  const productStatus = $('productStatus');
  const statusBadge   = $('statusBadge');


  /* =========================================================
     TYPE PRODUIT
  ========================================================= */

  function toggleSection(section, show){

    if(!section){ return; }

    section.classList.toggle('show', show);

    section
      .querySelectorAll('input, select, textarea')
      .forEach(function(element){
        element.disabled = !show;
      });
  }

  function changeProductType(type){

    const isVehicle = type === 'vehicule';

    if(typeVehicle){ typeVehicle.checked = isVehicle; }
    if(typePiece){ typePiece.checked = !isVehicle; }

    if(vehicleCard){ vehicleCard.classList.toggle('active', isVehicle); }
    if(pieceCard){ pieceCard.classList.toggle('active', !isVehicle); }

    toggleSection(vehicleSection, isVehicle);
    toggleSection(pieceSection, !isVehicle);

    if(summaryType){
      summaryType.textContent = isVehicle ? 'Véhicule' : 'Pièce détachée';
    }
  }

  vehicleCard?.addEventListener('click', function(event){
    event.preventDefault();
    changeProductType('vehicule');
  });

  pieceCard?.addEventListener('click', function(event){
    event.preventDefault();
    changeProductType('piece');
  });

  typeVehicle?.addEventListener('change', function(){
    if(this.checked){ changeProductType('vehicule'); }
  });

  typePiece?.addEventListener('change', function(){
    if(this.checked){ changeProductType('piece'); }
  });


  /* =========================================================
     RESUME
  ========================================================= */

  productName?.addEventListener('input', function(){
    summaryName.textContent = this.value.trim() || '—';
  });

  productReference?.addEventListener('input', function(){
    summaryReference.textContent = this.value.trim() || '—';
  });

  productPrice?.addEventListener('input', function(){
    summaryPrice.textContent =
      this.value === ''
        ? '—'
        : new Intl.NumberFormat('fr-FR').format(Number(this.value)) + ' FCFA';
  });

  productQuantity?.addEventListener('input', function(){
    summaryQuantity.textContent = this.value !== '' ? this.value : '0';
  });


  /* =========================================================
     STATUT
  ========================================================= */

  function updateStatusBadge(){

    if(!productStatus || !statusBadge){ return; }

    const styles = {
      actif:     ['Actif',     '#e9f7ef', '#198754'],
      inactif:   ['Inactif',   '#fcebea', '#dc3545'],
      brouillon: ['Brouillon', '#fff3cd', '#997404']
    };

    const selected = styles[productStatus.value] || styles.actif;

    statusBadge.textContent           = selected[0];
    statusBadge.style.backgroundColor = selected[1];
    statusBadge.style.color           = selected[2];
  }

  productStatus?.addEventListener('change', updateStatusBadge);


  /* =========================================================
     BROUILLON
  ========================================================= */

  $('saveDraftBtn')?.addEventListener('click', function(){

    if(!productStatus || !form){ return; }

    productStatus.value = 'brouillon';

    updateStatusBadge();

    if(form.reportValidity()){
      form.submit();
    }
  });


  /* =========================================================
     PHOTOS
  ========================================================= */

  const productImages    = $('productImages');
  const imagePreview     = $('imagePreview');
  const photoUploadTitle = $('photoUploadTitle');

  let selectedImages = [];

  function formatFileSize(bytes){

    if(bytes < 1024){ return bytes + ' octets'; }

    if(bytes < 1024 * 1024){
      return (bytes / 1024).toFixed(1) + ' Ko';
    }

    return (bytes / (1024 * 1024)).toFixed(1) + ' Mo';
  }

  function updatePhotoTitle(){

    if(!photoUploadTitle){ return; }

    const count = selectedImages.length;

    if(count === 0){
      photoUploadTitle.textContent = 'Ajouter des photos';
    } else if(count === 1){
      photoUploadTitle.textContent = '1 photo sélectionnée';
    } else {
      photoUploadTitle.textContent = count + ' photos sélectionnées';
    }
  }

  function rebuildFileInput(){

    if(!productImages){ return; }

    const dataTransfer = new DataTransfer();

    selectedImages.forEach(function(file){
      dataTransfer.items.add(file);
    });

    productImages.files = dataTransfer.files;
  }

  function updateImagePreview(){

    if(!imagePreview){ return; }

    imagePreview.innerHTML = '';

    if(selectedImages.length === 0){
      imagePreview.classList.add('d-none');
      updatePhotoTitle();
      return;
    }

    imagePreview.classList.remove('d-none');

    selectedImages.forEach(function(file, index){

      const col = document.createElement('div');
      col.className = 'col-6 col-md-4 col-lg-3 image-preview-item';

      const card = document.createElement('div');
      card.className = 'image-preview-card';

      const image = document.createElement('img');
      image.alt = file.name;

      const reader = new FileReader();
      reader.onload = function(event){ image.src = event.target.result; };
      reader.readAsDataURL(file);

      const removeButton = document.createElement('button');
      removeButton.type = 'button';
      removeButton.className = 'image-preview-remove';
      removeButton.innerHTML = '<i class="bi bi-x-lg"></i>';
      removeButton.title = 'Supprimer cette image';

      removeButton.addEventListener('click', function(){
        selectedImages.splice(index, 1);
        rebuildFileInput();
        updateImagePreview();
      });

      const name = document.createElement('div');
      name.className = 'image-preview-name';
      name.textContent = file.name;

      const size = document.createElement('div');
      size.className = 'image-preview-size';
      size.textContent = formatFileSize(file.size);

      card.appendChild(image);
      card.appendChild(removeButton);
      card.appendChild(name);
      card.appendChild(size);

      col.appendChild(card);
      imagePreview.appendChild(col);
    });

    updatePhotoTitle();
  }

  productImages?.addEventListener('change', function(){

    const files = Array.from(this.files);

    files.forEach(function(file){

      const alreadyExists = selectedImages.some(function(existingFile){
        return (
          existingFile.name === file.name &&
          existingFile.size === file.size &&
          existingFile.lastModified === file.lastModified
        );
      });

      if(alreadyExists){ return; }

      if(file.size > 5 * 1024 * 1024){
        alert('L’image "' + file.name + '" dépasse la taille maximale de 5 Mo.');
        return;
      }

      const validTypes = ['image/jpeg', 'image/png', 'image/webp'];

      if(!validTypes.includes(file.type)){
        alert('Le fichier "' + file.name + '" n’est pas une image JPG, PNG ou WEBP valide.');
        return;
      }

      selectedImages.push(file);
    });

    rebuildFileInput();
    updateImagePreview();
  });


  /* =========================================================
     MODAL AJOUT
  ========================================================= */

  function scrollModalTop(){

    if(!modal){ return; }

    const body = modal.querySelector('.modal-body');

    if(body){ body.scrollTop = 0; }
  }

  modal?.addEventListener('shown.bs.modal', scrollModalTop);

  modal?.addEventListener('hidden.bs.modal', function(){

    if(form){ form.reset(); }

    selectedImages = [];

    if(productImages){ productImages.value = ''; }

    changeProductType('vehicule');

    if(summaryName){ summaryName.textContent = '—'; }
    if(summaryReference){ summaryReference.textContent = '—'; }
    if(summaryPrice){ summaryPrice.textContent = '—'; }
    if(summaryQuantity){ summaryQuantity.textContent = '0'; }

    updateImagePreview();
    updateStatusBadge();
    scrollModalTop();
  });


  /* =========================================================
     RECHERCHE + FILTRES (cartes)
  ========================================================= */

  const searchInput  = $('searchProduct');
  const filterType   = $('filterType');
  const filterStatus = $('filterStatus');
  const noResults    = $('noResults');

  const cards = document.querySelectorAll('#productsGrid .product-col');

  function filterProducts(){

    const search = (searchInput?.value || '').toLowerCase().trim();
    const type   = (filterType?.value || '').toLowerCase();
    const status = (filterStatus?.value || '').toLowerCase();

    let visibleCount = 0;

    cards.forEach(function(card){

      const matchesSearch = (card.dataset.search || '').includes(search);
      const matchesType   = !type || (card.dataset.type || '').toLowerCase() === type;
      const matchesStatus = !status || (card.dataset.status || '').toLowerCase() === status;

      const visible = matchesSearch && matchesType && matchesStatus;

      card.classList.toggle('d-none', !visible);

      if(visible){ visibleCount++; }
    });

    if(noResults){
      noResults.classList.toggle('d-none', visibleCount > 0);
    }
  }

  searchInput?.addEventListener('input', filterProducts);
  filterType?.addEventListener('change', filterProducts);
  filterStatus?.addEventListener('change', filterProducts);


  /* =========================================================
     INITIALISATION
  ========================================================= */

  changeProductType('vehicule');
  updateStatusBadge();
  updatePhotoTitle();

});

</script>

</body>

</html>