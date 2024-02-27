all: help

help: 
	@echo "支持以下命令"
	@echo "make up                      # 创建镜像，生成容器"
	@echo "make status                  # 查看容器"
	@echo "make down                    # 删除容器"

up:
	@docker-compose up -d
	@chmod 777 ./logs/redis

status:
	@docker-compose ps

down:
	@docker-compose down