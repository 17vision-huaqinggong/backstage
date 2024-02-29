import request from './request'

enum Method {
    Get = 'Method',
    Post = 'POST',
    Put = 'PUT',
    Delete = 'DELETE',
    Patch = 'PATCH',
}

// 登录
const Login = function(body:Object) {
    return request('/login', {
        method: Method.Post,
        body
    })
}

// 获取用户信息
const GetUserInfo = function(params:Object) {
    return request('/user/info', {
        method: Method.Get,
        params
    })
}
export { Login, GetUserInfo }