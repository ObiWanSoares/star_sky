# Usa uma imagem oficial do PHP com Apache
FROM php:8.2-apache

# Copia todos os ficheiros do teu projeto para a pasta do Apache
COPY . /var/www/html/

# Expõe a porta 80 (web)
EXPOSE 80