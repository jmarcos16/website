---
title: Como configurar imagem Docker(PHP e Nginx) para projetos Laravel com PHP 8.3
image: https://cdn.hashnode.com/res/hashnode/image/upload/v1626482944968/UVLdByje9.jpeg
---

Recentemente, eu estava configurando um ambiente de desenvolvimento para um projeto Laravel e decidi usar o Docker para criar o ambiente. Neste artigo, vou mostrar como você pode configurar uma imagem Docker com PHP 8.3 e Nginx para projetos Laravel.

Caso você não saiba, o Docker é uma plataforma de código aberto que facilita a criação, implantação e execução de aplicativos em contêineres. Os contêineres permitem que um desenvolvedor empacote um aplicativo com todas as partes necessárias, como bibliotecas e outras dependências, e envie tudo como um único pacote.

O laravel oferece uma solução para criar um ambiente de desenvolvimento com Docker, o [Laravel Sail](https://laravel.com/docs/8.x/sail), que é um ambiente de desenvolvimento local para Laravel que usa contêineres Docker. No entanto, neste artigo, vou mostrar como você pode criar um ambiente de desenvolvimento com Docker manualmente, de maneira mais limpida e personalizada.

Um dos problemas de utilizar o Laravel Sail em um ambiente de produção é que ele não é recomendado, pois ele é um ambiente de desenvolvimento. Então, para evitar problemas futuros, é melhor criar um ambiente de desenvolvimento manualmente.

Primeiramente vamos clonar o repositório do [Laravel](https://github.com/laravel/laravel.git) para isso execute o seguinte comando:

```bash
git clone https://github.com/laravel/laravel.git
```

Em seguida o primeiro passo é copiar o arquivo **.env.example** para **.env** 
pois o Laravel usa o arquivo **.env** para carregar as variáveis de ambiente, e o arquivo **.env.example** é um exemplo de como o arquivo **.env** deve ser configurado.

```bash
cp .env.example .env
```

Em seguida, vamos criar um arquivo chamado **Dockerfile** no seguinte caminho **./dockerfiles/php/Dockerfile** e adicionar o seguinte conteúdo:

```docker
FROM php:8.3-fpm-alpine3.19

# Install system dependencies
RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libzip-dev \
    zlib-dev

# Install PHP extensions
RUN docker-php-ext-install gd \
    && docker-php-ext-install zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install node and npm
RUN apk add --no-cache nodejs npm

# Set working directory
WORKDIR /var/www

EXPOSE 9000

```

Neste exemplo, vou utilizar a imagem **php:8.3-fpm-alpine3.19** que é uma imagem oficial do PHP, em alguns casos recomenda-se utilizar a imagem **php:8.3-fpm** por questões de compatibilidade com algumas extensões do PHP, porem como esse projeto é um projeto simples, vou utilizar a alpine, para reduzir o tamanho da imagem, note também que estou instalando algumas dependências do sistema e algumas extensões do PHP, elas são necessárias para o Laravel funcionar corretamente.

Em seguida, vamos criar um arquivo chamado **default.conf** no seguinte caminho **./dockerfiles/nginx/default.conf** e adicionar o seguinte conteúdo:

```nginx
server {
    listen 80;
    index index.php;
    root /var/www/public;
 
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    charset utf-8;
 
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
 
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
 
    error_page 404 /index.php;
 
    location ~ \.php$ {
        fastcgi_pass application:9000;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
 
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Neste arquivo, estou configurando o servidor Nginx para ouvir na porta 80, e estou configurando o root do servidor para a pasta **/var/www/public** que é a pasta onde o Laravel armazena os arquivos públicos, e estou configurando o servidor para redirecionar todas as requisições para o arquivo **index.php**, este exemplo foi retirado da documentação oficial do Laravel, caso você queira saber mais sobre a configuração do servidor Nginx para o Laravel, você pode acessar a [documentação oficial](https://laravel.com/docs/deployment#nginx).

Em seguida, vamos criar um arquivo chamado **docker-compose.yml** na raiz do projeto e adicionar o seguinte conteúdo:

```yaml
services:
  application:
    build:
      context: .
      dockerfile: dockerfiles/php/Dockerfile
    image: application
    container_name: application
    tty: true
    ports:
      - "9000:9000"
    volumes:
      - .:/var/www
    networks:
      - laravel_app
  nginx:
    image: nginx:alpine
    container_name: nginx
    ports:
      - "80:80"
    volumes:
      - .:/var/www
      - ./dockerfiles/nginx/default.conf:/etc/nginx/conf.d/default.conf
    networks:
      - laravel_app
networks:
  laravel_app:
    driver: bridge
```

Neste arquivo, estou configurando dois serviços, o primeiro serviço é o **application** que é a imagem do PHP que criamos anteriormente, e o segundo serviço é o **nginx** que é a imagem do Nginx, e estou configurando o **nginx** para ouvir na porta 80 e redirecionar as requisições para o serviço **application** na porta 9000, e estou configurando o volume para o **nginx** para que ele possa acessar o arquivo **default.conf** que criamos anteriormente.

Agora já podemos criar a imagem do PHP e do Nginx, para isso execute o seguinte comando:

```bash
docker compose up -d
```

Em seguinda, vamos instalar as dependências do Laravel, para isso execute o seguinte comando:

```bash
docker compose exec application composer install
```

Em seguida, vamos gerar a chave do Laravel, para isso execute o seguinte comando:

```bash
docker compose exec application php artisan key:generate
```

Agora já podemos acessar o projeto Laravel no navegador, para isso acesse o seguinte endereço:

```
http://localhost ou o ip da sua máquina
```

Também é necessário configurar as permisões dos arquivos do Laravel, para isso execute o seguinte comando:

```bash
docker compose exec application chown -R www-data:www-data /var/www/storage
```

No meu caso como estou utilizando dependencias node, tive que instalar as dependencias do node, para isso execute o seguinte comando:

```bash
docker compose exec application npm install
```

E pronto, agora você tem um ambiente de desenvolvimento para projetos Laravel com PHP 8.3 e Nginx, considerando que a imagens do PHP e do Nginx são bem leves, e o ambiente é bem personalizável, e você pode adicionar mais serviços ao seu ambiente, como o banco de dados, cache, fila, etc, as duas imagens ficaram com um tamanho de 100MB cada, o que é bem leve para uma imagem do PHP e do Nginx.