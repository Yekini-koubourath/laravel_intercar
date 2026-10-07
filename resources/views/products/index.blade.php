<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<meta name="csrf-token"
      content="{{ csrf_token() }}">

<title>Produits - INTERCAR</title>


<!-- =========================================================
     BOOTSTRAP
========================================================= -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">


<!-- =========================================================
     BOOTSTRAP ICONS
========================================================= -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
      rel="stylesheet">


<!-- =========================================================
     FONT AWESOME
========================================================= -->

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


<!-- =========================================================
     GOOGLE FONT
========================================================= -->

<link rel="preconnect"
      href="https://fonts.googleapis.com">

<link rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
      rel="stylesheet">


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
   SIDEBAR
========================================================= */

.sidebar{

  width:250px;

  background:var(--purple-sidebar);

  position:fixed;

  top:0;
  left:0;

  z-index:1000;

  height:100vh;
  height:100dvh;

  overflow-y:auto;

  transition:transform .25s ease;

}


.sidebar-brand{

  padding:1.5rem 1rem 1rem;

}


.sidebar .nav-link{

  color:rgba(255,255,255,.7);

  font-size:.85rem;

  font-weight:500;

  padding:.65rem 1rem;

  border-radius:8px;

  margin-bottom:3px;

  display:flex;

  align-items:center;

  gap:12px;

  transition:all .2s;

}


.sidebar .nav-link:hover{

  color:#fff;

  background:rgba(255,255,255,.08);

}


.sidebar .nav-link.active{

  color:#fff;

  background:var(--orange-active);

  font-weight:600;

}


.sidebar-overlay{

  display:none;

  position:fixed;

  inset:0;

  background:rgba(26,11,46,.55);

  z-index:999;

}


.sidebar-overlay.show{

  display:block;

}


/* =========================================================
   CONTENU PRINCIPAL
========================================================= */

.main-wrapper{

  margin-left:250px;

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
   CARDS
========================================================= */

.card-custom{

  background:#fff;

  border:none;

  border-radius:var(--card-border-radius);

  padding:1.25rem;

  box-shadow:0 2px 8px rgba(0,0,0,.03);

}


/* =========================================================
   TABLE
========================================================= */

.table-custom{

  min-width:1350px;

}


.table-custom th{

  color:#718096;

  font-weight:500;

  font-size:.75rem;

  border-bottom:1px solid #EDF2F7;

  background:#FAFAFA;

  padding:.7rem .75rem;

  white-space:nowrap;

}


.table-custom td{

  padding:.7rem .75rem;

  border-bottom:1px solid #EDF2F7;

  vertical-align:middle;

  font-size:.825rem;

  white-space:nowrap;

}


.table-custom tbody tr:hover{

  background:#faf9fd;

}


/* =========================================================
   PHOTO PRODUIT DANS LE TABLEAU
========================================================= */

.product-table-image{

  width:48px;

  height:48px;

  border-radius:8px;

  object-fit:cover;

  border:1px solid #E2E8F0;

  background:#F8F9FA;

}


.product-table-image-placeholder{

  width:48px;

  height:48px;

  border-radius:8px;

  display:flex;

  align-items:center;

  justify-content:center;

  background:#F4F5F8;

  border:1px solid #E2E8F0;

  color:#A0AEC0;

  flex-shrink:0;

}


.product-table-photo-count{

  font-size:.7rem;

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
   MODAL
========================================================= */

.modal-dialog{

  max-width:1140px;

  margin:.75rem auto;

}


.modal-dialog-scrollable{

  height:calc(100dvh - 1.5rem);

  max-height:none;

}


.modal-dialog-scrollable .modal-content{

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


.modal-header{

  border-bottom:1px solid #E9ECEF;

  padding:1rem 1.25rem;

  background:#fff;

  flex:0 0 auto;

}


.modal-dialog-scrollable .modal-body{

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


.modal-dialog-scrollable .modal-body::-webkit-scrollbar{

  width:8px;

}


.modal-dialog-scrollable .modal-body::-webkit-scrollbar-track{

  background:#F4F5F8;

}


.modal-dialog-scrollable .modal-body::-webkit-scrollbar-thumb{

  background:#C9C0CE;

  border-radius:10px;

}


.modal-dialog-scrollable .modal-body::-webkit-scrollbar-thumb:hover{

  background:var(--purple-main);

}


.modal-footer{

  border-top:1px solid #E9ECEF;

  padding:1rem 1.25rem;

  background:#fff;

  flex:0 0 auto;

  gap:.5rem;

}


/* =========================================================
   FORMULAIRE
========================================================= */

.modal-body .card{

  border:1px solid #e8e9ef;

  border-radius:14px;

  box-shadow:0 2px 8px rgba(0,0,0,.03);

}


.modal-body .card-header{

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


textarea.form-control{

  min-height:110px;

}


.required{

  color:#dc3545;

}


/* =========================================================
   TYPE PRODUIT
========================================================= */

.product-type{

  position:relative;

  height:100%;

}


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


.product-type-card:hover{

  border-color:#b9a4df;

  background:#faf9fd;

}


.product-type-card.active{

  border-color:#6f42c1;

  background:#f8f5ff;

}


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


.product-type-card.active .type-icon{

  background:#6f42c1;

  color:#fff;

}


.type-title{

  font-weight:600;

  margin-bottom:3px;

}


.type-description{

  font-size:.82rem;

  color:#777b87;

  margin:0;

}


/* =========================================================
   SECTIONS DYNAMIQUES
========================================================= */

.dynamic-section{

  display:none;

}


.dynamic-section.show{

  display:block;

  animation:fadeIn .2s ease;

}


@keyframes fadeIn{

  from{

    opacity:0;

    transform:translateY(5px);

  }

  to{

    opacity:1;

    transform:translateY(0);

  }

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


.upload-zone:hover{

  border-color:#6f42c1;

  background:#f8f5ff;

}


.upload-icon{

  font-size:35px;

  color:#6f42c1;

}


/* =========================================================
   PREVISUALISATION PHOTOS
========================================================= */

.image-preview-item{

  position:relative;

}


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


.image-preview-remove:hover{

  background:#b02a37;

}


.image-preview-name{

  font-size:.75rem;

  color:#6c757d;

  margin-top:6px;

  white-space:nowrap;

  overflow:hidden;

  text-overflow:ellipsis;

}


.image-preview-size{

  font-size:.7rem;

  color:#9a9da5;

}


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


.summary-item:last-child{

  border-bottom:0;

}


.summary-label{

  color:#777b87;

}


.summary-value{

  font-weight:600;

  text-align:right;

  word-break:break-word;

}


/* =========================================================
   STOCK
========================================================= */

.stock-box{

  background:#fafafd;

  border:1px solid #e7e8ee;

  border-radius:10px;

  padding:15px;

}


/* =========================================================
   STATUT
========================================================= */

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

.modal-footer .btn,
.modal-body .btn{

  border-radius:9px;

  min-height:42px;

  font-weight:500;

}


.btn-primary{

  background:#6f42c1;

  border-color:#6f42c1;

}


.btn-primary:hover{

  background:#5e35aa;

  border-color:#5e35aa;

}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width:991.98px){

  .sidebar{

    transform:translateX(-100%);

    max-width:85vw;

  }


  .sidebar.open{

    transform:translateX(0);

    box-shadow:8px 0 24px rgba(0,0,0,.25);

  }


  .main-wrapper{

    margin-left:0;

    padding:1rem;

  }


  .modal-dialog{

    max-width:calc(100% - 1rem);

    margin:.5rem auto;

  }


  .modal-dialog-scrollable{

    height:calc(100dvh - 1rem);

  }

}


@media (max-width:575.98px){

  .main-wrapper{

    padding:.75rem;

  }


  .top-bar{

    padding:.5rem .75rem;

  }


  .card-custom{

    padding:1rem;

  }


  .modal-dialog,
  .modal-dialog-scrollable{

    width:100%;

    max-width:none;

    height:100dvh;

    min-height:100dvh;

    max-height:100dvh;

    margin:0;

  }


  .modal-dialog-scrollable .modal-content{

    height:100dvh;

    border-radius:0;

  }


  .modal-dialog-scrollable .modal-body{

    padding:1rem 1rem 2rem;

  }


  .modal-footer{

    flex-wrap:wrap;

  }


  .modal-footer .btn{

    flex:1;

    min-width:130px;

  }

}

</style>

</head>


<body>


<!-- =========================================================
     SIDEBAR
========================================================= -->

@include('auth.partials.sidebar')


<div class="sidebar-overlay"
     id="sidebarOverlay">
</div>


<!-- =========================================================
     CONTENU
========================================================= -->

<main class="main-wrapper">


  <!-- =======================================================
       ALERTES
  ======================================================== -->

  @if(session('success'))

    <div class="alert alert-success"
         id="success-alert">

      {{ session('success') }}

    </div>

  @endif


  @if($errors->any())

    <div class="alert alert-danger"
         id="error-alert">

      <ul class="mb-0">

        @foreach($errors->all() as $error)

          <li>
            {{ $error }}
          </li>

        @endforeach

      </ul>

    </div>

  @endif


  <!-- =======================================================
       TOP BAR
  ======================================================== -->

  <header class="top-bar d-flex align-items-center justify-content-between gap-2 mb-4">


    <button type="button"
            class="btn btn-light border d-lg-none flex-shrink-0"
            id="sidebarToggle"
            aria-label="Ouvrir le menu">

      <i class="fa-solid fa-bars"></i>

    </button>


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

          <div class="fw-semibold lh-1">
            Boutique principale
          </div>

          <div class="text-muted"
               style="font-size:.7rem;">

            Cotonou, Bénin

          </div>

        </div>

        <i class="fa-solid fa-chevron-down text-muted ms-2"
           style="font-size:.7rem;">
        </i>

      </div>


      <button class="btn btn-light rounded-circle p-2 position-relative border"
              type="button"
              aria-label="Notifications">

        <i class="fa-regular fa-bell text-secondary"></i>

        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
        </span>

      </button>


      <div class="d-flex align-items-center gap-2">

        <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold"
             style="width:36px;height:36px;background:var(--purple-sidebar);font-size:.85rem;">

          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

        </div>


        <span class="fw-semibold d-none d-sm-inline"
              style="font-size:.85rem;">

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


  <!-- =======================================================
       TITRE
  ======================================================== -->

  <div class="d-flex align-items-center justify-content-between gap-3 mb-4">


    <div class="d-flex align-items-center gap-3">

      <div class="rounded-3 text-white d-flex align-items-center justify-content-center flex-shrink-0"
           style="background:var(--purple-sidebar);width:42px;height:42px;">

        <i class="fa-solid fa-box fs-5"></i>

      </div>


      <div>

        <h4 class="fw-bold mb-0"
            style="color:#1A202C;">

          Produits

        </h4>


        <p class="text-muted small mb-0">

          Gérez vos véhicules et pièces détachées.

        </p>

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


  <!-- =======================================================
       STATISTIQUES
  ======================================================== -->

  <div class="row g-3 mb-4">


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


  <!-- =======================================================
       TABLE PRODUITS
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

        <select class="form-select"
                id="filterType">

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

        <select class="form-select"
                id="filterStatus">

          <option value="">
            Tous les statuts
          </option>

          <option value="actif">
            Actif
          </option>

          <option value="inactif">
            Inactif
          </option>

          <option value="brouillon">
            Brouillon
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

            <th>
              Photo
            </th>

            <th>
              Référence
            </th>

            <th>
              Produit
            </th>

            <th>
              Marque
            </th>

            <th>
              Type
            </th>

            <th>
              Modèle
            </th>

            <th>
              Année
            </th>

            <th>
              Carburant
            </th>

            <th>
              Transmission
            </th>

            <th>
              Kilométrage
            </th>

            <th>
              Réf. fabricant
            </th>

            <th>
              Catégorie pièce
            </th>

            <th>
              Compatibilité
            </th>

            <th>
              Garantie
            </th>

            <th>
              État
            </th>

            <th>
              Prix
            </th>

            <th>
              Stock
            </th>

            <th>
              Statut
            </th>

            <th class="text-end">
              Actions
            </th>

          </tr>

        </thead>


        <tbody>


          @forelse($products as $product)

            <tr data-type="{{ $product->type }}"
                data-status="{{ $product->status }}">


              <!-- =================================================
                   PHOTO
              ================================================== -->

              <td>

                <div class="d-flex align-items-center gap-2">


                  @if($product->images->count() > 0)

                    @php

                      $firstImage = $product->images
                          ->sortBy('sort_order')
                          ->first();

                    @endphp


                  <img src="{{ route('product.image', ['path' => $firstImage->path]) }}"
     alt="{{ $product->name }}"
     class="product-table-image">


                    @if($product->images->count() > 1)

                      <div class="product-table-photo-count">

                        +{{ $product->images->count() - 1 }}

                      </div>

                    @endif


                  @else

                    <div class="product-table-image-placeholder">

                      <i class="fa-solid fa-image"></i>

                    </div>

                  @endif


                </div>

              </td>


              <!-- =================================================
                   REFERENCE
              ================================================== -->

              <td class="fw-semibold">

                {{ $product->reference }}

              </td>


              <!-- =================================================
                   PRODUIT
              ================================================== -->

              <td>

                <div class="fw-semibold">

                  {{ $product->name }}

                </div>


                @if(!empty($product->description))

                  <div class="text-muted small"
                       style="max-width:220px;overflow:hidden;text-overflow:ellipsis;">

                    {{ $product->description }}

                  </div>

                @endif

              </td>


              <!-- =================================================
                   MARQUE
              ================================================== -->

              <td>

                {{ $product->brand ?: ($product->piece_brand ?? '—') }}

              </td>


              <!-- =================================================
                   TYPE
              ================================================== -->

              <td>

                @if($product->type === 'piece')

                  <span class="badge bg-warning text-dark">

                    <i class="fa-solid fa-gears me-1"></i>

                    Pièce

                  </span>

                @else

                  <span class="badge bg-info text-dark">

                    <i class="fa-solid fa-car me-1"></i>

                    Véhicule

                  </span>

                @endif

              </td>


              <!-- =================================================
                   MODELE
              ================================================== -->

              <td>

                @if($product->type === 'vehicule')

                  {{ $product->vehicle_model ?: '—' }}

                @else

                  —

                @endif

              </td>


              <!-- =================================================
                   ANNEE
              ================================================== -->

              <td>

                @if($product->type === 'vehicule')

                  {{ $product->vehicle_year ?: '—' }}

                @else

                  —

                @endif

              </td>


              <!-- =================================================
                   CARBURANT
              ================================================== -->

              <td>

                @if($product->type === 'vehicule')

                  @switch($product->fuel)

                    @case('essence')

                      Essence

                      @break

                    @case('diesel')

                      Diesel

                      @break

                    @case('hybride')

                      Hybride

                      @break

                    @case('electrique')

                      Électrique

                      @break

                    @default

                      —

                  @endswitch

                @else

                  —

                @endif

              </td>


              <!-- =================================================
                   TRANSMISSION
              ================================================== -->

              <td>

                @if($product->type === 'vehicule')

                  @switch($product->transmission)

                    @case('manuelle')

                      Manuelle

                      @break

                    @case('automatique')

                      Automatique

                      @break

                    @case('cvt')

                      CVT

                      @break

                    @default

                      —

                  @endswitch

                @else

                  —

                @endif

              </td>


              <!-- =================================================
                   KILOMETRAGE
              ================================================== -->

              <td>

                @if($product->type === 'vehicule')

                  @if($product->mileage !== null)

                    {{ number_format($product->mileage, 0, ',', ' ') }}
                    km

                  @else

                    —

                  @endif

                @else

                  —

                @endif

              </td>


              <!-- =================================================
                   REFERENCE FABRICANT
              ================================================== -->

              <td>

                @if($product->type === 'piece')

                  {{ $product->manufacturer_reference ?: '—' }}

                @else

                  —

                @endif

              </td>


              <!-- =================================================
                   CATEGORIE PIECE
              ================================================== -->

              <td>

                @if($product->type === 'piece')

                  {{ $product->piece_category ?: '—' }}

                @else

                  —

                @endif

              </td>


              <!-- =================================================
                   COMPATIBILITE
              ================================================== -->

              <td>

                @if($product->type === 'piece')

                  @if(!empty($product->compatibility))

                    <span title="{{ $product->compatibility }}">

                      {{ \Illuminate\Support\Str::limit($product->compatibility, 35) }}

                    </span>

                  @else

                    —

                  @endif

                @else

                  —

                @endif

              </td>


              <!-- =================================================
                   GARANTIE
              ================================================== -->

              <td>

                @if($product->type === 'piece')

                  @switch($product->warranty)

                    @case('sans')

                      Sans garantie

                      @break

                    @case('3_mois')

                      3 mois

                      @break

                    @case('6_mois')

                      6 mois

                      @break

                    @case('12_mois')

                      12 mois

                      @break

                    @case('24_mois')

                      24 mois

                      @break

                    @default

                      —

                  @endswitch

                @else

                  —

                @endif

              </td>


              <!-- =================================================
                   ETAT
              ================================================== -->

              <td>

                @if($product->type === 'vehicule')

                  @switch($product->condition)

                    @case('neuf')

                      <span class="badge bg-success">
                        Neuf
                      </span>

                      @break

                    @case('occasion')

                      <span class="badge bg-warning text-dark">
                        Occasion
                      </span>

                      @break

                    @case('reconditionne')

                      <span class="badge bg-info text-dark">
                        Reconditionné
                      </span>

                      @break

                    @default

                      —

                  @endswitch


                @elseif($product->type === 'piece')

                  @switch($product->condition_piece)

                    @case('neuf')

                      <span class="badge bg-success">
                        Neuf
                      </span>

                      @break

                    @case('occasion')

                      <span class="badge bg-warning text-dark">
                        Occasion
                      </span>

                      @break

                    @case('reconditionne')

                      <span class="badge bg-info text-dark">
                        Reconditionné
                      </span>

                      @break

                    @default

                      —

                  @endswitch

                @else

                  —

                @endif

              </td>


              <!-- =================================================
                   PRIX
              ================================================== -->

              <td class="fw-semibold">

                {{ number_format($product->selling_price, 0, ',', ' ') }}
                FCFA

              </td>


              <!-- =================================================
                   STOCK
              ================================================== -->

              <td>

                <span class="fw-semibold">

                  {{ $product->quantity }}

                </span>


                @if(
                    $product->type === 'piece'
                    &&
                    $product->quantity <= $product->stock_minimum
                )

                  <span class="badge bg-danger ms-1">

                    Stock faible

                  </span>

                @endif

              </td>


              <!-- =================================================
                   STATUT
              ================================================== -->

              <td>

                @if($product->status === 'actif')

                  <span class="badge bg-success">
                    Actif
                  </span>

                @elseif($product->status === 'brouillon')

                  <span class="badge bg-warning text-dark">
                    Brouillon
                  </span>

                @else

                  <span class="badge bg-secondary">
                    Inactif
                  </span>

                @endif

              </td>


              <!-- =================================================
                   ACTIONS
              ================================================== -->

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

              <td colspan="19"
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


      <!-- =====================================================
           HEADER
      ====================================================== -->

      <div class="modal-header">


        <div>

          <div class="text-muted small mb-1">

            Produits / Catalogue

          </div>


          <h5 class="modal-title fw-bold"
              id="addProductModalLabel">

            Ajouter un produit

          </h5>

        </div>


        <button type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Fermer">

        </button>

      </div>


      <!-- =====================================================
           FORMULAIRE
      ====================================================== -->

      <form method="POST"
            action="{{ route('products.store') }}"
            id="productForm"
            enctype="multipart/form-data">


        @csrf


        <input type="hidden"
               name="stock_minimum"
               value="0">


        <!-- ===================================================
             BODY
        ==================================================== -->

        <div class="modal-body">


          <div class="row g-4">


            <!-- ===============================================
                 COLONNE GAUCHE
            ================================================ -->

            <div class="col-lg-8">


              <!-- =============================================
                   TYPE PRODUIT
              ============================================== -->

              <div class="card mb-4">


                <div class="card-header">

                  Type de produit

                </div>


                <div class="card-body">


                  <div class="row g-3">


                    <!-- VEHICULE -->

                    <div class="col-md-6">

                      <div class="product-type">


                        <input type="radio"
                               name="type"
                               id="typeVehicle"
                               value="vehicule"
                               checked>


                        <label for="typeVehicle"
                               id="vehicleTypeCard"
                               class="product-type-card active">


                          <div class="type-icon">

                            <i class="bi bi-car-front-fill"></i>

                          </div>


                          <div>

                            <div class="type-title">

                              Véhicule

                            </div>


                            <p class="type-description">

                              Voiture, moto, camion, utilitaire...

                            </p>

                          </div>


                        </label>

                      </div>

                    </div>


                    <!-- PIECE -->

                    <div class="col-md-6">

                      <div class="product-type">


                        <input type="radio"
                               name="type"
                               id="typePiece"
                               value="piece">


                        <label for="typePiece"
                               id="pieceTypeCard"
                               class="product-type-card">


                          <div class="type-icon">

                            <i class="bi bi-gear-wide-connected"></i>

                          </div>


                          <div>

                            <div class="type-title">

                              Pièce détachée

                            </div>


                            <p class="type-description">

                              Pièce automobile ou accessoire.

                            </p>

                          </div>


                        </label>

                      </div>

                    </div>


                  </div>

                </div>

              </div>


              <!-- =============================================
                   INFORMATIONS GENERALES
              ============================================== -->

              <div class="card mb-4">


                <div class="card-header">

                  Informations générales

                </div>


                <div class="card-body">


                  <div class="row g-3">


                    <div class="col-md-8">

                      <label class="form-label">

                        Nom du produit

                        <span class="required">*</span>

                      </label>


                      <input type="text"
                             class="form-control"
                             name="name"
                             id="productName"
                             placeholder="Ex : Toyota Corolla 2022"
                             required>

                    </div>


                    <div class="col-md-4">

                      <label class="form-label">

                        Référence

                        <span class="required">*</span>

                      </label>


                      <input type="text"
                             class="form-control"
                             name="reference"
                             id="productReference"
                             placeholder="Ex : PRD-00025"
                             required>

                    </div>


                    <div class="col-md-6">

                      <label class="form-label">

                        Marque

                        <span class="required">*</span>

                      </label>


                      <select class="form-select"
                              name="brand"
                              id="brand"
                              required>


                        <option value="">

                          Sélectionner une marque

                        </option>


                        <option value="Toyota">
                          Toyota
                        </option>

                        <option value="Hyundai">
                          Hyundai
                        </option>

                        <option value="Mercedes-Benz">
                          Mercedes-Benz
                        </option>

                        <option value="Peugeot">
                          Peugeot
                        </option>

                        <option value="Renault">
                          Renault
                        </option>

                        <option value="Honda">
                          Honda
                        </option>


                      </select>

                    </div>


                    <div class="col-md-6">

                      <label class="form-label">

                        Catégorie

                        <span class="required">*</span>

                      </label>


                      <select class="form-select"
                              name="category"
                              id="category"
                              required>


                        <option value="">

                          Sélectionner une catégorie

                        </option>


                        <option value="Berline">
                          Berline
                        </option>

                        <option value="SUV">
                          SUV
                        </option>

                        <option value="Utilitaire">
                          Utilitaire
                        </option>

                        <option value="Moto">
                          Moto
                        </option>

                        <option value="Moteur">
                          Moteur
                        </option>

                        <option value="Freinage">
                          Freinage
                        </option>

                        <option value="Électricité">
                          Électricité
                        </option>


                      </select>

                    </div>


                    <div class="col-12">

                      <label class="form-label">

                        Description

                      </label>


                      <textarea class="form-control"
                                name="description"
                                id="description"
                                placeholder="Décrivez brièvement le produit..."></textarea>

                    </div>


                  </div>

                </div>

              </div>


              <!-- =============================================
                   VEHICULE
              ============================================== -->

              <div id="vehicleSection"
                   class="dynamic-section show">


                <div class="card mb-4">


                  <div class="card-header">

                    <div class="d-flex align-items-center gap-2">

                      <i class="bi bi-car-front text-primary"></i>

                      <span>

                        Informations du véhicule

                      </span>

                    </div>

                  </div>


                  <div class="card-body">


                    <div class="row g-3">


                      <div class="col-md-6">

                        <label class="form-label">

                          Modèle

                        </label>


                        <input type="text"
                               class="form-control"
                               name="vehicle_model"
                               placeholder="Ex : Corolla">

                      </div>


                      <div class="col-md-3">

                        <label class="form-label">

                          Année

                        </label>


                        <select class="form-select"
                                name="vehicle_year">


                          <option value="">

                            Année

                          </option>


                          @for($year = date('Y'); $year >= 1980; $year--)

                            <option value="{{ $year }}">

                              {{ $year }}

                            </option>

                          @endfor


                        </select>

                      </div>


                      <div class="col-md-3">

                        <label class="form-label">

                          Carburant

                        </label>


                        <select class="form-select"
                                name="fuel">


                          <option value="">

                            Sélectionner

                          </option>


                          <option value="essence">

                            Essence

                          </option>


                          <option value="diesel">

                            Diesel

                          </option>


                          <option value="hybride">

                            Hybride

                          </option>


                          <option value="electrique">

                            Électrique

                          </option>


                        </select>

                      </div>


                      <div class="col-md-4">

                        <label class="form-label">

                          Transmission

                        </label>


                        <select class="form-select"
                                name="transmission">


                          <option value="">

                            Sélectionner

                          </option>


                          <option value="manuelle">

                            Manuelle

                          </option>


                          <option value="automatique">

                            Automatique

                          </option>


                          <option value="cvt">

                            CVT

                          </option>


                        </select>

                      </div>


                      <div class="col-md-4">

                        <label class="form-label">

                          Kilométrage

                        </label>


                        <div class="input-group">


                          <input type="number"
                                 class="form-control"
                                 name="mileage"
                                 min="0"
                                 placeholder="0">


                          <span class="input-group-text">

                            km

                          </span>


                        </div>

                      </div>


                      <div class="col-md-4">

                        <label class="form-label">

                          Nombre de portes

                        </label>


                        <select class="form-select"
                                name="doors">


                          <option value="2">
                            2
                          </option>

                          <option value="3">
                            3
                          </option>

                          <option value="4"
                                  selected>
                            4
                          </option>

                          <option value="5">
                            5
                          </option>


                        </select>

                      </div>


                      <div class="col-md-6">

                        <label class="form-label">

                          Couleur

                        </label>


                        <input type="text"
                               class="form-control"
                               name="color"
                               placeholder="Ex : Noir">

                      </div>


                      <div class="col-md-6">

                        <label class="form-label">

                          État

                        </label>


                        <select class="form-select"
                                name="condition">


                          <option value="neuf">

                            Neuf

                          </option>


                          <option value="occasion">

                            Occasion

                          </option>


                          <option value="reconditionne">

                            Reconditionné

                          </option>


                        </select>

                      </div>


                      <div class="col-md-6">

                        <label class="form-label">

                          Disponibilité

                        </label>


                        <select class="form-select"
                                name="availability">


                          <option value="disponible">

                            Disponible

                          </option>


                          <option value="reserve">

                            Réservé

                          </option>


                          <option value="vendu">

                            Vendu

                          </option>


                        </select>

                      </div>


                    </div>

                  </div>

                </div>

              </div>


              <!-- =============================================
                   PIECE
              ============================================== -->

              <div id="pieceSection"
                   class="dynamic-section">


                <div class="card mb-4">


                  <div class="card-header">


                    <div class="d-flex align-items-center gap-2">

                      <i class="bi bi-gear-wide-connected text-primary"></i>

                      <span>

                        Informations de la pièce

                      </span>

                    </div>


                  </div>


                  <div class="card-body">


                    <div class="row g-3">


                      <div class="col-md-6">

                        <label class="form-label">

                          Référence fabricant

                        </label>


                        <input type="text"
                               class="form-control"
                               name="manufacturer_reference"
                               placeholder="Ex : BOSCH-0986...">

                      </div>


                      <div class="col-md-6">

                        <label class="form-label">

                          Catégorie de pièce

                        </label>


                        <select class="form-select"
                                name="piece_category">


                          <option value="">

                            Sélectionner

                          </option>


                          <option value="moteur">

                            Moteur

                          </option>


                          <option value="freinage">

                            Freinage

                          </option>


                          <option value="suspension">

                            Suspension

                          </option>


                          <option value="electricite">

                            Électricité

                          </option>


                          <option value="carrosserie">

                            Carrosserie

                          </option>


                          <option value="filtration">

                            Filtration

                          </option>


                          <option value="eclairage">

                            Éclairage

                          </option>


                          <option value="accessoires">

                            Accessoires

                          </option>


                        </select>

                      </div>


                      <div class="col-12">

                        <label class="form-label">

                          Compatibilité

                        </label>


                        <textarea class="form-control"
                                  name="compatibility"
                                  placeholder="Ex : Toyota Corolla 2018-2022, moteur 1.8..."></textarea>

                      </div>


                      <div class="col-md-6">

                        <label class="form-label">

                          Marque de la pièce

                        </label>


                        <input type="text"
                               class="form-control"
                               name="piece_brand"
                               placeholder="Ex : Bosch">

                      </div>


                      <div class="col-md-6">

                        <label class="form-label">

                          État

                        </label>


                        <select class="form-select"
                                name="condition_piece">


                          <option value="neuf">

                            Neuf

                          </option>


                          <option value="occasion">

                            Occasion

                          </option>


                          <option value="reconditionne">

                            Reconditionné

                          </option>


                        </select>

                      </div>


                      <div class="col-md-6">

                        <label class="form-label">

                          Garantie

                        </label>


                        <select class="form-select"
                                name="warranty">


                          <option value="sans">

                            Sans garantie

                          </option>


                          <option value="3_mois">

                            3 mois

                          </option>


                          <option value="6_mois">

                            6 mois

                          </option>


                          <option value="12_mois">

                            12 mois

                          </option>


                          <option value="24_mois">

                            24 mois

                          </option>


                        </select>

                      </div>


                      <div class="col-md-6">

                        <label class="form-label">

                          Unité de vente

                        </label>


                        <select class="form-select"
                                name="unit">


                          <option value="piece">

                            Pièce

                          </option>


                          <option value="kit">

                            Kit

                          </option>


                          <option value="lot">

                            Lot

                          </option>


                          <option value="paire">

                            Paire

                          </option>


                        </select>

                      </div>


                    </div>

                  </div>

                </div>

              </div>


              <!-- =============================================
                   PHOTOS
              ============================================== -->

              <div class="card mb-4">


                <div class="card-header">

                  Photos du produit

                </div>


                <div class="card-body">


                  <label class="upload-zone w-100"
                         for="productImages">


                    <div class="upload-icon mb-2">

                      <i class="bi bi-cloud-arrow-up"></i>

                    </div>


                    <div class="fw-semibold"
                         id="photoUploadTitle">

                      Ajouter des photos

                    </div>


                    <div class="text-muted small mt-1">

                      Vous pouvez sélectionner plusieurs images

                    </div>


                    <div class="text-muted small">

                      JPG, PNG ou WEBP — 5 Mo maximum par image

                    </div>


                  </label>


                  <input type="file"
                         id="productImages"
                         name="images[]"
                         class="d-none"
                         multiple
                         accept="image/jpeg,image/png,image/webp">


                  <div id="imagePreview"
                       class="row g-3 mt-3 d-none">
                  </div>


                </div>

              </div>


            </div>


            <!-- ===============================================
                 COLONNE DROITE
            ================================================ -->

            <div class="col-lg-4">


              <!-- =============================================
                   PRIX ET STOCK
              ============================================== -->

              <div class="card mb-4">


                <div class="card-header">

                  Prix et stock

                </div>


                <div class="card-body">


                  <div class="mb-3">


                    <label class="form-label">

                      Prix de vente

                      <span class="required">*</span>

                    </label>


                    <div class="input-group">


                      <input type="number"
                             class="form-control"
                             name="selling_price"
                             id="productPrice"
                             min="0"
                             step="1"
                             placeholder="0"
                             required>


                      <span class="input-group-text">

                        FCFA

                      </span>


                    </div>

                  </div>


                  <div class="mb-3">


                    <label class="form-label">

                      Prix d'achat

                    </label>


                    <div class="input-group">


                      <input type="number"
                             class="form-control"
                             name="purchase_price"
                             min="0"
                             step="1"
                             placeholder="0">


                      <span class="input-group-text">

                        FCFA

                      </span>


                    </div>

                  </div>


                  <hr>


                  <div class="stock-box">


                    <div class="d-flex justify-content-between align-items-center mb-3">


                      <div>


                        <div class="fw-semibold">

                          Gestion du stock

                        </div>


                        <div class="text-muted small">

                          Facultatif pour le moment

                        </div>

                      </div>


                      <i class="bi bi-box-seam fs-4 text-primary"></i>


                    </div>


                    <div class="mb-3">


                      <label class="form-label">

                        Quantité initiale

                      </label>


                      <input type="number"
                             class="form-control"
                             name="quantity"
                             id="productQuantity"
                             value="0"
                             min="0">

                    </div>


                    <div>


                      <label class="form-label">

                        Emplacement

                      </label>


                      <select class="form-select"
                              name="location"
                              id="productLocation">


                        <option value="">

                          Aucun emplacement spécifié

                        </option>


                        <option value="boutique_principale">

                          Boutique principale

                        </option>


                      </select>


                      <div class="form-text">

                        Vous pourrez ajouter d'autres magasins ou entrepôts ultérieurement.

                      </div>

                    </div>


                  </div>

                </div>

              </div>


              <!-- =============================================
                   PUBLICATION
              ============================================== -->

              <div class="card mb-4">


                <div class="card-header">

                  Publication

                </div>


                <div class="card-body">


                  <div class="d-flex justify-content-between align-items-center mb-3">


                    <div>


                      <div class="fw-semibold">

                        Statut

                      </div>


                      <div class="text-muted small">

                        Visibilité du produit

                      </div>

                    </div>


                    <span id="statusBadge"
                          class="status-badge">

                      Actif

                    </span>


                  </div>


                  <select class="form-select"
                          name="status"
                          id="productStatus">


                    <option value="actif">

                      Actif

                    </option>


                    <option value="inactif">

                      Inactif

                    </option>


                    <option value="brouillon">

                      Brouillon

                    </option>


                  </select>


                </div>

              </div>


              <!-- =============================================
                   RESUME
              ============================================== -->

              <div class="card mb-4">


                <div class="card-header">

                  Résumé

                </div>


                <div class="card-body">


                  <div class="summary-item">

                    <span class="summary-label">

                      Type

                    </span>


                    <span class="summary-value"
                          id="summaryType">

                      Véhicule

                    </span>

                  </div>


                  <div class="summary-item">

                    <span class="summary-label">

                      Produit

                    </span>


                    <span class="summary-value"
                          id="summaryName">

                      —

                    </span>

                  </div>


                  <div class="summary-item">

                    <span class="summary-label">

                      Référence

                    </span>


                    <span class="summary-value"
                          id="summaryReference">

                      —

                    </span>

                  </div>


                  <div class="summary-item">

                    <span class="summary-label">

                      Prix

                    </span>


                    <span class="summary-value"
                          id="summaryPrice">

                      —

                    </span>

                  </div>


                  <div class="summary-item">

                    <span class="summary-label">

                      Stock

                    </span>


                    <span class="summary-value"
                          id="summaryQuantity">

                      0

                    </span>

                  </div>


                </div>

              </div>


            </div>

          </div>

        </div>


        <!-- ===================================================
             FOOTER
        ==================================================== -->

        <div class="modal-footer">


          <button type="button"
                  class="btn btn-light border"
                  data-bs-dismiss="modal">

            Annuler

          </button>


          <button type="button"
                  class="btn btn-outline-primary"
                  id="saveDraftBtn">

            <i class="bi bi-save me-1"></i>

            Enregistrer brouillon

          </button>


          <button type="submit"
                  class="btn btn-primary px-4">

            <i class="bi bi-check-lg me-1"></i>

            Créer le produit

          </button>


        </div>


      </form>

    </div>

  </div>

</div>


<!-- =========================================================
     BOOTSTRAP JS
========================================================= -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function(){


  /* =========================================================
     RACCOURCI
  ========================================================= */

  const $ = id => document.getElementById(id);


  /* =========================================================
     ALERTES
  ========================================================= */

  setTimeout(function(){

    ['success-alert','error-alert'].forEach(function(id){

      const element = $(id);

      if(element){

        element.remove();

      }

    });

  }, 3000);


  /* =========================================================
     MENU MOBILE
  ========================================================= */

  const sidebar = $('sidebar');

  const overlay = $('sidebarOverlay');


  function openMenu(){

    if(!sidebar || !overlay){

      return;

    }


    sidebar.classList.add('open');

    overlay.classList.add('show');

    document.body.style.overflow = 'hidden';

  }


  function closeMenu(){

    if(!sidebar || !overlay){

      return;

    }


    sidebar.classList.remove('open');

    overlay.classList.remove('show');

    document.body.style.overflow = '';

  }


  $('sidebarToggle')?.addEventListener(
    'click',
    openMenu
  );


  $('sidebarClose')?.addEventListener(
    'click',
    closeMenu
  );


  overlay?.addEventListener(
    'click',
    closeMenu
  );


  document.addEventListener(
    'keydown',
    function(event){

      if(event.key === 'Escape'){

        closeMenu();

      }

    }
  );


  window.addEventListener(
    'resize',
    function(){

      if(window.innerWidth >= 992){

        closeMenu();

      }

    }
  );


  /* =========================================================
     ELEMENTS FORMULAIRE
  ========================================================= */

  const modal = $('addProductModal');

  const form = $('productForm');


  const typeVehicle = $('typeVehicle');

  const typePiece = $('typePiece');


  const vehicleCard = $('vehicleTypeCard');

  const pieceCard = $('pieceTypeCard');


  const vehicleSection = $('vehicleSection');

  const pieceSection = $('pieceSection');


  const summaryType = $('summaryType');

  const summaryName = $('summaryName');

  const summaryReference = $('summaryReference');

  const summaryPrice = $('summaryPrice');

  const summaryQuantity = $('summaryQuantity');


  const productName = $('productName');

  const productReference = $('productReference');

  const productPrice = $('productPrice');

  const productQuantity = $('productQuantity');


  const productStatus = $('productStatus');

  const statusBadge = $('statusBadge');


  /* =========================================================
     TYPE PRODUIT
  ========================================================= */

  function toggleSection(section, show){

    if(!section){

      return;

    }


    section.classList.toggle(
      'show',
      show
    );


    section
      .querySelectorAll('input, select, textarea')
      .forEach(function(element){

        element.disabled = !show;

      });

  }


  function changeProductType(type){

    const isVehicle =
      type === 'vehicule';


    if(typeVehicle){

      typeVehicle.checked =
        isVehicle;

    }


    if(typePiece){

      typePiece.checked =
        !isVehicle;

    }


    if(vehicleCard){

      vehicleCard.classList.toggle(
        'active',
        isVehicle
      );

    }


    if(pieceCard){

      pieceCard.classList.toggle(
        'active',
        !isVehicle
      );

    }


    toggleSection(
      vehicleSection,
      isVehicle
    );


    toggleSection(
      pieceSection,
      !isVehicle
    );


    if(summaryType){

      summaryType.textContent =
        isVehicle
          ? 'Véhicule'
          : 'Pièce détachée';

    }

  }


  vehicleCard?.addEventListener(
    'click',
    function(event){

      event.preventDefault();

      changeProductType('vehicule');

    }
  );


  pieceCard?.addEventListener(
    'click',
    function(event){

      event.preventDefault();

      changeProductType('piece');

    }
  );


  typeVehicle?.addEventListener(
    'change',
    function(){

      if(this.checked){

        changeProductType('vehicule');

      }

    }
  );


  typePiece?.addEventListener(
    'change',
    function(){

      if(this.checked){

        changeProductType('piece');

      }

    }
  );


  /* =========================================================
     RESUME
  ========================================================= */

  productName?.addEventListener(
    'input',
    function(){

      summaryName.textContent =
        this.value.trim() || '—';

    }
  );


  productReference?.addEventListener(
    'input',
    function(){

      summaryReference.textContent =
        this.value.trim() || '—';

    }
  );


  productPrice?.addEventListener(
    'input',
    function(){

      summaryPrice.textContent =
        this.value === ''
          ? '—'
          : new Intl.NumberFormat('fr-FR')
              .format(Number(this.value))
              + ' FCFA';

    }
  );


  productQuantity?.addEventListener(
    'input',
    function(){

      summaryQuantity.textContent =
        this.value !== ''
          ? this.value
          : '0';

    }
  );


  /* =========================================================
     STATUT
  ========================================================= */

  function updateStatusBadge(){

    if(!productStatus || !statusBadge){

      return;

    }


    const styles = {

      actif: [
        'Actif',
        '#e9f7ef',
        '#198754'
      ],

      inactif: [
        'Inactif',
        '#fcebea',
        '#dc3545'
      ],

      brouillon: [
        'Brouillon',
        '#fff3cd',
        '#997404'
      ]

    };


    const selected =
      styles[productStatus.value]
      || styles.actif;


    statusBadge.textContent =
      selected[0];


    statusBadge.style.backgroundColor =
      selected[1];


    statusBadge.style.color =
      selected[2];

  }


  productStatus?.addEventListener(
    'change',
    updateStatusBadge
  );


  /* =========================================================
     BROUILLON
  ========================================================= */

  $('saveDraftBtn')?.addEventListener(
    'click',
    function(){

      if(!productStatus || !form){

        return;

      }


      productStatus.value =
        'brouillon';


      updateStatusBadge();


      if(form.reportValidity()){

        form.submit();

      }

    }
  );


  /* =========================================================
     PHOTOS
  ========================================================= */

  const productImages =
    $('productImages');


  const imagePreview =
    $('imagePreview');


  const photoUploadTitle =
    $('photoUploadTitle');


  let selectedImages = [];


  function formatFileSize(bytes){

    if(bytes < 1024){

      return bytes + ' octets';

    }


    if(bytes < 1024 * 1024){

      return (
        bytes / 1024
      ).toFixed(1) + ' Ko';

    }


    return (
      bytes / (1024 * 1024)
    ).toFixed(1) + ' Mo';

  }


  function updatePhotoTitle(){

    if(!photoUploadTitle){

      return;

    }


    const count =
      selectedImages.length;


    if(count === 0){

      photoUploadTitle.textContent =
        'Ajouter des photos';

    }
    else if(count === 1){

      photoUploadTitle.textContent =
        '1 photo sélectionnée';

    }
    else{

      photoUploadTitle.textContent =
        count + ' photos sélectionnées';

    }

  }


  function rebuildFileInput(){

    if(!productImages){

      return;

    }


    const dataTransfer =
      new DataTransfer();


    selectedImages.forEach(
      function(file){

        dataTransfer.items.add(file);

      }
    );


    productImages.files =
      dataTransfer.files;

  }


  function updateImagePreview(){

    if(!imagePreview){

      return;

    }


    imagePreview.innerHTML = '';


    if(selectedImages.length === 0){

      imagePreview.classList.add(
        'd-none'
      );

      updatePhotoTitle();

      return;

    }


    imagePreview.classList.remove(
      'd-none'
    );


    selectedImages.forEach(
      function(file, index){

        const col =
          document.createElement('div');


        col.className =
          'col-6 col-md-4 col-lg-3 image-preview-item';


        const card =
          document.createElement('div');


        card.className =
          'image-preview-card';


        const image =
          document.createElement('img');


        image.alt =
          file.name;


        const reader =
          new FileReader();


        reader.onload =
          function(event){

            image.src =
              event.target.result;

          };


        reader.readAsDataURL(file);


        const removeButton =
          document.createElement('button');


        removeButton.type =
          'button';


        removeButton.className =
          'image-preview-remove';


        removeButton.innerHTML =
          '<i class="bi bi-x-lg"></i>';


        removeButton.title =
          'Supprimer cette image';


        removeButton.addEventListener(
          'click',
          function(){

            selectedImages.splice(
              index,
              1
            );


            rebuildFileInput();

            updateImagePreview();

          }
        );


        const name =
          document.createElement('div');


        name.className =
          'image-preview-name';


        name.textContent =
          file.name;


        const size =
          document.createElement('div');


        size.className =
          'image-preview-size';


        size.textContent =
          formatFileSize(file.size);


        card.appendChild(image);

        card.appendChild(removeButton);

        card.appendChild(name);

        card.appendChild(size);


        col.appendChild(card);


        imagePreview.appendChild(col);

      }
    );


    updatePhotoTitle();

  }


  productImages?.addEventListener(
    'change',
    function(){

      const files =
        Array.from(this.files);


      files.forEach(
        function(file){

          const alreadyExists =
            selectedImages.some(
              function(existingFile){

                return (
                  existingFile.name === file.name
                  &&
                  existingFile.size === file.size
                  &&
                  existingFile.lastModified === file.lastModified
                );

              }
            );


          if(alreadyExists){

            return;

          }


          if(file.size > 5 * 1024 * 1024){

            alert(
              'L’image "' +
              file.name +
              '" dépasse la taille maximale de 5 Mo.'
            );

            return;

          }


          const validTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
          ];


          if(!validTypes.includes(file.type)){

            alert(
              'Le fichier "' +
              file.name +
              '" n’est pas une image JPG, PNG ou WEBP valide.'
            );

            return;

          }


          selectedImages.push(file);

        }
      );


      rebuildFileInput();

      updateImagePreview();

    }
  );


  /* =========================================================
     MODAL
  ========================================================= */

  function scrollModalTop(){

    if(!modal){

      return;

    }


    const body =
      modal.querySelector('.modal-body');


    if(body){

      body.scrollTop = 0;

    }

  }


  modal?.addEventListener(
    'shown.bs.modal',
    function(){

      scrollModalTop();

    }
  );


  modal?.addEventListener(
    'hidden.bs.modal',
    function(){

      if(form){

        form.reset();

      }


      selectedImages = [];


      if(productImages){

        productImages.value = '';

      }


      changeProductType(
        'vehicule'
      );


      if(summaryName){

        summaryName.textContent = '—';

      }


      if(summaryReference){

        summaryReference.textContent = '—';

      }


      if(summaryPrice){

        summaryPrice.textContent = '—';

      }


      if(summaryQuantity){

        summaryQuantity.textContent = '0';

      }


      updateImagePreview();

      updateStatusBadge();

      scrollModalTop();

    }
  );


  /* =========================================================
     RECHERCHE + FILTRES
  ========================================================= */

  const searchInput =
    $('searchProduct');


  const filterType =
    $('filterType');


  const filterStatus =
    $('filterStatus');


  const table =
    $('productsTable');


  function filterProducts(){

    if(!table){

      return;

    }


    const search =
      (searchInput?.value || '')
        .toLowerCase()
        .trim();


    const type =
      (filterType?.value || '')
        .toLowerCase();


    const status =
      (filterStatus?.value || '')
        .toLowerCase();


    table
      .querySelectorAll(
        'tbody tr[data-type]'
      )
      .forEach(
        function(row){

          const rowText =
            row.textContent
              .toLowerCase();


          const rowType =
            String(
              row.dataset.type || ''
            ).toLowerCase();


          const rowStatus =
            String(
              row.dataset.status || ''
            ).toLowerCase();


          const matchesSearch =
            rowText.includes(search);


          const matchesType =
            !type ||
            rowType === type;


          const matchesStatus =
            !status ||
            rowStatus === status;


          const visible =
            matchesSearch
            &&
            matchesType
            &&
            matchesStatus;


          row.style.display =
            visible ? '' : 'none';

        }
      );

  }


  searchInput?.addEventListener(
    'input',
    filterProducts
  );


  filterType?.addEventListener(
    'change',
    filterProducts
  );


  filterStatus?.addEventListener(
    'change',
    filterProducts
  );


  /* =========================================================
     INITIALISATION
  ========================================================= */

  changeProductType(
    'vehicule'
  );


  updateStatusBadge();


  updatePhotoTitle();


});
</script>


</body>

</html>