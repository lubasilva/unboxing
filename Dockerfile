# Runtime HTTP simples para Railway
FROM php:8.3-cli-alpine

# Instalar dependências necessárias
RUN apk add --no-cache curl git nodejs npm postgresql-dev && \
    docker-php-ext-install -j$(nproc) pdo pdo_pgsql bcmath

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir working directory
WORKDIR /app

# Copiar código da aplicação
COPY . .

# Instalar dependências PHP de forma reprodutível
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Gerar assets de produção do Vite
RUN npm ci && npm run build && rm -rf node_modules

# Criar diretórios de storage
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views

# Ajustar permissões
RUN chown -R www-data:www-data . && chmod -R 755 storage bootstrap/cache

# Porta padrão do Railway
EXPOSE 8080

# Inicia servidor HTTP com defaults seguros e prepara o app para produção no Railway
CMD ["sh", "-c", "set -e; export SESSION_DRIVER=${SESSION_DRIVER:-file} CACHE_STORE=${CACHE_STORE:-file} QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync} LOG_CHANNEL=${LOG_CHANNEL:-stderr}; if [ -z \"${APP_KEY}\" ]; then export APP_KEY=\"base64:$(php -r 'echo base64_encode(random_bytes(32));')\"; echo '[startup] APP_KEY ausente: chave temporaria gerada para este deploy'; fi; php artisan config:clear || true; php artisan cache:clear || true; php artisan migrate --force || true; php artisan storage:link || true; php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
