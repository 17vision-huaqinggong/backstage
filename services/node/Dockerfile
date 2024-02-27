# syntax=docker/dockerfile:1

ARG IMAGE
FROM ${IMAGE}

# 配置镜像安装项目依赖
RUN npm config set registry  https://registry.npmmirror.com

# 安装 pnpm
RUN npm install -g pnpm

# 给 pnpm 配置镜像
RUN pnpm config set registry https://registry.npmmirror.com

WORKDIR /www/nuxt