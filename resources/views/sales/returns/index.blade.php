<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Retours - INTERCAR</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background: #f5f6fa;
        }
.app-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100vh;
    overflow-y: auto;
    background: #30173D;
    z-index: 1000;
}

        .main-wrapper {
            margin-left: 250px;
            padding: 30px;
        }

        .card-page {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        @media (max-width: 991px) {

            .main-wrapper {
                margin-left: 0;
                padding: 20px;
            }
                .app-sidebar {
        display: none;
    }

        }

    </style>

</head>

<body>

<aside class="app-sidebar">
    @include('auth.partials.sidebar')
</aside>


<div class="main-wrapper">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <h1 class="h4 fw-bold mb-1">
                Retours
            </h1>

            <p class="text-muted mb-0">
                Gestion des produits retournés par les clients.
            </p>

        </div>


        <a
            href="{{ route('sales.returns.create') }}"
            class="btn btn-warning"
        >

            <i class="fa-solid fa-plus me-1"></i>

            Nouveau retour

        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success">

            <i class="fa-solid fa-circle-check me-2"></i>

            {{ session('success') }}

        </div>

    @endif


    <!-- =====================================================
         STATS
    ====================================================== -->

    <div class="row g-3 mb-4">

        <div class="col-md-6">

            <div class="stat-card">

                <div class="text-muted small">
                    Nombre de retours
                </div>

                <div class="fs-4 fw-bold">
                    {{ $totalReturns }}
                </div>

            </div>

        </div>


        <div class="col-md-6">

            <div class="stat-card">

                <div class="text-muted small">
                    Montant total retourné
                </div>

                <div class="fs-4 fw-bold">

                    {{ number_format(
                        $totalAmount,
                        0,
                        ',',
                        ' '
                    ) }}

                    FCFA

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         RECHERCHE
    ====================================================== -->

    <div class="card-page p-4 mb-4">

        <form method="GET">

            <div class="row g-3">

                <div class="col-md-10">

                    <input
                        type="text"
                        name="q"
                        class="form-control"
                        value="{{ request('q') }}"
                        placeholder="N° retour, N° vente, client..."
                    >

                </div>


                <div class="col-md-2">

                    <button
                        type="submit"
                        class="btn btn-dark w-100"
                    >

                        Rechercher

                    </button>

                </div>

            </div>

        </form>

    </div>


    <!-- =====================================================
         TABLE
    ====================================================== -->

    <div class="card-page">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>N° retour</th>

                        <th>Vente</th>

                        <th>Date</th>

                        <th>Client</th>

                        <th>Montant</th>

                        <th>Enregistré par</th>

                        <th class="text-end">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($returns as $return)

                        <tr>

                            <td>

                                <strong>
                                    {{ $return->number }}
                                </strong>

                            </td>


                            <td>

                                <a
                                    href="{{ route('sales.show', $return->sale) }}"
                                    class="text-decoration-none"
                                >
                                    {{ $return->sale->number }}
                                </a>

                            </td>


                            <td>
                                {{ $return->return_date->format('d/m/Y') }}
                            </td>


                            <td>
                                {{ $return->sale->customer_name ?: 'Client comptoir' }}
                            </td>


                            <td>

                                <strong>

                                    {{ number_format(
                                        $return->total,
                                        0,
                                        ',',
                                        ' '
                                    ) }}

                                    FCFA

                                </strong>

                            </td>


                            <td>

                                {{ $return->user->name ?? '—' }}

                            </td>


                            <td class="text-end">

                                <a
                                    href="{{ route('sales.returns.show', $return) }}"
                                    class="btn btn-sm btn-outline-dark"
                                >

                                    <i class="fa-solid fa-eye"></i>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5 text-muted"
                            >

                                <i class="fa-solid fa-rotate-left fa-2x mb-3"></i>

                                <p class="mb-0">
                                    Aucun retour enregistré.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($returns->hasPages())

            <div class="p-3">

                {{ $returns->links() }}

            </div>

        @endif

    </div>

</div>

</body>

</html>