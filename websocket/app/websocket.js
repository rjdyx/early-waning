import { parseCookie } from './util.js'

const url = require('url')

const ws = require('ws')

const WebSocketServer = ws.Server

const axios = require('axios')

export function createWebSocketServer(onConnection, onMessage, onClose, onError) {
    let wss = new WebSocketServer({
        host: 'www.earlywarning.com',
        port: 3000
    });
    wss.broadcast = function broadcast(data) {
        wss.clients.forEach(function each(client) {
            let s = JSON.parse(data);
            for(let user of s.broadcast){
                if(user.id == client.user.role_id && 
                    user.name == client.user.role_name && 
                    user.role == client.user.role) {
                    client.send(JSON.stringify(s.event))
                }
            }
            
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


        if (location.pathname !== '/ws/chat') {
            // close ws:
            ws.close(4000, 'Invalid URL')
        }
        // check user:
        let cookie = parseCookie(ws.upgradeReq)
        if (!cookie) {
            ws.close(4001, 'Invalid user')
        }

        if(!ws.user) {
            console.log('in');
            axios.get('http://www.earlywarning.com/admin/ws/getUser',
            {
                headers: {
                    Cookie: cookie
                }
            })
                .then((res) => {
                    if(res.data.active == 0) {
                        ws.user = res.data
                    }else {
                        ws.close(4001, 'Invalid user')
                    }
                })
                .catch((error) => {
                    ws.close(4001, 'Invalid user')
                })
        }
        

        ws.cookie = cookie
        ws.wss = wss
        // onConnection.apply(ws)
    });
    console.log('WebSocketServer was attached.')
    return wss
}