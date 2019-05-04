const app   = require('express');
const http  = require('http').Server(app);
const io    = require('socket.io')(http);
const Redis = require('ioredis');

/*
 * Your Redis connection
 * @see https://www.npmjs.com/package/ioredis for more details
 */
const redis = new Redis('redis://47.100.255.104:6379/0');

/**
 * Your broadcasting channel
 */
redis.subscribe('channel', function(err, count){
    console.log(count);
});

/*
 * Your broadcasting emitter
 */
redis.on('message', function(channel, message){
    try{
        message = JSON.parse(message);
        io.emit(channel+':'+message.event, message.payload);
    }catch (e) {
        console.log(e);
    }
});

/*
 * http server listen 8080
 */
http.listen(6001, function(){
    console.log('Listen on 0.0.0.0:6001');
});