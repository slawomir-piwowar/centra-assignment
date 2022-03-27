# Centra assignment

This is a simple, read-only, Kanban-board for Github issues.

![Alt text](docs/img/project.png?raw=true "App image")

## Installation

### Step 1

Create .env file based on .env.example in project root folder and fill it with valid values:
```dotenv
GH_CLIENT_ID="YOUR_GITHUB_CLIENT_ID"
GH_CLIENT_SECRET="YOUR_GITHUB_CLIENT_SECRET"
GH_REPOSITORIES="REPOISTORY_NAMES_SEPARATED_BY_|"
GH_ACCOUNT="YOUR_GITHUB_ACCOUNT"

```
### Step 2
Run DockerCompose command by typing:
```makefile
make up
```

### Step 3
Run built-in php web server with command:
```makefile
make serve
```

### Step 4
Go to http://127.0.0.1:8000/ 

## Tests

### Unit tests
```makefile
make test
```

### Static analyze
```makefile
make check
```
