# Configurando ambiente


### Compilando a aplicação no Docker
```bash
docker-compose build
```

### Executando a aplicação em background
```bash
docker-compose up -d
```

### Instalando as dependências do aplicativo
```bash
docker-compose exec app composer install
```

### Gerando chave do app
```bash
docker-compose exec app php artisan key:generate
```

### Criando as tabelas
```bash
docker-compose exec app php artisan migrate
```

### Iniciando websockets
```bash
docker-compose exec app php artisan websockets:serve
```

Acesse: http://127.0.0.1/laravel-websockets
Clique em 'Connect'

### Executando teste da aplicação
```bash
docker-compose exec app php artisan test
```

