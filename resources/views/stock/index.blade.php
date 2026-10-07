<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Stock - INTERCAR</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{--purple-sidebar:#30173D;--purple-main:#5B2C6F;--purple-btn:#512264;--orange-active:#F37021;--bg-body:#F4F5F8}
body{background-color:var(--bg-body);font-family:'Inter',sans-serif;color:#2D3748;font-size:.875rem}

.sidebar{width:250px;background-color:var(--purple-sidebar);min-height:100vh;position:fixed;top:0;left:0;z-index:1000;height:100vh;overflow-y:auto;transition:transform .25s ease}
.sidebar-brand{padding:1.5rem 1rem 1rem}
.sidebar .nav-link{color:rgba(255,255,255,.7);font-size:.85rem;font-weight:500;padding:.65rem 1rem;border-radius:8px;margin-bottom:3px;display:flex;align-items:center;gap:12px}
.sidebar .nav-link:hover{color:#fff;background-color:rgba(255,255,255,.08)}
.sidebar .nav-link.active{color:#fff;background-color:var(--orange-active);font-weight:600}

.main-wrapper{margin-left:250px;padding:1.25rem 2rem 2rem}
.top-bar{background-color:#fff;border-radius:12px;padding:.5rem 1.25rem;box-shadow:0 2px 4px rgba(0,0,0,.02)}
.card-custom{background-color:#fff;border:none;border-radius:12px;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.03)}
.stat-number{font-size:1.5rem;font-weight:700}

.sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(26,11,46,.55);z-index:999}
.sidebar-overlay.show{display:block}

@media (max-width:991.98px){
  .sidebar{transform:translateX(-100%);max-width:85vw}
  .sidebar.open{transform:translateX(0)}
  .main-wrapper{margin-left:0;padding:1rem}
}
</style>
</head>

<body>

@include('auth.partials.sidebar')

<main class="main-wrapper">

    <!-- TOP BAR -->
    <header class="top-bar d-flex align-items-center justify-content-between gap-2 mb-4">
        <button type="button" class="btn btn-light border d-lg-none" id="sidebarToggle">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-cubes text-muted"></i>
            <span class="fw-semibold">Gestion du stock</span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold"
                 style="width:36px;height:36px;background-color:var(--purple-sidebar);">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <span class="fw-semibold d-none d-sm-inline">{{ Auth::user()->name }}</span>
        </div>
    </header>

    <!-- MESSAGES -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- TITRE + BOUTONS -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Stock</h4>
            <p class="text-muted mb-0">Suivez les entrées, sorties et niveaux de stock.</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('stock.entries.index') }}" class="btn btn-light border">
                <i class="fa-solid fa-list me-2"></i>Entrées
            </a>

            <a href="{{ route('stock.entries.create') }}"
               class="btn text-white"
               style="background-color:var(--purple-btn);">
                <i class="fa-solid fa-plus me-2"></i>Nouvelle entrée
            </a>

            <button type="button"
                    class="btn btn-outline-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#movementModal">
                <i class="fa-solid fa-minus me-2"></i>Sortie
            </button>
        </div>
    </div>

    <!-- STATISTIQUES -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted mb-1">Produits</div>
                        <div class="stat-number">{{ $totalProducts }}</div>
                    </div>
                    <i class="fa-solid fa-box fs-3 text-primary"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted mb-1">Quantité totale en stock</div>
                        <div class="stat-number">{{ $totalStock }}</div>
                    </div>
                    <i class="fa-solid fa-cubes fs-3 text-success"></i>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card-custom">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted mb-1">Stocks faibles</div>
                        <div class="stat-number text-danger">{{ $stockFaible }}</div>
                    </div>
                    <i class="fa-solid fa-triangle-exclamation fs-3 text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- ÉTAT DU STOCK -->
    <div class="card-custom mb-4">
        <h6 class="fw-bold mb-3">État du stock</h6>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Produit</th>
                        <th>Catégorie</th>
                        <th>Type</th>
                        <th>Stock</th>
                        <th>Seuil minimum</th>
                        <th>État</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="fw-semibold">{{ $product->reference }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category }}</td>
                            <td>
                                @if($product->type === 'piece')
                                    <span class="badge bg-warning text-dark">Pièce</span>
                                @else
                                    <span class="badge bg-info text-dark">Véhicule</span>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $product->quantity }}</td>
                            <td>{{ $product->stock_minimum }}</td>
                            <td>
                                @if($product->quantity == 0)
                                    <span class="badge bg-danger">Rupture</span>
                                @elseif($product->quantity <= $product->stock_minimum)
                                    <span class="badge bg-warning text-dark">Stock faible</span>
                                @else
                                    <span class="badge bg-success">Normal</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fa-solid fa-box-open fs-1 text-muted mb-3"></i>
                                <p class="text-muted mb-0">Aucun produit enregistré.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- HISTORIQUE -->
    <div class="card-custom">
        <h6 class="fw-bold mb-3">Historique des mouvements</h6>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Produit</th>
                        <th>Type</th>
                        <th>Quantité</th>
                        <th>Stock avant</th>
                        <th>Stock après</th>
                        <th>Motif</th>
                        <th>Utilisateur</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movements as $movement)
                        <tr>
                            <td>{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                            <td class="fw-semibold">{{ $movement->product->name }}</td>
                            <td>
                                @if($movement->type === 'entree')
                                    <span class="badge bg-success">Entrée</span>
                                @elseif($movement->type === 'sortie')
                                    <span class="badge bg-danger">Sortie</span>
                                @else
                                    <span class="badge bg-warning text-dark">Ajustement</span>
                                @endif
                            </td>
                            <td class="fw-bold">
                                @if($movement->type === 'entree')
                                    +{{ $movement->quantity }}
                                @else
                                    -{{ $movement->quantity }}
                                @endif
                            </td>
                            <td>{{ $movement->stock_avant }}</td>
                            <td>{{ $movement->stock_apres }}</td>
                            <td>{{ $movement->motif ?? '-' }}</td>
                            <td>{{ $movement->user->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Aucun mouvement enregistré.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</main>

<!-- MODAL : SORTIE DE STOCK -->
<div class="modal fade" id="movementModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="{{ route('stock.movements.store') }}">
                @csrf
                <input type="hidden" name="type" value="sortie">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Nouvelle sortie de stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Produit</label>
                            <select name="product_id" class="form-select" required>
                                <option value="">Sélectionner un produit</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->reference }} - {{ $product->name }}
                                        (Stock : {{ $product->quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Quantité</label>
                            <input type="number" name="quantity" class="form-control" min="1" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Motif</label>
                            <input type="text" name="motif" class="form-control"
                                   placeholder="Ex : Vente, casse, usage interne">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Observation</label>
                            <textarea name="observation" class="form-control" rows="3"
                                      placeholder="Observation facultative"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn text-white" style="background-color:var(--purple-btn);">
                        <i class="fa-solid fa-check me-2"></i>Enregistrer
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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

    if (toggle)  toggle.addEventListener('click', openMenu);
    if (close)   close.addEventListener('click', closeMenu);
    if (overlay) overlay.addEventListener('click', closeMenu);
})();
</script>

</body>
</html>