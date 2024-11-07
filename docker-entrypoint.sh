#!/bin/sh

set -e

# Функция ожидания готовности сервиса
wait_for_service() {
  host=$1
  port=$2
  echo "Ожидание готовности $host:$port..."
  while ! nc -z $host $port; do
    sleep 1
  done
  echo "$host:$port готов."
}

# Установка зависимостей Composer
if [ -f composer.lock ]; then
  echo "Установка зависимостей Composer из composer.lock..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
else
  echo "composer.lock не найден. Установка зависимостей Composer..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Установка зависимостей node
npx playwright install-deps
npx playwright install

echo "Установка прав доступа"
chmod 777 /var/www/storage/logs
chmod 777 /var/www/resources/cache

# Запуск основного процесса
echo "Запуск основного процесса..."
exec "$@"
