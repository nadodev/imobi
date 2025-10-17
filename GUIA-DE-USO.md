# 📘 Guia Completo de Uso - Sistema Imobiliária

## 📋 Índice

1. [Instalação](#instalação)
2. [Configuração](#configuração)
3. [Seeders - Dados de Exemplo](#seeders---dados-de-exemplo)
4. [Estrutura do Sistema](#estrutura-do-sistema)
5. [Como Usar](#como-usar)
6. [Credenciais de Acesso](#credenciais-de-acesso)
7. [Funcionalidades](#funcionalidades)
8. [Troubleshooting](#troubleshooting)

---

## 🚀 Instalação

### Pré-requisitos

- PHP >= 8.1
- Composer
- MySQL >= 5.7 ou MariaDB >= 10.3
- Node.js >= 16.x e NPM
- Servidor web (Apache/Nginx) ou usar o servidor embutido do PHP

### Passo a Passo

#### 1. Clone ou extraia o projeto

```bash
cd caminho/do/projeto/imobi
```

#### 2. Instale as dependências do PHP

```bash
composer install
```

Se você ainda não tem o Composer instalado, baixe em: https://getcomposer.org/

#### 3. Configure o arquivo de ambiente

Como o `.env.example` está bloqueado, crie manualmente um arquivo `.env` na raiz do projeto com o seguinte conteúdo:

```env
APP_NAME="Sistema Imobiliária"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=imobiliaria
DB_USERNAME=root
DB_PASSWORD=

# Configurações de email (opcional)
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@imobiliaria.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### 4. Gere a chave da aplicação

```bash
php artisan key:generate
```

#### 5. Crie o banco de dados

No MySQL, execute:

```sql
CREATE DATABASE imobiliaria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Ou use seu cliente MySQL favorito (phpMyAdmin, MySQL Workbench, etc).

#### 6. Execute as migrations

```bash
php artisan migrate
```

Isso criará todas as tabelas necessárias:
- `users` - Usuários do sistema
- `tipos` - Tipos de imóveis
- `finalidades` - Finalidades (venda/aluguel)
- `imoveis` - Imóveis
- `imagens_imovel` - Imagens dos imóveis
- `agendamentos` - Agendamentos de visitas
- `mensagens` - Mensagens de contato
- `configuracoes` - Configurações do sistema

---

## 🌱 Seeders - Dados de Exemplo

### O que os Seeders fazem?

Os seeders populam o banco de dados com dados de exemplo para você testar o sistema imediatamente.

### Execute os Seeders

```bash
php artisan db:seed
```

### O que será criado?

#### 1. **Usuários** (3 usuários)
- **Administrador**
  - Email: `admin@imobiliaria.com`
  - Senha: `password`
  - Tipo: Admin (acesso total)

- **Corretor João**
  - Email: `joao@imobiliaria.com`
  - Senha: `password`
  - Tipo: Corretor

- **Corretor Maria**
  - Email: `maria@imobiliaria.com`
  - Senha: `password`
  - Tipo: Corretor

#### 2. **Tipos de Imóveis** (8 tipos)
- Casa
- Apartamento
- Terreno
- Chácara
- Sala Comercial
- Galpão
- Cobertura
- Sobrado

#### 3. **Finalidades** (2)
- Venda
- Aluguel

#### 4. **Imóveis** (10 imóveis variados)
- 5 imóveis para venda
- 5 imóveis para aluguel
- Distribuídos em várias cidades (São Paulo, Bertioga, Barueri, Cotia, Santo André)
- Com descrições completas
- Alguns marcados como destaque

**Nota sobre imagens:** Os seeders criam registros de imagens com caminho placeholder (`imoveis/placeholder.jpg`). Para ter imagens reais, você deve:
1. Criar a pasta `storage/app/public/imoveis/`
2. Adicionar imagens reais nesta pasta
3. Ou usar o painel admin para fazer upload de imagens

#### 5. **Agendamentos** (5 agendamentos)
- Com diferentes status: pendente, confirmado, cancelado, realizado
- Distribuídos em diferentes datas

#### 6. **Mensagens** (5 mensagens)
- Com diferentes status: não lida, lida, respondida
- Algumas vinculadas a imóveis específicos

#### 7. **Configurações do Sistema**
- Nome da empresa: "Imobiliária Prime"
- Telefone, email, endereço
- Links de redes sociais
- Textos institucionais

---

## 🔧 Configuração Adicional

### 1. Criar link simbólico para storage

```bash
php artisan storage:link
```

Este comando cria um link simbólico de `public/storage` para `storage/app/public`, permitindo que as imagens sejam acessadas publicamente.

### 2. Instalar dependências do Node e compilar assets

```bash
npm install
npm run build
```

Para desenvolvimento com hot reload:
```bash
npm run dev
```

### 3. Iniciar o servidor

```bash
php artisan serve
```

Acesse: http://localhost:8000

---

## 📂 Estrutura do Sistema

```
imobiliaria/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Controllers do painel administrativo
│   │   │   ├── DashboardController.php
│   │   │   ├── ImovelController.php
│   │   │   ├── AgendamentoController.php
│   │   │   ├── MensagemController.php
│   │   │   ├── TipoController.php
│   │   │   ├── FinalidadeController.php
│   │   │   └── ConfiguracaoController.php
│   │   └── Site/            # Controllers da área pública
│   │       ├── HomeController.php
│   │       ├── ImovelController.php
│   │       ├── AgendamentoController.php
│   │       └── ContatoController.php
│   └── Models/              # Models Eloquent
│       ├── User.php
│       ├── Imovel.php
│       ├── Tipo.php
│       ├── Finalidade.php
│       ├── ImagemImovel.php
│       ├── Agendamento.php
│       ├── Mensagem.php
│       └── Configuracao.php
├── database/
│   ├── migrations/          # Migrations do banco
│   └── seeders/             # Seeders com dados de exemplo
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       ├── TipoSeeder.php
│       ├── FinalidadeSeeder.php
│       ├── ImovelSeeder.php
│       ├── AgendamentoSeeder.php
│       ├── MensagemSeeder.php
│       └── ConfiguracaoSeeder.php
├── resources/views/
│   ├── layouts/
│   │   ├── site.blade.php   # Layout da área pública
│   │   └── admin.blade.php  # Layout do painel admin
│   ├── components/          # Componentes reutilizáveis
│   │   ├── card-imovel.blade.php
│   │   └── filtro-imoveis.blade.php
│   ├── site/                # Views da área pública
│   │   ├── home.blade.php
│   │   ├── contato.blade.php
│   │   └── imoveis/
│   │       ├── index.blade.php
│   │       └── show.blade.php
│   └── admin/               # Views do painel admin
│       ├── dashboard.blade.php
│       ├── imoveis/
│       ├── agendamentos/
│       ├── mensagens/
│       ├── tipos/
│       ├── finalidades/
│       └── configuracoes/
└── routes/
    └── web.php              # Rotas da aplicação
```

---

## 💻 Como Usar

### Área Pública (Site)

#### Página Inicial
- Acesse: http://localhost:8000
- Visualize imóveis em destaque
- Use o formulário de busca rápida

#### Buscar Imóveis
- Acesse: http://localhost:8000/imoveis
- Use os filtros avançados:
  - Tipo de imóvel
  - Finalidade (venda/aluguel)
  - Cidade e bairro
  - Faixa de preço
  - Número de quartos
  - Ordenação

#### Ver Detalhes do Imóvel
- Clique em qualquer imóvel
- Veja galeria de fotos
- Informações completas
- Agende uma visita diretamente
- Veja imóveis semelhantes

#### Agendar Visita
- Na página de detalhes do imóvel
- Preencha o formulário com seus dados
- Escolha a data desejada
- A imobiliária receberá a solicitação

#### Enviar Mensagem
- Acesse: http://localhost:8000/contato
- Preencha o formulário
- Envie sua dúvida ou solicitação

---

### Painel Administrativo

#### Acessar o Painel
1. Acesse: http://localhost:8000/login
2. Use as credenciais:
   - Email: `admin@imobiliaria.com`
   - Senha: `password`
3. Você será redirecionado para: http://localhost:8000/admin

#### Dashboard
- Visualize estatísticas gerais
- Total de imóveis (ativos, vendidos, alugados)
- Agendamentos pendentes
- Mensagens não lidas
- Últimos agendamentos
- Últimas mensagens
- Imóveis recentes

#### Gerenciar Imóveis

**Listar Imóveis**
- Menu: Imóveis
- Filtros: busca, tipo, status
- Ações: visualizar, editar, excluir

**Criar Novo Imóvel**
1. Clique em "Novo Imóvel"
2. Preencha os dados:
   - **Informações Básicas:** título, tipo, finalidade, preço, status
   - **Características:** quartos, banheiros, vagas, áreas
   - **Localização:** endereço, cidade, bairro, CEP
   - **Imagens:** faça upload de múltiplas imagens
3. Marque "Destaque" se quiser que apareça na home
4. Clique em "Salvar"

**Editar Imóvel**
1. Clique no ícone de edição
2. Altere os dados necessários
3. Adicione novas imagens ou remova existentes
4. Clique em "Atualizar"

**Excluir Imóvel**
- Clique no ícone de lixeira
- Confirme a exclusão
- As imagens também serão removidas

#### Gerenciar Agendamentos

**Listar Agendamentos**
- Menu: Agendamentos
- Filtros: status, busca por cliente
- Status possíveis:
  - **Pendente:** aguardando confirmação
  - **Confirmado:** visita confirmada
  - **Cancelado:** visita cancelada
  - **Realizado:** visita já aconteceu

**Visualizar Agendamento**
1. Clique no ícone de olho
2. Veja todos os dados do cliente
3. Informações sobre o imóvel
4. Mensagem do cliente

**Atualizar Status**
1. Na tela de visualização
2. Escolha o novo status
3. Adicione observações (opcional)
4. Clique em "Atualizar"

#### Gerenciar Mensagens

**Listar Mensagens**
- Menu: Mensagens
- Mensagens não lidas aparecem destacadas em azul
- Filtros: status, busca

**Visualizar Mensagem**
1. Clique no ícone de olho
2. A mensagem será marcada como "lida" automaticamente
3. Veja dados do remetente
4. Imóvel relacionado (se houver)

**Responder Mensagem**
1. Na tela de visualização
2. Digite sua resposta no campo
3. Clique em "Enviar Resposta"
4. A mensagem será marcada como "respondida"

**Nota:** O sistema está preparado para envio de emails, mas você precisa configurar o SMTP no arquivo `.env`

#### Gerenciar Tipos de Imóveis

**Criar Tipo**
1. Menu: Tipos
2. Digite o nome (ex: "Loft")
3. Defina a ordem de exibição
4. Clique em "Adicionar"

**Editar Tipo**
1. Clique no ícone de edição
2. Altere o nome ou ordem
3. Salve

**Excluir Tipo**
- Só é possível excluir tipos sem imóveis vinculados

#### Gerenciar Finalidades

**Criar Finalidade**
1. Menu: Finalidades
2. Digite o nome (ex: "Temporada")
3. Clique em "Adicionar"

**Editar/Excluir**
- Funcionamento similar aos Tipos

#### Configurações do Sistema

**Atualizar Configurações**
1. Menu: Configurações
2. Edite os dados:
   - **Dados da Imobiliária:** nome, telefone, email, endereço
   - **Redes Sociais:** Facebook, Instagram, WhatsApp
   - **Textos Institucionais:** sobre, política de privacidade
   - **Integrações:** Google Maps API
3. Clique em "Salvar Configurações"

---

## 🔑 Credenciais de Acesso

### Painel Administrativo

| Tipo | Email | Senha | Permissões |
|------|-------|-------|------------|
| Admin | admin@imobiliaria.com | password | Acesso total |
| Corretor | joao@imobiliaria.com | password | Gestão de imóveis |
| Corretor | maria@imobiliaria.com | password | Gestão de imóveis |

**⚠️ IMPORTANTE:** Após a instalação, altere as senhas padrão por segurança!

---

## ✨ Funcionalidades Principais

### Área Pública
✅ Sistema de busca avançada com múltiplos filtros  
✅ Visualização de imóveis em grade  
✅ Página de detalhes com galeria de imagens  
✅ Agendamento online de visitas  
✅ Formulário de contato  
✅ Imóveis em destaque na home  
✅ Imóveis semelhantes  
✅ Design responsivo (mobile-friendly)  
✅ Integração com WhatsApp  

### Painel Administrativo
✅ Dashboard com estatísticas  
✅ CRUD completo de imóveis  
✅ Upload múltiplo de imagens  
✅ Gestão de agendamentos com status  
✅ Gestão de mensagens de contato  
✅ Sistema de resposta a mensagens  
✅ Gestão de tipos e finalidades  
✅ Configurações gerais do sistema  
✅ Autenticação e controle de acesso  
✅ Soft delete para imóveis  
✅ Contador de visualizações  

---

## 🛠 Troubleshooting

### Erro: "No application encryption key has been specified"

**Solução:**
```bash
php artisan key:generate
```

### Erro de permissão em storage ou bootstrap/cache

**Solução (Linux/Mac):**
```bash
chmod -R 775 storage bootstrap/cache
```

**Windows:** Execute o terminal como administrador

### Link simbólico não funciona

**Solução:**
```bash
php artisan storage:link
```

**No Windows:** Execute o PowerShell como Administrador

### Imagens não aparecem

**Verifique:**
1. Se executou `php artisan storage:link`
2. Se as imagens estão em `storage/app/public/imoveis/`
3. Se as permissões da pasta storage estão corretas

### Erro ao executar migrations

**Solução:**
1. Verifique se o banco de dados existe
2. Verifique as credenciais no `.env`
3. Execute:
```bash
php artisan config:clear
php artisan cache:clear
php artisan migrate:fresh
```

### Seeders não funcionam

**Solução:**
```bash
composer dump-autoload
php artisan db:seed
```

Para resetar tudo e recriar:
```bash
php artisan migrate:fresh --seed
```

### Erro 500 ao acessar o site

**Solução:**
1. Verifique o log: `storage/logs/laravel.log`
2. Certifique-se de que o arquivo `.env` existe
3. Execute:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Assets (CSS/JS) não carregam

**Solução:**
```bash
npm install
npm run build
```

---

## 📧 Configuração de Email (Opcional)

Para enviar emails reais (notificações de agendamento, respostas a mensagens):

### Usando Gmail

Edite o `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu_email@gmail.com
MAIL_PASSWORD=sua_senha_app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Nota:** Para Gmail, você precisa gerar uma "Senha de App" nas configurações de segurança.

### Usando Mailtrap (desenvolvimento)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_username
MAIL_PASSWORD=sua_senha
MAIL_ENCRYPTION=tls
```

Após configurar, execute:
```bash
php artisan config:clear
```

---

## 🎯 Próximos Passos

Após a instalação básica, você pode:

1. **Personalizar o Design**
   - Edite as views em `resources/views/`
   - Modifique as cores usando Tailwind CSS

2. **Adicionar Imagens Reais**
   - Substitua os placeholders por fotos reais dos imóveis
   - Upload através do painel admin

3. **Configurar Email**
   - Configure SMTP para envio de notificações

4. **Adicionar Google Maps**
   - Obtenha uma API key do Google Maps
   - Adicione em Configurações > Integrações

5. **Adicionar Mais Funcionalidades**
   - Sistema de favoritos com localStorage
   - Comparação de imóveis
   - Relatórios e gráficos
   - Blog/notícias
   - Chat online

6. **Segurança**
   - Altere as senhas padrão
   - Configure 2FA (Two-Factor Authentication)
   - Adicione rate limiting
   - Configure backups automáticos

---

## 📚 Comandos Úteis

```bash
# Ver rotas disponíveis
php artisan route:list

# Limpar caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Criar novo controller
php artisan make:controller NomeController

# Criar nova migration
php artisan make:migration create_table_name

# Criar novo model
php artisan make:model NomeModel

# Resetar banco e executar seeders
php artisan migrate:fresh --seed

# Criar link simbólico
php artisan storage:link

# Entrar no tinker (console interativo)
php artisan tinker
```

---

## 📞 Suporte

Para dúvidas ou problemas:

1. Verifique este guia
2. Consulte a documentação do Laravel: https://laravel.com/docs
3. Verifique os logs em `storage/logs/laravel.log`

---

## 📝 Licença

Este projeto é open-source sob a licença MIT.

---

**Desenvolvido com ❤️ usando Laravel 10**

