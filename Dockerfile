# Use the official PHP 8.1 image from the dockerhub
FROM php:8.1-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    cron \
 && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy Laravel project files
COPY . /var/www

# Copy environment file
COPY .env.example .env

# Install dependencies and generate autoload files
RUN composer install --no-interaction --optimize-autoloader --no-dev --ignore-platform-reqs

# Generate Laravel encryption key
RUN php artisan key:generate

# Setup the cron job for Laravel's schedule:run command
RUN echo "* * * * * root /usr/local/bin/php /var/www/artisan schedule:run >> /var/log/cron.log 2>&1" > /etc/cron.d/laravel-scheduler

# Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/laravel-scheduler

# Create the log file to be able to run tail
RUN touch /var/log/cron.log



# Change ownership of the project directory
RUN chown -R www-data:www-data /var/www

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Run the command on container startup
CMD cron && php-fpm
