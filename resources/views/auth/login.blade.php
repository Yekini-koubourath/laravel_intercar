@extends('layouts.auth')

@section('title', 'Connexion - INTERCAR')

@section('content')
<div class="container-fluid p-0 m-0 overflow-hidden" style="min-height: 100vh;">
    <div class="row g-0 min-vh-100 w-100 m-0">

        @include('auth.partials.left-panel')

        {{-- Colonne de DROITE : Formulaire de connexion --}}
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
                        Bienvenue sur <span style="color: #F37021;" class="fst-italic">INTERCAR</span>
                    </h2>
                    <p class="text-muted small lh-base">
                        Connectez-vous à votre espace pour gérer votre activité en toute simplicité.
                    </p>
                </div>

                {{-- Message de succès (après inscription) --}}
                @if (session('status'))
                    <div class="alert alert-success py-2 small" role="alert">
                        <i class="fa-regular fa-circle-check me-1"></i> {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.attempt') }}" novalidate>
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <div class="input-group input-group-lg border rounded-3 bg-light overflow-hidden @error('email') border-danger @enderror">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                <i class="fa-regular fa-envelope"></i>
                            </span>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control bg-transparent border-0 fs-6 ps-2"
                                   placeholder="Adresse e-mail"
                                   autocomplete="email"
                                   required autofocus>
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mot de passe -->
                    <div class="mb-3">
                        <div class="input-group input-group-lg border rounded-3 bg-light overflow-hidden @error('password') border-danger @enderror">
                            <span class="input-group-text bg-transparent border-0 text-muted ps-3">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="form-control bg-transparent border-0 fs-6 ps-2"
                                   placeholder="Mot de passe"
                                   autocomplete="current-password"
                                   required>
                            <button class="btn bg-transparent border-0 text-muted pe-3" type="button"
                                    data-toggle-password="password" aria-label="Afficher ou masquer le mot de passe">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Se souvenir de moi & Mot de passe oublié -->
                    <div class="d-flex align-items-center justify-content-between mb-4 pt-1">
                        <div class="form-check d-flex align-items-center gap-2 m-0 ps-0">
                            <input type="checkbox" class="form-check-input m-0" id="remember" name="remember" value="1"
                                   {{ old('remember') ? 'checked' : '' }}
                                   style="width: 18px; height: 18px; accent-color: #5B2C6F;">
                            <label class="form-check-label small text-secondary fw-medium" for="remember">
                                Se souvenir de moi
                            </label>
                        </div>
                        <a href="{{ route('password.request') }}" class="small text-decoration-underline fw-semibold" style="color: #5B2C6F;">
    Mot de passe oublié ?
</a>
                    </div>

                    <!-- Bouton Se connecter -->
                    <button type="submit"
                            class="btn w-100 py-3 text-white fw-semibold shadow-sm d-flex align-items-center justify-content-center gap-2 rounded-3 mb-3"
                            style="background-color: #5B2C6F; border: none;">
                        <span>Se connecter</span>
                        <i class="fa-solid fa-arrow-right fs-6"></i>
                    </button>

                </form>
            </div>

            <div class="text-center pt-3">
                <p class="small text-muted mb-0 d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-regular fa-circle-check" style="color: #5B2C6F;"></i>
                    <span>Connexion sécurisée</span>
                    <span class="text-black-50">|</span>
                    <span>Accès réservé aux utilisateurs autorisés</span>
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