# Запуск контейнеров
up:
	docker-compose up -d

# Остановка контейнеров
down:
	docker-compose down

# Просмотр логов
logs:
	docker-compose logs -f

# Выполнение команд внутри контейнера приложения
exec-app:
	docker-compose exec app bash

# Выполнение команд внутри контейнера базы данных
exec-db:
	docker-compose exec db bash
