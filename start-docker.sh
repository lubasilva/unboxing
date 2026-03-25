#!/bin/bash

echo "🐳 Iniciando UNBOXING em Docker..."
echo ""

# Verificar se Docker está rodando
if ! command -v docker &> /dev/null; then
    echo "❌ Docker não está instalado!"
    exit 1
fi

# Build e iniciar containers
echo "📦 Construindo imagens Docker..."
docker-compose build --no-cache

echo ""
echo "🚀 Iniciando containers..."
docker-compose up -d

echo ""
echo "⏳ Aguardando banco de dados..."
sleep 5

echo "🔄 Executando migrations e seeders..."
docker-compose exec -T app php artisan migrate:fresh --seed

echo ""
echo "✅ UNBOXING está rodando!"
echo ""
echo "🌐 URLs:"
echo "   Loja:    http://localhost:8001"
echo "   Admin:   http://localhost:8001/admin/dashboard"
echo ""
echo "👤 Credenciais:"
echo "   Email:   admin@unboxing.com.br"
echo "   Senha:   password"
echo ""
echo "📊 Banco de dados:"
echo "   Host:    db"
echo "   Porta:   5432"
echo "   DB:      unboxing"
echo "   User:    postgres"
echo "   Pass:    postgres"
echo ""
echo "🛑 Para parar: docker-compose down"
echo "📋 Para ver logs: docker-compose logs -f app"
