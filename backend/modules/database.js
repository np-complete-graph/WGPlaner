var mongoose = require('mongoose');
var dbURI = 'mongodb://localhost/WGPlanerV2';
var options = {}
mongoose.connect(dbURI);

mongoose.connection.on('connected', function () {  
  console.log('Mongoose default connection open to ' + dbURI);
}); 

// If the connection throws an error
mongoose.connection.on('error',function (err) {  
  console.log('Mongoose default connection error: ' + err);
}); 

// When the connection is disconnected
mongoose.connection.on('disconnected', function () {  
  console.log('Mongoose default connection disconnected'); 
});

var db = mongoose.connection;

var userSchema = new mongoose.Schema({
    Username:  String,
    Password: String,
});

var loginAttemptSchema = new mongoose.Schema({
    IpAddress:  String,
    NumAttempts: {type: Number, min:0},
    Timestamp : {type: Date},
    Username: String
});

module.exports.User = db.model('User', userSchema);
module.exports.LoginAttempt = db.model("LoginAttempt", loginAttemptSchema);