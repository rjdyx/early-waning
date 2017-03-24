import { createWebSocketServer } from './websocket.js'

let messageIndex = 0

function createMessage(type, data) {
    messageIndex ++
    return JSON.stringify({
        id: messageIndex,
        type: type,
        // user: user,
        data: data
    })
}

function onConnect() {
    let user = this.user
    // let msg = createMessage('join', user, `${user.name} joined.`)
    let msg = createMessage('join', user, ` joined.`)
    this.wss.broadcast(msg)
    // build user list:
    let users = this.wss.clients.map(function (client) {
        return client.user
    });
    this.send(createMessage('list', user, users))
}

function onMessage(message) {
    if (message && message.trim()) {
        this.wss.broadcast(message)
    }
}

function onClose() {
    this.wss.broadcast(JSON.stringify({event: null, broadcast: []}))
}

let wss = createWebSocketServer(onConnect, onMessage, onClose)

console.log('app started at port 3000...')
