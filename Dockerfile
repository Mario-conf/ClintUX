FROM php:8.3-fpm


RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    python3 \
    python3-pip \
    supervisor \
    docker.io \
    iputils-ping \
    nginx \
    && apt-get clean && rm -rf /var/lib/apt/lists/*


RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs


RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd opcache


RUN pip3 install docker psutil --break-system-packages


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


WORKDIR /var/www

COPY . .


COPY docker/nginx/default.conf /etc/nginx/sites-enabled/default


RUN chown -R www-data:www-data /var/www


COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh


EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
