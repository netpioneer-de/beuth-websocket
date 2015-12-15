var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var beuthCoords = {lat: 52.545517, lng: 13.35162200000002};

var markers = [
    beuthCoords
];

app.get('/', function (req, res) {
    res.sendFile(__dirname + '/index.html');
});

io.on('connection', function (socket) {
    socket.on('message_send', function (message) {
        console.log('Message recieved: ' + message);
        io.emit('message_send', message);
    });
});

http.listen(3000, function () {
    console.log('listening on *:3000');
});
