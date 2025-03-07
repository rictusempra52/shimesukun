FROM php:8.2-fpm

# システムの依存関係をインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    tesseract-ocr \
    tesseract-ocr-jpn \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Node.jsとnpmのインストール
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# アプリケーションのワーキングディレクトリを設定
WORKDIR /var/www

# ユーザーを追加
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# ファイルの所有者を変更
COPY . /var/www
RUN chown -R www:www /var/www

# PHP-FPMの設定を変更
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# アップロードサイズの制限を変更
RUN echo "upload_max_filesize = 10M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 10M" >> /usr/local/etc/php/conf.d/uploads.ini

# ユーザーを変更
USER www

# ポート9000を開放
EXPOSE 9000

CMD ["php-fpm"]
