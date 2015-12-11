var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.get('/', function(req, res){
    res.sendFile(__dirname + '/index.html');
});

io.on('connection', function(socket){
  socket.on('send object', function(object){
    console.log('New object added: ' + object);
    io.emit('send object', object);
  });

  socket.on('delete object', function(object){
    console.log('object to delete: ' + object);
    io.emit('delete object', object);
  });
});

http.listen(3000, function() {
    console.log('listening on *:3000');
});
