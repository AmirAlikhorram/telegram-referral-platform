FROM registry2.iran.liara.ir/platforms/laravel-platform:release-2025-07-03T10-46-php8.3

RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && node -v \
    && npm -v
