const app   = require('express');
const http  = require('http').Server(app);
const io    = require('socket.io')(http);
const Redis = require('ioredis');

/*
 * Your Redis connection
 * @see https://www.npmjs.com/package/ioredis for more details
 */
const redis = new Redis('redis://47.100.255.104:6379/0');

redis.psubscribe('*', function(err, count) {
    //
    console.log(count);
});

redis.on('pmessage', function(subscribed, channel, message) {
    //message = JSON.parse(message);
    console.log("======message=======\n", message);
});