Configurando ambiente


Compilando a aplicação no Docker
"docker-compose build"

Executando a aplicação em background
"docker-compose up -d"

Instalando as dependências do aplicativo
"docker-compose exec app composer install"

Gerando chave do app
"docker-compose exec app php artisan key:generate"

Criando as tabelas
"docker-compose exec app php artisan migrate"

Iniciando websockets
"docker-compose exec app php artisan websockets:serve"

Acesse: http://127.0.0.1/laravel-websockets
Clique em 'Connect'

Executando teste da aplicação
"docker-compose exec app php artisan test"

