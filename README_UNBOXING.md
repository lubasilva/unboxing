# UNBOXING 🖤

**Abra. Descubra.**

E-commerce moderno, dark e minimalista com foco em experiência premium. Desenvolvido com Laravel 12 e Tailwind CSS 4.

---

## 🎯 Visão Geral

**UNBOXING** é uma loja virtual focada em produtos urbanos premium:
- Óculos (Oakley e similares)
- Tênis (New Balance e similares)
- Streetwear

### Público-Alvo
Jovens e adultos (18-35 anos) com estilo urbano/street, localizados em Brasília/DF, que valorizam estética, identidade e experiência de compra premium.

---

## 🚀 Stack Tecnológica

- **Framework**: Laravel 12.x
- **Frontend**: Blade + Tailwind CSS 4.0 (Dark Mode)
- **Autenticação**: Laravel Breeze
- **Banco de Dados**: SQLite (desenvolvimento) / PostgreSQL (produção)
- **Gateway de Pagamento**: Asaas (PIX, Cartão, Boleto)
- **Containerização**: Laravel Sail (Docker) - opcional

---

## 📦 Instalação

### Requisitos
- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite ou PostgreSQL

### Passos

1. **Clone o repositório**
```bash
cd /Users/ipremium/Projetos/Unboxing
```

2. **Instale as dependências**
```bash
composer install
npm install
```

3. **Configure o ambiente**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure o banco de dados**
O projeto já está configurado para usar SQLite. O arquivo `.env` já está pronto.

5. **Execute as migrations e seeders**
```bash
php artisan migrate --seed
```

6. **Compile os assets**
```bash
npm run build
# ou para desenvolvimento:
npm run dev
```

7. **Inicie o servidor**
```bash
php artisan serve --port=8001
```

8. **Acesse**
- **Loja**: http://localhost:8001
- **Admin**: http://localhost:8001/admin/dashboard
  - Email: admin@unboxing.com.br
  - Senha: password

---

## 🏗️ Arquitetura

### Models
- **Category**: Categorias de produtos
- **Product**: Produtos da loja
- **Order**: Pedidos
- **OrderItem**: Itens do pedido
- **Setting**: Configurações do sistema
- **User**: Usuários/Admins

### Controllers

#### Shop (Frontend)
- `HomeController`: Página inicial
- `ProductController`: Listagem e detalhes de produtos
- `CartController`: Carrinho de compras
- `CheckoutController`: Finalização de pedidos

#### Admin (Backoffice)
- `DashboardController`: Dashboard administrativo
- `CategoryController`: CRUD de categorias
- `ProductController`: CRUD de produtos
- `OrderController`: Gerenciamento de pedidos
- `SettingController`: Configurações do sistema

### Services
- `SettingService`: Gerenciamento de configurações (com cache)

---

## 🎨 Identidade Visual

### Cores
- **Background**: Preto (#000000)
- **Texto**: Branco (#FFFFFF)
- **Cinza Escuro**: Zinc-900
- **Bordas**: Zinc-800 com transparência

### Tipografia
- Sans-serif moderna
- Tracking apertado para títulos
- Alto contraste

### Estilo
- Dark mode por padrão
- Minimalismo moderno
- Layout respirado
- Microinterações sutis
- Estética de loja premium urbana

---

## 📋 Funcionalidades

### ✅ Implementado

#### Loja (Frontend)
- [x] Página inicial com hero e categorias
- [x] Listagem de produtos
- [x] Página de produto individual
- [x] Filtro por categoria
- [x] Layout responsivo dark/minimalista
- [ ] Carrinho de compras (estrutura criada)
- [ ] Checkout (estrutura criada)

#### Admin (Backoffice)
- [x] Autenticação com Laravel Breeze
- [x] Dashboard (estrutura criada)
- [ ] CRUD de Categorias (controller criado)
- [ ] CRUD de Produtos (controller criado)
- [ ] Gerenciamento de Pedidos (controller criado)
- [ ] Painel de Configurações (controller criado)
  - Nome da loja
  - Emails transacionais
  - Chaves do Asaas
  - Métodos de pagamento ativos

#### Banco de Dados
- [x] Migrations completas
- [x] Models com relacionamentos
- [x] Seeders básicos
- [x] Categorias: Óculos, Tênis, Streetwear

### 🚧 Próximos Passos

1. **Implementar Views do Admin**
   - Dashboard com estatísticas
   - CRUD completo de categorias
   - CRUD completo de produtos (com upload de imagens)
   - Listagem e detalhes de pedidos
   - Painel de configurações

2. **Implementar Carrinho**
   - Adicionar/remover produtos
   - Atualizar quantidades
   - Persistência em sessão
   - Resumo do pedido

3. **Implementar Checkout**
   - Formulário de dados do cliente
   - Seleção de método de pagamento
   - Integração com Asaas
   - Página de confirmação

4. **Integração Asaas**
   - Service de pagamento
   - PIX (QR Code)
   - Cartão de crédito
   - Webhooks
   - Atualização automática de status

5. **Upload de Imagens**
   - Sistema de upload
   - Otimização de imagens
   - Galeria de produto

6. **Melhorias UX**
   - Loading states
   - Notificações toast
   - Validação frontend
   - Animações

---

## 🔧 Configurações

### Configurações no Painel Admin

Todas as configurações que normalmente iriam para o `.env` estão disponíveis no painel admin em `/admin/configuracoes`:

- **Geral**: Nome, slogan, descrição, contatos
- **Pagamentos**: Chaves Asaas, ambiente, métodos ativos
- **Email**: Remetente padrão

As configurações são salvas no banco e cacheadas para performance.

### Settings via Code

```php
use App\Services\SettingService;

$settings = app(SettingService::class);

// Get
$siteName = $settings->get('site_name', 'Default');

// Set
$settings->set('site_name', 'Unboxing', 'text', 'general');

// Get all from group
$paymentSettings = $settings->getAll('payment');
```

---

## 🗂️ Estrutura de Pastas

```
Unboxing/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/          # Controllers do admin
│   │       └── Shop/           # Controllers da loja
│   ├── Models/                 # Models Eloquent
│   └── Services/               # Services da aplicação
├── database/
│   ├── migrations/             # Migrations do banco
│   └── seeders/                # Seeders
├── resources/
│   ├── css/                    # Tailwind CSS
│   ├── js/                     # JavaScript
│   └── views/
│       ├── layouts/            # Layouts base
│       ├── shop/               # Views da loja
│       └── admin/              # Views do admin (a criar)
└── routes/
    └── web.php                 # Rotas da aplicação
```

---

## 🔐 Segurança

- Autenticação via Laravel Breeze
- CSRF Protection habilitado
- Middleware de autenticação em rotas admin
- Validações de entrada
- Sanitização de dados

---

## 📱 Responsividade

- Mobile-first approach
- Breakpoints Tailwind padrão
- Menu responsivo
- Grid adaptativo

---

## 🎯 Referências

- **Identidade Visual**: Dark, minimalista, urbano
- **Inspiração Estrutural**: useblox.com.br (apenas estrutura, não estética)
- **Tom de Comunicação**: Urbano, elegante, confiante, minimalista

---

## 📝 Licença

Projeto proprietário - UNBOXING © 2026

---

## 👨‍💻 Desenvolvimento

Projeto desenvolvido com foco em:
- Código limpo e organizado
- Boas práticas Laravel
- Experiência do usuário premium
- Escalabilidade
- Manutenibilidade

**Status**: 🟡 Em desenvolvimento ativo

---

## 🆘 Suporte

Para dúvidas ou problemas:
- Email: dev@unboxing.com.br
- Documentação: Este README

---

**UNBOXING** - Abra. Descubra.
