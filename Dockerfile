# Runtime HTTP simples para Railway
FROM php:8.3-cli-alpine

# Instalar dependências necessárias
RUN apk add --no-cache curl git postgresql-dev && \
    docker-php-ext-install -j$(nproc) pdo pdo_pgsql bcmath

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir working directory
WORKDIR /app

# Copiar código da aplicação
COPY . .

# Instalar dependências PHP de forma reprodutível
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Criar diretórios de storage
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views

# Ajustar permissões
RUN chown -R www-data:www-data . && chmod -R 755 storage bootstrap/cache

# Porta padrão do Railway
EXPOSE 8080

# Inicia servidor HTTP com defaults seguros para ambientes sem DB provisionado
CMD ["sh", "-c", "export SESSION_DRIVER=${SESSION_DRIVER:-file} CACHE_STORE=${CACHE_STORE:-file} QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}; php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
