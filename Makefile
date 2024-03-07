all: help

help: 
	@echo "支持以下命令"
	@echo "make up                      # 创建镜像，生成容器"
	@echo "make laravel                 # 安装 laravel 扩展，并执行迁移"
	@echo "make seed                    # 安装 执行 laravel 迁移"
	@echo "make status                  # 查看容器"
	@echo "make down                    # 删除容器"

up:
	@docker-compose up -d
	@chmod 777 ./logs/redis

laravel:
	@docker exec -it hqg-php8.3 bash
	@cd laravel && composer install && php artisan migrate:fresh --seed

seed:
	@docker exec -it hqg-php8.3 bash
	@cd laravel && php artisan db:seed --class=DeviceWearSeeder && php artisan db:seed --class=DeviceVisitSeeder

status:
	@docker-compose ps

down:
	@docker-compose down