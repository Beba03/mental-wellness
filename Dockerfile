# Use an official PHP image with Apache
FROM php:8.0-apache

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli

# Copy the website files to the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html/

# Set the ServerName to suppress warnings
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set Landing.php as the default page
RUN echo "DirectoryIndex PHP/Landing.php" > /etc/apache2/conf-available/landing.conf
RUN a2enconf landing

# Expose port 80
EXPOSE 80