@extends('layouts.auth')

@section('title', 'Nouveau mot de passe - INTERCAR')

@section('content')
<div class="container-fluid p-0 m-0 overflow-hidden" style="min-height: 100vh;">
    <div class="row g-0 min-vh-100 w-100 m-0">

        @include('auth.partials.left-panel')

        <div class="col-12 col-lg-6 bg-white d-flex flex-column justify-content-between p-4 p-md-5 position-relative overflow-hidden" style="min-height: 100vh;">

            <div class="corner-stripes"></div>

            <div class="text-center pt-3 mb-3">
                <img src="{{ asset('images/logo-intercar.jpeg') }}"
                     alt="INTERCAR VÉHICULES & PIÈCES DÉTACHÉES"
                     class="img-fluid"
                     style="max-height: 110px; width: auto;">
            </div>

            <div class="my-auto mx-auto w-100 px-2" style="max-width: 440px;">

                <div class="mb-4">
                    <h2 class="fw-bold fs-3 mb-2" style="color: #5B2C6F;">
                        Nouveau <span style="color: #F37021;" class="fst-italic">mot de passe</span>
                    </h2>
                    <p class="text-muted small lh-base">
                        Choisissez un nouveau mot de passe d'au moins 8 caractères.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.update') }}" novalidate>
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email (rempli par le lien reçu) -->
                    <div class="mb-3">
                        <div class="input-group input-group-lg border rounded-3 bg-light overflow-hidden @error('email') border-danger @enderror">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                <i class="fa-regular fa-envelope"></i>
                            </span>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $email) }}"
                                   class="form-control bg-transparent border-0 fs-6 ps-2"
                                   placeholder="Adresse e-mail"
                                   readonly required>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nouveau mot de passe -->
                    <div class="mb-3">
                        <div class="input-group input-group-lg border rounded-3 bg-light overflow-hidden @error('password') border-danger @enderror">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control bg-transparent border-0 fs-6 ps-2"
                                   placeholder="Nouveau mot de passe"
                                   autocomplete="new-password"
                                   required autofocus>
                            <button class="btn bg-transparent border-0 text-muted pe-3" type="button"
                                    data-toggle-password="password" aria-label="Afficher ou masquer le mot de passe">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirmation -->
                    <div class="mb-4">
                        <div class="input-group input-group-lg border rounded-3 bg-light overflow-hidden">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   class="form-control bg-transparent border-0 fs-6 ps-2"
                                   placeholder="Confirmer le mot de passe"
                                   autocomplete="new-password"
                                   required>
                            <button class="btn bg-transparent border-0 text-muted pe-3" type="button"
                                    data-toggle-password="password_confirmation" aria-label="Afficher ou masquer le mot de passe">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                            class="btn w-100 py-3 text-white fw-semibold shadow-sm d-flex align-items-center justify-content-center gap-2 rounded-3 mb-3"
                            style="background-color: #5B2C6F; border: none;">
                        <span>Enregistrer le mot de passe</span>
                        <i class="fa-solid fa-arrow-right fs-6"></i>
                    </button>

                    <p class="text-center small mb-0">
                        <a href="{{ route('login') }}" class="fw-semibold text-decoration-none" style="color: #F37021;">
                            <i class="fa-solid fa-arrow-left me-1"></i> Retour à la connexion
                        </a>
                    </p>
                </form>
            </div>

            <div class="text-center pt-3">
                <p class="small text-muted mb-0 d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-regular fa-circle-check" style="color: #5B2C6F;"></i>
                    <span>Réinitialisation sécurisée</span>
                </p>
            </div>
        </div>

    </div>
</div>

<script>
document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const input = document.getElementById(btn.dataset.togglePassword);
        const icon = btn.querySelector('i');
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.classList.toggle('fa-eye', !show);
        icon.classList.toggle('fa-eye-slash', show);
    });
});
</script>
@endsection