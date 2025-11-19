# Base image PHP
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    npm \
    openjdk-11-jdk \
    wget \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy composer files first (for caching)
COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

# Copy Node files and install dependencies
COPY package.json package-lock.json ./
RUN npm ci

# Install ESLint globally
RUN npm install -g eslint

# Install OWASP ZAP (Headless / Daemon mode)
RUN wget https://github.com/zaproxy/zaproxy/releases/download/v2.15.0/ZAP_2_15_0_Linux.tar.gz \
    && tar -xvzf ZAP_2_15_0_Linux.tar.gz -C /opt/ \
    && rm ZAP_2_15_0_Linux.tar.gz
ENV PATH="/opt/ZAP_2_15_0:$PATH"

# Copy the rest of the application
COPY . .

# Set ownership and permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Expose PHP-FPM port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
