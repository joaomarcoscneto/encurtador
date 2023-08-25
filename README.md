## Passo a passo para rodar o projeto
Clone o projeto
```sh
git clone git@github.com:joaomarcoscneto/encurtador.git
```

Entre no encurtador-api
```sh
cd encurtador/encurtador-api
```

Crie o Arquivo .env
```sh
cp .env.example .env
```

Volte para a raiz do projeto
```sh
cd ..
```


Suba os containers do projeto
```sh
docker-compose up --build
```


Acesse o container
```sh
docker-compose exec api bash
```


Instale as dependências do projeto
```sh
composer install
```


Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Rode as migrations
```sh
php artisan migrate
```



Acesse o projeto
http://localhost:5173/
