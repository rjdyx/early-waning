import { createWebSocketServer } from './websocket.js'

let messageIndex = 0

function createMessage(type, user, data) {
    messageIndex ++
    return JSON.stringify({
        id: messageIndex,
        type: type,
        user: user,
        data: data
    })
}

function onConnect() {
    let user = this.user
    let msg = createMessage('join', user, `${user.name} joined.`)
    this.wss.broadcast(msg)
    // build user list:
    let users = this.wss.clients.map(function (client) {
        return client.user
    });
    this.send(createMessage('list', user, users))
}

function onMessage(message) {
    console.log(message)
    if (message && message.trim()) {
        let msg = createMessage('chat', this.user, message.trim())
        this.wss.broadcast(msg)
    }
}

function onClose() {
    let user = this.user
    let msg = createMessage('left', user, `${user.name} is left.`)
    this.wss.broadcast(msg)
}

let wss = createWebSocketServer(onConnect, onMessage, onClose)

console.log('app started at port 3000...')
