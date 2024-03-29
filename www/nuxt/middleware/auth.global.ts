function getUser() {
    return useUser()
}

export default defineNuxtRouteMiddleware((to, from) => {
    if (!getUser().token && to.path !== '/login') {
      return navigateTo('/login?from=' + to.fullPath)
    }

    if (to.path === '/') {
      return navigateTo('/museum')
    }
})