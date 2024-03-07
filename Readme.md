### 打包镜像

```
# 在打包镜像之前，先运行镜像，构建容器
docker-compose up -d

docker save -o huaqinggong.tar hqg-mysql:8.2 hqg-nginx:1.25.3 hqg-node:20 hqg-php:8.3 hqg-redis:7.2
```

### 命令

**make** 直接命令，会输出提示。

使用的话，一些命令有先后顺序。有一些命令会重复使用到。一般，**make up**命令会是第一个命令，只有有了环境，才好干事情。**make laravel** 会是第二个命令。创建好了环境，才可以创建项目。

这里把命令再列一遍。

|命令|参数|说明|
|--|--|--|
|make|无|命令提示，相当于 help|
|make up|无|创建镜像，生成容器。第一次生成镜像会久一点，后边会好一些|
|make status|无|查看容器|
|make down|无|删除容器|