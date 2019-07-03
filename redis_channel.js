const WebSocket = require('ws');
const Redis = require("ioredis");

const redis = new Redis('redis://redis:6379/0');
const wss = new WebSocket.Server({ port: 6003 });
const clients = {};
// Broadcast to all.
wss.broadcast = function broadcast(data) {
    wss.clients.forEach(function each(client) {
        if (client.readyState === WebSocket.OPEN) {
            client.send(data);
        }
    });
};

redis.on("message", function (channel, message) {
    message = JSON.parse(message);
    channel = message['channel']['name'];
    let data = message['data'];
    let socket = clients[channel];
    if(socket && channel)
        clients[channel].send(JSON.stringify(data));
    console.log(typeof message, message);
});
redis.subscribe("broadcast");

wss.on('connection', function connection(ws, request) {
    clients[request.headers['channel']] = ws;
    ws.on('message', function incoming(data) {
        // Broadcast to everyone else.
        if(clients[data['to']]) {
            clients[data['to']].send(data);
        }
    });
});
