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

app.get('/admin', function (req, res) {
    res.sendFile(__dirname + '/admin.html');
});

io.on('connection', function (socket) {
    socket.on('add marker', function (marker) {
        console.log('New marker added: ' + marker);
        markers.push(marker);
        io.emit('add marker', marker);
    });

    socket.on('delete marker', function (marker) {
        console.log('marker to delete: ' + marker);
        for (var i = 0; i < markers.length; i++) {
            if (marker.lat === markers[i].lat
                && marker.lng === markers[i].lng) {

                markers.splice(i, 1);
            }
        }
        io.emit('delete marker', marker);
    });

    socket.emit('init');

    markers.forEach(function (marker) {
        socket.emit('add marker', marker);
    });
});

http.listen(3000, function () {
    console.log('listening on *:3000');
});
