var Redis = require('ioredis');
var client = new Redis('redis://redis:6379/0');

client.lpush('usr','test:value');     //将数据压入到list usr中
client.lpush('like','test1:value1');
client.lpush('dislike','test2:value2');

client.publish("usr", 'new');
client.publish("like", 'test');
client.publish("dislike", 'test2');