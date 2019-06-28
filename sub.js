var Redis = require("ioredis");
var fs = require("fs");

var client1 = new Redis('redis://redis:6379/0');
var client2 = new Redis('redis://redis:6379/0');

var len = 0;
client1.on("message", function (channel, message) {
    console.log(channel + ": " + message);
    getValue(channel);
});

//var myDate = new Date();  //获取当前时间
//console.log(myDate);

client1.subscribe("usr");
client1.subscribe("like");
client1.subscribe("dislike");
client1.subscribe("test-channel");

function getValue(channel)
{
    client2.llen(channel,function(err,reply){ //回调函数形式获取结果，可以使用redis.print来查看结果
        //console.log(reply);
        var client = new Redis('redis://redis:6379/0');
        for(var i=0;i<reply;i++)
        {
            client.rpop(channel,function(err,reply){
                console.log(reply);
            });
        }
    });
}

