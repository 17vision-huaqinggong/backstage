import request from "./request";

enum Method {
  Get = "Method",
  Post = "POST",
  Put = "PUT",
  Delete = "DELETE",
  Patch = "PATCH",
}

// 登录
const Login = function (body: Object) {
  return request("/login", {
    method: Method.Post,
    body,
  });
};

// 获取用户信息
const GetUserInfo = function (params: Object) {
  return request("/user/info", {
    method: Method.Get,
    params,
  });
};

// 获取基础统计
const GetDeciveBase = function (body: Object) {
  return request("/device/base", {
    method: Method.Post,
    body,
  });
};

// 获取详细统计
const GetDeciveDetail = function (body: Object) {
  return request("/device/detail", {
    method: Method.Post,
    body,
  });
};

export { Login, GetUserInfo, GetDeciveBase, GetDeciveDetail };
