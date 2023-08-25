FROM php:8.1-fpm

# Set the working directory in the container
WORKDIR /app

# Install PHP extensions and dependencies
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath opcache \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && apt-get install -y libxml2-dev \
    && docker-php-ext-install xml \
    && apt-get install -y libcurl4-openssl-dev \
    && docker-php-ext-install curl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files to the container
COPY composer.json ./

# Install project dependencies
RUN composer install --prefer-dist --no-scripts --no-autoloader --no-dev

# Copy the rest of the project files to the container
COPY . .

# Generate the autoload files
RUN composer dump-autoload --no-scripts --no-dev --optimize

# Set the command to run the Laravel app
CMD php artisan serve --host=0.0.0.0 --port=8000
