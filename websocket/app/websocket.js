import { parseUser } from './util.js'

const url = require('url')

const ws = require('ws')

const WebSocketServer = ws.Server

const axios = require('axios')

export function createWebSocketServer(onConnection, onMessage, onClose, onError) {
    let wss = new WebSocketServer({
        port: 3000
    });
    wss.broadcast = function broadcast(data) {
        wss.clients.forEach(function each(client) {
            client.send(data)
        });
    };
    onConnection = onConnection || function () {
        console.log('[WebSocket] connected.')
    };
    onMessage = onMessage || function (msg) {
        console.log('[WebSocket] message received: ' + msg)
    };
    onClose = onClose || function (code, message) {
        console.log(`[WebSocket] closed: ${code} - ${message}`)
    };
    onError = onError || function (err) {
        console.log('[WebSocket] error: ' + err)
    };
    wss.on('connection', function (ws) {
        let location = url.parse(ws.upgradeReq.url, true);
        console.log('[WebSocketServer] connection: ' + location.href)
        ws.on('message', onMessage)
        ws.on('close', onClose)
        ws.on('error', onError)

        axios.get('http://www.earlywarning.com/admin/org/query')
            .then((responce) => {
                console.log(responce.data)
            })

        if (location.pathname !== '/ws/chat') {
            // close ws:
            ws.close(4000, 'Invalid URL')
        }
        // check user:
        let user = parseUser(ws.upgradeReq)
        if (!user) {
            ws.close(4001, 'Invalid user')
        }
        ws.user = user
        ws.wss = wss
        onConnection.apply(ws)
    });
    console.log('WebSocketServer was attached.')
    return wss
}