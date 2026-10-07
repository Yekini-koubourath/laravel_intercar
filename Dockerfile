FROM php:8.4-cli

# ============================================================
# Dépendances système nécessaires à Laravel
# ============================================================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        xml \
    && rm -rf /var/lib/apt/lists/*

# ============================================================
# Installer Composer
# ============================================================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ============================================================
# Dossier de travail Laravel
# ============================================================
WORKDIR /var/www/html

# ============================================================
# Copier le projet
# ============================================================
COPY . .

# ============================================================
# Installer les dépendances PHP
# ============================================================
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

# ============================================================
# Préparer les dossiers Laravel
# ============================================================
RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/app/public \
    bootstrap/cache

# ============================================================
# Créer le lien public/storage
# ============================================================
RUN php artisan storage:link

# ============================================================
# Donner les permissions à Laravel
# ============================================================
RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache

# ============================================================
# Installer Node.js / npm et compiler les assets
# ============================================================
RUN apt-get update && apt-get install -y nodejs npm \
    && npm install \
    && npm run build \
    && rm -rf /var/lib/apt/lists/*

# ============================================================
# Port Render
# ============================================================
EXPOSE 10000

# ============================================================
# Démarrage Laravel
# ============================================================
CMD ["sh", "-c", "php artisan storage:link || true && php artisan migrate --force && php artisan db:seed --class=AdminSeeder --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
