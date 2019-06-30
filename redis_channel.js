var app   = require('express');
var http  = require('http').Server(app);
var io    = require('socket.io')(http);
var Redis = require('ioredis');
const PROTOCOL = 6002;

/*
 * Your Redis connection
 * @see https://www.npmjs.com/package/ioredis for more details
 */
var redis = new Redis('redis://redis:6379/0');



/*
 * Your broadcasting emitter
 */
redis.on('message', function(channel, message){
    // message = JSON.parse(message);
    console.log('-------------------', channel, message);
    // io.emit(channel+':'+message.event, message.payload);
});

redis.on("error", function (err) {
    console.log("Error " + err);
});
redis.subscribe('test-channel');
/*
 * http server listen 6001
 */
http.listen(PROTOCOL, function(){
    console.log('Listen on 0.0.0.0:' + PROTOCOL);
});