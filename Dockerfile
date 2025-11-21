ARG WP_VERSION
ARG PHP_VERSION

FROM wordpress:${WP_VERSION}-${PHP_VERSION}-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libmagickwand-dev \
    libzip-dev \
    libicu-dev \
    --no-install-recommends

# FIX IS HERE: We added "(... || true)"
# This prevents the build from crashing if Imagick is already present
RUN (pecl install imagick || true) \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install zip intl

# Cleanup to keep image small
RUN apt-get clean && rm -rf /var/lib/apt/lists/*