@extends('layouts.auth')

@section('title', 'Mot de passe oublié - INTERCAR')

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
                        Mot de passe <span style="color: #F37021;" class="fst-italic">oublié ?</span>
                    </h2>
                    <p class="text-muted small lh-base">
                        Saisissez l'adresse e-mail de votre compte. Nous vous enverrons un lien pour choisir un nouveau mot de passe.
                    </p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success py-2 small" role="alert">
                        <i class="fa-regular fa-circle-check me-1"></i> {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" novalidate>
                    @csrf

                    <div class="mb-4">
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

                    <button type="submit"
                            class="btn w-100 py-3 text-white fw-semibold shadow-sm d-flex align-items-center justify-content-center gap-2 rounded-3 mb-3"
                            style="background-color: #5B2C6F; border: none;">
                        <span>Envoyer le lien</span>
                        <i class="fa-regular fa-paper-plane fs-6"></i>
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
                    <span class="text-black-50">|</span>
                    <span>Le lien expire après 60 minutes</span>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection