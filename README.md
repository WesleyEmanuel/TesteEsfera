
# Teste Esfera - Gerenciador de Tarefas

Projeto desenvolvido em Laravel para gerenciamento de tarefas com funcionalidades como:

- Atribuição de tarefas a usuários
- Filtros por status, título e usuário
- Controle de permissões por `role`
- Paginação de resultados

---

## ✅ Requisitos

- PHP >= 8.1
- Composer
- MySQL ou MariaDB
- Node.js & NPM (para Vite)

---

## ⚙️ Instalação

1. **Clone o projeto ou extraia o `.rar`**

2. **Acesse o diretório do projeto:**

```bash
cd teste-esfera
```

3. **Instale as dependências PHP:**

```bash
composer install
```

4. **Copie o `.env` e gere a chave da aplicação:**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure o arquivo `.env` com seu banco de dados local. Exemplo:**

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=teste_esfera
DB_USERNAME=root
DB_PASSWORD=
```

6. **Execute as migrations e (opcionalmente) as seeders:**

```bash
php artisan migrate --seed
```

7. **Instale as dependências JS e rode o Vite:**

```bash
npm install
npm run dev
```

8. **Inicie o servidor:**

```bash
php artisan serve
```

---

## 👤 Usuários Padrão

| Nome                | Email                  | Senha  | Role     |
|---------------------|------------------------|--------|----------|
| Admin Master        | admin@gmail.com        | Password!| admin    |
| User                | user@gmail.com         | Password!| employee |

**Obs:** As senhas estão criptografadas no banco. Altere via comando ou seed se necessário.

---

## 📌 Funcionalidades

- Filtros por título, status e usuário
- Apenas `admin` pode acessar determinados métodos (via Policy ou Gate)
- Relacionamento muitos-para-muitos entre `users` e `tasks`
- Listagem paginada

---

## 📁 Estrutura Padrão Laravel

- Controllers: `app/Http/Controllers`
- Services: `app/Services`
- Repositories: `app/Repository`
- Models: `app/Models`
- Migrations: `database/migrations`
- Views (Blade): `resources/views`
- Componentes: `resources/views/components`

---

## 🐛 Dúvidas ou Erros

Se ocorrer erro de permissão ou e-mail do SendGrid:
- Verifique se o remetente foi autenticado
- Desative temporariamente envio real de e-mails em `.env` com:
  ```
  MAIL_MAILER=log
  ```

---

## 📜 Licença

Esse projeto é apenas para fins de teste técnico.

