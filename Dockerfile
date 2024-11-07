FROM php:8.3-fpm

# Установка системных зависимостей и PHP расширений
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    netcat-traditional \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql sockets \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV NVM_DIR /usr/local/nvm
RUN mkdir -p $NVM_DIR
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash
ENV NODE_VERSION v20.13.1
RUN /bin/bash -c "source $NVM_DIR/nvm.sh && nvm install $NODE_VERSION && nvm use --delete-prefix $NODE_VERSION"

ENV NODE_PATH $NVM_DIR/versions/node/$NODE_VERSION/lib/node_modules
ENV PATH      $NVM_DIR/versions/node/$NODE_VERSION/bin:$PATH

# Установка рабочей директории
WORKDIR /var/www

# Копирование остальных файлов приложения
COPY . .

# Обеспечение наличия скрипта entrypoint и установка прав
RUN chmod +x /var/www/docker-entrypoint.sh

# Точка входа и команда
ENTRYPOINT ["/var/www/docker-entrypoint.sh"]
CMD ["php-fpm"]
