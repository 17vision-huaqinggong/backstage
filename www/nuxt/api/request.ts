const baseURL = 'http://localhost:8580/admin/api'

function getUser() {
    return useUser()
}

function useHeaders() {
    if (getUser().token) {
        return {
            Authorization: `Bearer ${getUser().token}`
        }
    }
    return {}
}

const request = async (url:string, options:Record<string, any>) => {
    options.headers = useHeaders()
    options.baseURL = baseURL
    return new Promise((resolve, reject) => {
        useFetch(url, {...options}).then(({data, error}) => {
            if (error && error.value) {
                const useError = error.value as { [key: string]: any };  
                if (useError.statusCode === '401') {
                    getUser().exit()
                    navigateTo('/login')
                }
                return reject(useError.data)
            }
            resolve(data.value)
        })
    })
}

export default request