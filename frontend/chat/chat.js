var config = {host:'localhost',
              user: 'root',
              password: '123456',
              database: 'itake'};
var mysql      = require('mysql');

var connection = mysql.createConnection(config);
    connection.connect(function(err) {
      // connected! (unless `err` is set)
    });

function closeConnection(){
  connection.end();
}

function insert(data){
  connection.query('INSERT IGNORE INTO `mp_chat` SET ?', data, function(err, results){
    if (err) {
      console.log(err);
    } else{
      return results;
    };    
  });
}

function get(sender_id, user_id, callback){
  select1 = "SELECT * FROM mp_chat WHERE sender_id = " + sender_id + " AND receiver_id = " + user_id ;
  select2 = "SELECT * FROM mp_chat WHERE sender_id = " + user_id + " AND receiver_id = " + sender_id ;
  select = select1 + " UNION " + select2 + " ORDER BY id ASC LIMIT 10";
  connection.query(select, function(err, results, fields){
        if (err) {
            throw err;
        }
        for (var i = 0; i < results.length; i++) {
          callback(results[i], sender_id);
        };
    });
}

function update(){
  query = "UPDATE `mp_chat` SET ";

}


/*==========================================================================================*/

var io = require('socket.io').listen(1111, {
    transports: ['websocket', 'flashsocket', 'htmlfile', 'jsonp-polling', 'xhr-polling']
}),
users = [];

//lista de usuarios logados
var loggedUsers = {};

//lista de par chave ID do banco - valor: session id
var usersMap = {};

io.sockets.on('connection', onConnection);

function onConnection(socket) {
    socket.on('disconnect', onDisconnect);
    bindEvents(socket);
}

function bindEvents(socket) {
    socket.emit('getId', socket.id);
    socket.on('msg', onMsg);
    socket.on('login', onLogin);
    socket.on('talkTo', onTalkTo);
    socket.on('confRequest', onConfRequest);
    socket.on('loadmsg', onLoadmsg);
}

function onDisconnect(data) {
    var socket = this;
    
    if(loggedUsers[socket.id]) {
    
        socket.emit('loopback', {isSystemMessage: true, msg: "You have been disconnected. Please, relog", from: -999});
        socket.broadcast.emit('msg', 'SYSTEM: ' + loggedUsers[socket.id].nickname + ' has left');
        delete usersMap[ loggedUsers[socket.id].id ];
        delete loggedUsers[socket.id];
        getUserList(socket);
    }
}

function onMsg(data) {
    var socket = this;
    var nickname = getVar(socket, 'nickname');
    
    if(nickname) {
        socket.broadcast.emit('msg', nickname + ': ' + data);
    } else {
        socket.emit('msg', 'SYSTEM: you are not logged. please do it');
    }
}

function onLogin(data) {
    var socket = this;
    var nickname = getVar(socket, 'nickname');
    
    if(nickname) {
        socket.emit('loginFailed', 'SYSTEM: you are already logged');
        return;
    }

    loggedUsers[socket.id] = {nickname: data.nickname, id: data.id, socket: socket};
    usersMap[data.id] = socket.id;
    
    socket.set('dbId', data.id, function() {});
    
    socket.set('nickname', data.nickname, function() {
        socket.emit('loginOk', {id: data.id});
        getUserList(socket);
    });
}

function getVar(socket, varname) {
    var result;
    socket.get(varname, function(err, data) {
        if(err) {
            throw err;
        } else {
            result = data;
        }
    });
    return result;
}

function getUserList(s) {
    var users = [],
    dbId = getVar(s, 'dbId');
    
    for(k in loggedUsers) {
        users.push({id: loggedUsers[k].id, nickname: loggedUsers[k].nickname});
    }
    s.emit('userList', {friends: users, userId: dbId});
    s.broadcast.emit('userList', {friends: users, userId: dbId});
}

function onTalkTo(data) {
    var socket = this, sessId = usersMap[data.id], msg;
    var receiver;
    
    if(sessId && data.msg) {
        receiver = loggedUsers[sessId].socket;
        msg = noTag(data.msg);
        post = {'sender_id' : getVar(socket, 'dbId'),
            "body" : msg,
            "receiver_id": data.id,
            "date": new Date()
          };
        insert(post);
        socket.emit('loopback', {msg: msg, from: data.id});
        receiver.emit('msg', {msg: msg, nickname: getVar(socket, 'nickname'), from: getVar(socket, 'dbId')});
    }
}

function onConfRequest(data) {
    var socket = this, sessId = usersMap[data.id], msg;
    var receiver;
    if(sessId && data.url) {
        receiver = loggedUsers[sessId].socket;
        msg = '<a href="' + data.url + '" target="_blank">' + getVar(socket, 'nickname') + ' wants to start a video conference with you</a>';
        receiver.emit('msg', {isSystemMessage: true, msg: msg, nickname: getVar(socket, 'nickname'), from: getVar(socket, 'dbId')});
        socket.emit('loopback', {isSystemMessage: true, msg: 'Your invitation for video conference was sent', from: data.id});
    }
}

function noTag(msg) {
    return msg.replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

function onLoadmsg(data){
    var socket = this;
    console.log(data.id);
    console.log(getVar(socket, 'dbId'));
    get(data.id, getVar(socket, 'dbId'), function(row, user_id){
        resultHtml = "<div class='";
        if (row.sender_id == user_id) {
            resultHtml += "userMessage'>";
        } else{
            resultHtml += "myMessage'>";
        };
        resultHtml += row.body + "</div>";
        socket.emit('msgReceive',{content: resultHtml, id: user_id});
    });
}