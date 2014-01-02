exports.dbParams = function () {
  return {
  			host:'localhost',
            user: 'root',
            password: '123456',
            database: 'itake'
        };
};
exports.chatParams = function () {
  return {
  			limit:10,
  			port: 1111
        };
};

/*module.exports = function(config) {
  return {
    connect: function() {
      
    }
    disconnect: function(){

    }
    update: function(){

    }
    insert: function(){

    }
    delete: function(){

    }
  };
}*/