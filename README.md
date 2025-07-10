# Hey Professor API

Esta é uma aplicação onde alunos podem enviar perguntas para professores. As perguntas são listadas e podem ser votadas por outros alunos, permitindo que sejam ordenadas por relevância.

## Funcionalidades

- Envio de perguntas por alunos
- Listagem de perguntas
- Votação nas perguntas por outros alunos
- Ordenação das perguntas por relevância (mais votadas primeiro)

## Tecnologias

- PHP
- Laravel
- Banco de dados (especifique aqui, ex: MySQL, PostgreSQL)

## Como usar

1. Clone o repositório:
    ```bash
    git clone https://github.com/seu-usuario/api-hey-professor.git
    ```
2. Instale as dependências:
    ```bash
    composer install
    ```
3. Copie o arquivo de exemplo de variáveis de ambiente e configure conforme necessário:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4. Execute as migrations do banco de dados:
    ```bash
    php artisan migrate
    ```
5. Inicie a aplicação:
    ```bash
    php artisan serve
    ```

## Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests.

## Licença

Este projeto está sob a licença MIT.