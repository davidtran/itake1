var socket, chat, userList, userData;

if(!String.prototype.trim) {
    String.prototype.trim = function () {
        return this.replace(/^\s+|\s+$/g,'');
    };
}

(function(document, window, $) {
    $(document).ready(function() {
        docReady();
    });

    function docReady() {
        chat = $('#chat');
        userList = $('.userList');

        try {
            socket = io.connect(baseUrl + ':7777', {
                'sync disconnect on unload': false
            });
            
            socket.on('getId', function(data) {
                //client will listen for messages here:
                socket.on(data, function(msg) {
                    buildChatWindow(msg.from, msg.nickname);
                    $('#chat_' + msg.from + ' .chat').append("<div class='userMessage'>" + msg.msg + "</div>").scrollTop(1000);
                });
            });
            
            socket.on('disconnect', function(data) {
                //alert("DESCONECTOU ");
                socket.disconnect();
            });
            
            socket.on('disconnection', function(data) {
                //alert("DESCONECTOU ION");
            });
            
            socket.on('reconnect', function(data) {
               // alert("RECONECTOU ");
            });

            
            socket.on('msg', function(msg) {
                var msgClass = "userMessage";
                if(msg.isSystemMessage) {
                    msgClass = "sysMessage";
                }
            
                if(msg.nickname) {
                    buildChatWindow(msg.from, msg.nickname);
                    $('#chat_' + msg.from + ' .chat').append("<div class='"+msgClass+"'>" + msg.msg + "</div>").scrollTop(1000);
                }
            });

            socket.on('loopback', function(msg) {
                var msgClass = "myMessage";
                if(msg.isSystemMessage) {
                    msgClass = "sysMessage";
                }
            
                buildChatWindow(msg.from);
                $('#chat_' + msg.from + ' .chat').append("<div class='" + msgClass + "'>" + msg.msg + "</div>").scrollTop(1000);
            });
            
            socket.on('loginFailed', function(data) {
                alert('Login failed. Please try again');
            });
            
            socket.on('loginOk', function(data) {
                userData = data;
                $('#frmLogin').hide();
            });
            
            socket.on('userList', function(data) {
                var buffer = "",
                friends = data.friends,
                userId = data.userId;
                
                for(var i = 0; i < friends.length; i++) {
                    if(userData.id === friends[i].id) {
                        continue;
                    }
                
                    buffer += "<li><a href='#' data-id='" + friends[i].id + "' class='startChat'>" + friends[i].nickname + "</a></li>";
                }
                
                userList.empty().append(buffer);
                
                if(friends.length) {
                    userList.css('visibility', 'visible');
                }
                
                
            });
            socket.emit('login', {nickname: user_username, id: user_userid});
            $(document).on('keyup', '.msg', function(ev) {
                var k = ev.which || ev.keyCode;
                if(k === 13 && this.value.trim()) {
                    sendMsg.call(this);
                }
            });
        } catch(err) {
            alert('erro ao contactar o servidor de chat: ' + err);
        }
    }
    
    function sendMsg(msg) {
        var container = $(this).parents('.chatContainer');
        socket.emit('talkTo', {id: $(this).data('id'), msg: this.value});
        this.value = '';
    }
    
    function buildChatWindow(userId, username) {
        var theId = 'chat_' + userId;
        
        if(!$('#' + theId).length) {
            var newChat = $('.chatContainer:first').clone();
            newChat[0].id = 'chat_' + userId;
            $('.msg', newChat).attr('data-id', userId);
            $('.title .friend', newChat).html(username);
            $('.startVideo', newChat).attr('data-id', userId);
            $('#message').append(newChat);
        }
    
        $('#' + theId).show('fast');
    }
    
    /********************bindings********************/
    
    $('.userList').on('click', '.startChat', function() {
        buildChatWindow($(this).data('id'), this.innerHTML);
        $('#chat_' + $(this).data('id') + ' .msg').focus();
    });
    
    $(document).on('click', '.closeWin', function() {
        $(this).parents('.chatContainer').hide('fast');
    });
    
})(document, window, jQuery);