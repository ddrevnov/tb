var app = require('express')();
var fs = require('fs');

var options = {
    key: fs.readFileSync('/ssl.timebox24.key', 'utf8'),
    cert: fs.readFileSync('/ssl.timebox24.crt', 'utf8'),
    requestCert: true
};
var server = require('https').createServer(options, app);
var io = require('socket.io').listen(server);
var redis = require('redis');

var data = fs.readFileSync('./config.json'),
    myObj;

config = JSON.parse(data);
console.log("port: "+config.port);
var users = {};
var lastMessage = {};

server.listen(config.port);
io.on('connection', function (socket) {
    console.log('server connected');

    socket.on('regUser', function(event) {
        console.log('regUser init', event.data);
        event.data.socketId = socket.id;
        users[event.data.userId] = (event.data);

        console.log('event', event.data);
        console.log('users', users);
    });

    var redisClient = redis.createClient(config.redisPort);
    redisClient.subscribe('message');
    redisClient.subscribe('new_message');

    redisClient.on("message", function(channel, message) {
        console.log('message', message);
        console.log('channel', channel);

        if(channel=='new_message'){
            if(message===lastMessage){
                return;
            }else {
                lastMessage = message;
            }
            message= JSON.parse(message);
            console.log('new_message', message);

            console.log('users', users);

            if(users[message.to] === undefined) return;

            var socketid = users[message.to].socketId;
            //console.log(123);
            io.sockets.connected[socketid].emit(channel, message);
        }else {
            console.log(channel, message);
            socket.emit(channel, message);
        }
    });
    socket.on('disconnect', function() {
        redisClient.quit();
    });
});