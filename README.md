## Como rodar o Projeto

## dando permissão para executa sh
sudo chmod +x ./build.sh

## execute a sh build
./build.sh

## Após o final da build você deve está dentro do diretório do server
## cd /usr/share/nginx do container, execute os seguintes comandos:

## concedendo permissão de proprietário para pasta storage
chown nginx -R /usr/share/nginx/storage

## criando link simbólico para upload de imagens
php artisan storage:link

## migrando os dados para o postgres
php artisan migrate

## Se desejar seeds no banco após a migração rode o comando abaixo
php artisan db:seed

## O arquivo de importação do insomnia se encontra na raiz do projeto com o nome abaixo
rest_api_insomnia_2023-03-10.json


