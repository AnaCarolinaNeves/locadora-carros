# Locadora de Carros

Aplicação web desenvolvida em **Laravel** para gestão de uma **locadora de veículos**.  
O sistema permite cadastrar marcas, modelos, carros, clientes e realizar o controle de locações, incluindo regras de negócio básicas (como impedir que um carro seja alugado em duas locações abertas ao mesmo tempo).

Este projeto foi desenvolvido como trabalho prático para aplicar os conhecimentos adquiridos durante o curso **"Desenvolvimento Web Avançado com PHP, Laravel e Vue.JS"**, incluindo:

- Laravel (rotas, controllers, models, migrations, Blade)
- Organização de CRUDs
- Validações
- Regras de negócio simples
- Layout básico com Bootstrap

---

## 🛠 Tecnologias utilizadas

- **PHP** 8.4  
- **Laravel** 12.44  
- **Composer** para gerenciamento de dependências  
- **SQLite** para banco de dados (ambiente de desenvolvimento)  
- **Blade** como engine de views  
- **Bootstrap 5** para layout básico e responsivo  
- **Bootstrap Icons** para ícones no menu lateral  
- **jQuery** + **jQuery Mask Plugin** para máscaras de campos (CPF, telefone, placa)

---

## 📦 Requisitos para executar o projeto

Antes de começar, você precisa ter instalado na sua máquina:

- [PHP 8.4](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Git](https://git-scm.com/) (para clonar o repositório)

Opcionalmente, para usar outro banco de dados (MySQL, PostgreSQL, etc.), você precisará ter o serviço do respectivo banco rodando e configurar o `.env` de acordo.  
Neste projeto, foi utilizado **SQLite** pela simplicidade.

---

## 📥 Instalação e configuração

### 1. Clonar o repositório

```bash
git clone https://github.com/AnaCarolinaNeves/locadora-carros.git
cd locadora-carros
```

### 2. Instalar as dependências do PHP

```bash
composer install
```

### 3. Criar o arquivo .env

```bash
cp .env.example .env
```

### 4. Configurar o banco de dados (SQLite)

```bash
touch database/database.sqlite
```
No arquivo .env, configure:
```bash
DB_CONNECTION=sqlite
DB_DATABASE=./database/database.sqlite
DB_FOREIGN_KEYS=true
```

### 5. Rodar as migrations

```bash
php artisan migrate
```
Se tudo estiver certo, as tabelas padrão do Laravel e as tabelas da aplicação (marcas, modelos, carros, clientes, locações) serão criadas.

---

## ▶️ Executando a aplicação

Após a instalação e configuração:

```bash
php artisan serve
```
Acesse no navegador:

```bash
http://127.0.0.1:8000
```
Você será redirecionado para o **Dashboard** da aplicação.

---

## 🧪 Como testar rapidamente

1. **Criar algumas marcas e modelos**
   - Ex.: Marca: **Fiat**, Modelo: **Uno**
   - Ex.: Marca: **Volkswagen**, Modelo: **Gol**

2. **Cadastrar alguns carros**
   - Ex.: Placa **ABC-1234**, Modelo **Uno**
   - Ex.: Placa **XYZ-5678**, Modelo **Gol**

3. **Cadastrar clientes**
   - Preencher **nome**, **CPF**, **e-mail** e **telefone**

4. **Criar locações**
   - Escolher um **cliente** e um **carro**
   - Definir datas de **retirada** e **devolução**
   - Informar **valor da diária**
   - Salvar com status **aberta**

5. **Concluir locação**
   - Na tela de listagem de locações (`/locacoes`), clicar em **Concluir**
   - Verificar se:
     - Status da locação mudou para **finalizada**
     - Carro voltou para **disponível**
     - Dashboard foi atualizado (**faturamento**, **locações finalizadas**, etc.)
