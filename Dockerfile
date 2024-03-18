FROM ubuntu:20.04


# Add ondrej/php repository
RUN apt-get update && \
    apt-get install -y software-properties-common && \
    add-apt-repository -y ppa:ondrej/php && \
    apt-get update && \
    apt-get install -y php8.2-bcmath php8.2-imagick php8.2-redis

# Install PHP and nginx dependencies
RUN apt-get update && \
    apt-get install -y \
    nginx \
    php8.2 \
    php8.2-fpm \
    php8.2-mysql \
    php8.2-gd \
    php8.2-xml \
    php8.2-zip \
    php8.2-mbstring \
    php8.2-curl \
    php8.2-intl \
    php8.2-bcmath \
    php8.2-ldap \
    php8.2-gmp \
    php8.2-soap \
    php8.2-imagick \
    php8.2-redis \
    php8.2-xmlrpc \
    php8.2-tidy \
    php8.2-bz2 \
    php8.2-readline \
    php8.2-pspell \
    php8.2-sqlite3 \
    php8.2-odbc \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
    libwebp-dev \
    libxpm-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    nano \
    wget \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Add ondrej/php repository
RUN apt-get update && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Configure nginx
RUN echo "daemon off;" >> /etc/nginx/nginx.conf
COPY default /etc/nginx/sites-available/default

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Start services
CMD service php8.2-fpm start && nginx

EXPOSE 80

ADD app /var/www/html

RUN chmod -R 777 /var/www/html 

