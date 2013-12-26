var params      = require('./config.js');
var mysql       = require('mysql');
var connection  = mysql.createConnection(params.dbParams());


exports.connect = function () {
    connection.connect(function(err) {
        if (err) {
            return false;
        } else {
            return true;
        };
    });
};

exports.endconnect = function () {
    connection.end();
};

exports.update = function (data) {
  
};

exports.insert = function (data) {
    connection.query('INSERT IGNORE INTO `mp_chat` SET ?', data, function(err, results){
        if (err) {
          throw err;
        }    
      });
};

exports.delete = function (id) {
    select = "DELETE FROM mp_chat WHERE id = " + id ;
    connection.query(select, function(err, results, fields){
        if (err) {
            throw err;
        }
    });
};

exports.select = function (sender_id, receiver_id, callback) {
    select1 = "SELECT * FROM mp_chat WHERE sender_id = " + sender_id + " AND receiver_id = " + receiver_id ;
    select2 = "SELECT * FROM mp_chat WHERE sender_id = " + receiver_id + " AND receiver_id = " + sender_id ;
    select = select1 + " UNION " + select2 + " ORDER BY id ASC LIMIT " + params.chatParams().limit;
    connection.query(select, function(err, results, fields){
        if (err) {
            throw err;
        }
        for (var i = 0; i < results.length; i++) {
          callback(results[i], sender_id);
        };
    });
};
