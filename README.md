# 🏢 Sistema Imobiliária - Laravel

Sistema completo de gestão imobiliária com painel administrativo e área pública para visualização e busca de imóveis.

## 🚀 Características

### 🌐 Área Pública
- ✅ Busca avançada de imóveis com filtros
- ✅ Visualização detalhada com galeria de imagens
- ✅ Sistema de favoritos (localStorage)
- ✅ Agendamento de visitas online
- ✅ Formulário de contato
- ✅ Mapa interativo de localização
- ✅ Design responsivo

### 🛠 Painel Administrativo
- ✅ Dashboard com estatísticas
- ✅ CRUD completo de imóveis
- ✅ Upload múltiplo de imagens
- ✅ Gestão de agendamentos
- ✅ Gestão de mensagens/contatos
- ✅ Gestão de tipos e finalidades
- ✅ Configurações gerais do sistema
- ✅ Sistema de autenticação

## 📋 Pré-requisitos

- PHP >= 8.1
- Composer
- MySQL >= 5.7 ou MariaDB
- Node.js & NPM (para compilar assets)

## 🔧 Instalação

Siga os passos abaixo para instalar o sistema:

### 1. Clone ou extraia o projeto

```bash
cd imobiliaria
```

### 2. Instale as dependências do PHP

```bash
composer install
```

### 3. Configure o ambiente

```bash
cp .env.example .env
php artisan key:generate
```

Edite o arquivo `.env` e configure suas credenciais de banco de dados:

```
DB_DATABASE=imobiliaria
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4. Crie o banco de dados

Crie um banco de dados MySQL chamado `imobiliaria` ou o nome que você definiu no `.env`.

### 5. Execute as migrations

```bash
php artisan migrate
```

### 6. Execute os seeders (dados de exemplo)

```bash
php artisan db:seed
```

Isso irá criar:
- ✅ Usuário administrador
- ✅ Tipos de imóveis (Casa, Apartamento, Terreno, etc.)
- ✅ Finalidades (Venda, Aluguel)
- ✅ 20 imóveis de exemplo com imagens
- ✅ Agendamentos de exemplo
- ✅ Mensagens de exemplo
- ✅ Configurações do sistema

### 7. Crie o link simbólico para storage

```bash
php artisan storage:link
```

### 8. Instale as dependências do Node e compile os assets

```bash
npm install
npm run build
```

### 9. Inicie o servidor

```bash
php artisan serve
```

Acesse: `http://localhost:8000`

## 👤 Credenciais de Acesso

### Administrador
- **Email:** admin@imobiliaria.com
- **Senha:** password

## 📁 Estrutura do Projeto

```
imobiliaria/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Admin/          # Controllers do painel admin
│   │       └── Site/           # Controllers da área pública
│   ├── Models/                 # Models Eloquent
│   └── View/
│       └── Components/         # Componentes Blade
├── database/
│   ├── migrations/             # Migrations do banco
│   └── seeders/                # Seeders
├── public/
│   └── storage/                # Link simbólico para storage
├── resources/
│   └── views/
│       ├── admin/              # Views do painel admin
│       ├── site/               # Views da área pública
│       ├── components/         # Componentes reutilizáveis
│       └── layouts/            # Layouts principais
└── routes/
    └── web.php                 # Rotas da aplicação
```

## 🎯 Funcionalidades Principais

### Tipos de Imóveis
- Casa
- Apartamento
- Terreno
- Chácara
- Sala Comercial
- Galpão

### Finalidades
- Venda
- Aluguel

### Status de Imóveis
- Ativo
- Vendido
- Alugado
- Oculto

### Status de Agendamentos
- Pendente
- Confirmado
- Cancelado
- Realizado

## 🔐 Segurança

- Autenticação via Laravel Breeze
- Proteção de rotas administrativas com middleware `auth`
- Validação de formulários
- Proteção CSRF em todos os forms

## 📧 Configuração de E-mail

Para configurar o envio de e-mails, edite as variáveis no arquivo `.env`:

```
MAIL_MAILER=smtp
MAIL_HOST=seu_smtp
MAIL_PORT=587
MAIL_USERNAME=seu_email
MAIL_PASSWORD=sua_senha
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@imobiliaria.com
```

## 🗺 Google Maps (Opcional)

Para usar o Google Maps, adicione sua API key no `.env`:

```
GOOGLE_MAPS_API_KEY=sua_chave_aqui
```

## 📱 WhatsApp

Configure o número do WhatsApp no `.env`:

```
WHATSAPP_NUMBER=5511999999999
```

## 🎨 Personalização

### Logo e Cores
Acesse o painel administrativo em `/admin/configuracoes` para personalizar:
- Nome da imobiliária
- Telefone e e-mail
- Endereço
- Textos institucionais
- Cores do tema (futuro)

## 🐛 Troubleshooting

### Erro de permissão no storage
```bash
chmod -R 775 storage bootstrap/cache
```

### Link simbólico não funciona
```bash
php artisan storage:link
```

### Assets não carregam
```bash
npm run build
```

## 📝 Licença

Este projeto é open-source sob a licença MIT.

## 👨‍💻 Suporte

Para dúvidas e suporte, entre em contato através do formulário no site ou abra uma issue no repositório.
