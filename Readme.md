creacion de imagen de Postgres para practica 2
    sudo docker build -t postgresuv02 .

Levantamiento de contenedor de postgres
    sudo docker run --name cpostgres11uv -e POSTGRES_PASSWORD=postgres -d mypostgresuv

Creación de imagen de php
    sudo docker build -t phpapacheuv02 .

Levantamiento de volumen para docker de postgres
    sudo docker run -d -v ./src:/var/www/html/ --name <nombre del contenedo> <nombre o clave de la imagen>