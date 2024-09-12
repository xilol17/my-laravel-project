# 使用官方 PHP 镜像作为基础镜像
FROM php:8.1-fpm

# 安装系统依赖和 PHP 扩展
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

# 设置工作目录
WORKDIR /var/www/html

# 复制应用代码到容器中
COPY . .

# 安装 Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 安装项目依赖
RUN composer install

# 生成应用密钥
RUN php artisan key:generate

# 暴露容器的 9000 端口
EXPOSE 9000

# 启动 PHP-FPM 服务
CMD ["php-fpm"]
