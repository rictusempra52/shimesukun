FROM php:8.2-fpm

# システムの依存関係をインストール
RUN apt-get update && apt-get install -y --no-install-recommends \
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
    && rm -rf /var/lib/apt/lists/*

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Node.jsとnpmのインストール
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# アプリケーションのワーキングディレクトリを設定
WORKDIR /var/www

# ユーザーを追加
RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www

# ⬇ chownを削除して、COPY時に適用
COPY --chown=www:www . /var/www

# PHP-FPMの設定を変更
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# アップロードサイズの制限を変更
RUN echo "upload_max_filesize = 10M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 10M" >> /usr/local/etc/php/conf.d/uploads.ini

# Git情報を記録
ARG GIT_COMMIT
RUN echo "Build from commit: $GIT_COMMIT"

# ユーザーを変更
USER www

# ポート9000を開放
EXPOSE 9000

CMD ["php-fpm"]
