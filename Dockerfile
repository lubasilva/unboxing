# Usar imagem leve baseada em Alpine
FROM php:8.3-fpm-alpine

# Instalar dependências necessárias (sem cache apt para reduzir tamanho)
RUN apk add --no-cache curl git postgresql-dev && \
    docker-php-ext-install -j$(nproc) pdo pdo_pgsql bcmath

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir working directory
WORKDIR /app

# Copiar código da aplicação inteiro
COPY . .

# Instalar dependências PHP (apenas com composer.json, sem lock)
RUN composer update --no-dev --no-interaction --no-scripts --prefer-dist --optimize-autoloader

# Criar diretórios de storage
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views

# Ajustar permissões
RUN chown -R www-data:www-data . && chmod -R 755 storage bootstrap/cache

# Expor porta do PHP-FPM
EXPOSE 9000

# Comando padrão
CMD ["php-fpm"]
