# 🛒 Loja Virtual - Laravel

Este é um projeto de e-commerce completo desenvolvido em **Laravel 12**, com funcionalidades como:

- Carrinho de compras
- Cupons de desconto
- Frete automático via CEP
- Checkout e pedidos
- Sistema de estoque
- Webhook para atualização de pedidos
- Painel de cliente e vendedor
- Envio de e-mail com confirmação de pedido

---

## 🚀 Tecnologias Utilizadas

- PHP 8.2+
- Laravel 12
- MySQL / MariaDB
- Bootstrap 5
- SweetAlert 2
- Tailwind (parcial)
- Blade Components
- Eloquent ORM
- Markdown Mailable
- API ViaCEP (frete)

---
## ⚙️ Instalação do Projeto
### 📥 Passo a Passo

```bash
# 1. Clonar o repositório
git clone https://github.com/NathaEmanuel17/test_montinkbackend.git
cd loja-virtual

# 2. Instalar as dependências do PHP
composer install

# 3. Instalar as dependências do front (JS/CSS)
npm install && npm run dev

# 4. Copiar e configurar o .env
cp .env.example .env

#5✏️ Configurações do .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=loja_virtual
DB_USERNAME=root
DB_PASSWORD=

WEBHOOK_TOKEN=seu_token_aqui

#6🗝️ Gerar chave da aplicação
php artisan key:generate

#7🗃️ Rodar as migrations
php artisan migrate

#8🌱 Popular banco com dados de exemplo (opcional)
php artisan db:seed

#9✅ Rodar o Projeto
php artisan serve

# VIDEO DEMONSTRAÇÃO SISTEMA
https://drive.google.com/file/d/1v8ct-NBbNxSVJj1JI35MCSJUJyOFem6d/view?usp=sharing

#10 A Colletion do webhook está nos arquivos do projeto
