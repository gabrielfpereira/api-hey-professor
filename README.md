# Hey Professor API

Uma API RESTful construída com Laravel, projetada para uma plataforma de perguntas e respostas entre alunos e professores.

## Principais Funcionalidades

- **Autenticação de Usuários:** Registro e login de usuários com Sanctum.
- **Gerenciamento de Perguntas:**
    - Criar, listar, atualizar e deletar perguntas.
    - Arquivar e restaurar perguntas.
    - Publicar perguntas para que fiquem visíveis.
- **Sistema de Votos:**
    - Alunos podem votar em perguntas (like/unlike).
    - As perguntas são retornadas com a contagem de votos.
- **Busca e Ordenação:**
    - A listagem de perguntas permite busca por termos e ordenação.

## Tecnologias Utilizadas

- **Backend:** PHP 8.2, Laravel 12
- **Autenticação:** Laravel Sanctum
- **Banco de Dados:** SQLite (padrão, configurável em `.env`)
- **Frontend (dev):** Vite, Tailwind CSS
- **Testes:** PestPHP

## Como Baixar e Rodar o Projeto

Este projeto foi configurado para rodar facilmente com o [Laravel Herd](https://herd.laravel.com/).

1.  **Clonar o repositório:**
    ```bash
    git clone https://github.com/seu-usuario/api-hey-professor.git
    cd api-hey-professor
    ```

2.  **Instalar dependências:**
    ```bash
    composer install
    npm install
    ```

3.  **Configurar o ambiente:**
    Copie o arquivo de configuração de ambiente.
    ```bash
    cp .env.example .env
    ```
    Gere a chave da aplicação.
    ```bash
    php artisan key:generate
    ```

4.  **Banco de Dados:**
    O projeto vem configurado para usar um banco de dados SQLite. Crie o arquivo do banco:
    ```bash
    touch database/database.sqlite
    ```
    Execute as migrações para criar as tabelas.
    ```bash
    php artisan migrate
    ```

5.  **Iniciar o servidor de desenvolvimento:**
    O comando `dev` iniciará o servidor PHP, a fila e o Vite para o frontend.
    ```bash
    npm run dev
    ```
    Se preferir, pode iniciar apenas o servidor PHP com o Artisan:
    ```bash
    php artisan serve
    ```
    A API estará disponível em `http://localhost:8000` (ou o endereço fornecido pelo Herd).

## Testes

Para rodar a suíte de testes automatizados, utilize o Pest:
```bash
php artisan test
```

## Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests.

## Licença

Este projeto está sob a licença MIT.
