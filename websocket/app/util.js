const Cookies = require('cookies')


export function parseUser(obj) {
    if (!obj) {
        return
    }
    console.log('try parse: ' + obj)
    let s = ''
    if (typeof obj === 'string') {
        s = obj
    } else if (obj.headers) {
        let cookies = new Cookies(obj, null)
        
        let s1 = cookies.get('XSRF-TOKEN')
        let s2 = cookies.get('laravel_session')
        s = cookies.get('name')
        console.log(s1)
        console.log(s2)
        console.log(s)
    }
    if (s) {
        try {
            let user = JSON.parse(Buffer.from(s, 'base64').toString())
            console.log(`User: ${user.name}, ID: ${user.id}`)
            return user
        } catch (e) {
            // ignore
        }
    }
}