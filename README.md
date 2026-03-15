<div>
  <img src="https://github.com/hosanabarcelos/todo-tasks/blob/main/.github/images/banner.png" />
</div>

# TODO Tasks API

## 📁 Sobre o projeto
Este projeto faz parte da atividade da disciplina **Arquitetura de Serviços**, do professor **Leonardo Guerreiro**, no curso de Engenharia de Software pela UFRJ.

Aqui a proposta foi reproduzir, em Laravel, o que foi implementado em Python no curso. Ou seja: mesma ideia do web service RESTful de tarefas, mas com uma estrutura Laravel mais limpa e pronta para evoluir. A ideia foi alterar a linguagem afim de ter uma experiência maior de desenvolvimento para ampliar conhecimentos.

## 🔎 Funcionalidades principais
A API gerencia tarefas (`tasks`) com CRUD completo:

1. Listar tarefas
2. Buscar tarefa por ID
3. Criar tarefa
4. Atualizar tarefa
5. Deletar tarefa

Cada tarefa possui:

- `id` (integer)
- `title` (string)
- `description` (string)
- `done` (boolean)

## 🛠️ Endpoints
Base URL: `http://localhost:8000/todo/api`

1. `GET /tasks`
- Lista todas as tarefas.
- Resposta:
```json
{
  "tasks": [
    {
      "id": 1,
      "title": "Buy groceries",
      "description": "Milk, Cheese, Pizza, Fruit, Tylenol",
      "done": false
    }
  ]
}
```

2. `GET /tasks/{id}`
- Busca uma tarefa específica.
- Se não existir: `404`
```json
{
  "message": "Resource not found."
}
```

3. `POST /tasks`
- Cria tarefa.
- Body:
```json
{
  "title": "Test the web service",
  "description": "You should test this web service."
}
```
- Retorno: `201 Created`

4. `PUT /tasks/{id}`
- Atualiza tarefa existente.
- Body de exemplo:
```json
{
  "title": "Test web service X",
  "description": "You should test this web service.",
  "done": true
}
```
- Retorno: `200 OK`

5. `DELETE /tasks/{id}`
- Remove tarefa.
- Retorno:
```json
{
  "result": true
}
```

## 🐋 Como testar
Recomendação: usar Docker para evitar problemas de ambiente (PHP/Composer local, versões, etc).

### Pre-requisitos
- Docker instalado
- Windows/macOS: Docker Desktop instalado e aberto
- Linux: Docker Engine + Docker Compose plugin instalados
- Serviço/Engine Docker rodando
- Se estiver no Docker Desktop, usar Linux containers ativo

### 1. Subir a aplicação
Na raiz do projeto:

```bash
docker compose up --build
```

No terminal você vai ver, em ordem aproximada:

1. build da imagem (`Dockerfile`)
2. instalação de dependências (`composer install`)
3. criação/ajuste de chave da app (`php artisan key:generate`)
4. migração e seed (`php artisan migrate --seed`)
5. servidor subindo (`php artisan serve`)

Quando aparecer algo parecido com:

```txt
INFO  Server running on [http://0.0.0.0:8000]
```

Pronto, API no ar.

### 2. Teste rápido no navegador
Abra:

`http://localhost:8000/todo/api/tasks`

Você deve ver um JSON com tarefas iniciais (seed), incluindo:

- `Buy groceries`
- `Learn Laravel`

### 3. Teste no Postman ou Insomnia
Use a base URL:

`http://localhost:8000/todo/api`

1. Listar tarefas
- Método: `GET`
- URL: `http://localhost:8000/todo/api/tasks`
- Esperado: `200 OK` com array em `tasks`

2. Buscar tarefa por id
- Método: `GET`
- URL: `http://localhost:8000/todo/api/tasks/1`
- Esperado: `200 OK` com objeto em `task`

3. Criar tarefa
- Método: `POST`
- URL: `http://localhost:8000/todo/api/tasks`
- Header: `Content-Type: application/json`
- Body:
```json
{
  "title": "Nova tarefa via Postman",
  "description": "Criada para testar o endpoint POST"
}
```
- Esperado: `201 Created`, com `task.id` novo e `done: false`

4. Atualizar tarefa
- Método: `PUT`
- URL: `http://localhost:8000/todo/api/tasks/{id_criado}`
- Header: `Content-Type: application/json`
- Body:
```json
{
  "title": "Tarefa atualizada",
  "done": true
}
```
- Esperado: `200 OK` e JSON com tarefa atualizada

5. Deletar tarefa
- Método: `DELETE`
- URL: `http://localhost:8000/todo/api/tasks/{id_criado}`
- Esperado: `200 OK`
```json
{
  "result": true
}
```

6. Cenário de erro (404)
- Método: `GET`
- URL: `http://localhost:8000/todo/api/tasks/999999`
- Esperado: `404 Not Found`
```json
{
  "message": "Resource not found."
}
```

### 4. Teste com arquivo HTTP no VS Code
Arquivo pronto para isso:

- `docs/tasks-api.http`

Com a extensão REST Client, é só abrir o arquivo e clicar em `Send Request` em cada bloco.

### 5. Encerrar ambiente
No terminal que está com o compose:

- `Ctrl + C`

Depois rode:

```bash
docker compose down
```

---

Made by [Hosana Barcelos](https://www.hosana.me/).
