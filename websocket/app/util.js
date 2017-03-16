const Cookies = require('cookies')


export function parseCookie(obj) {
    if (!obj) {
        return
    }
    let laravelCookie = ''
    if (typeof obj === 'string') {
        laravelCookie = obj
    } else if (obj.headers) {
        let cookies = new Cookies(obj, null)
        laravelCookie = 'XSRF-TOKEN=' + cookies.get('XSRF-TOKEN') + "; laravel_session=" + cookies.get('laravel_session')
    }
    if (laravelCookie) {
        try {
            return laravelCookie
        } catch (e) {
            // ignore
        }
    }
}