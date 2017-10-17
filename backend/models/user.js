var mongoose = require('mongoose')
  , Schema = mongoose.Schema;

var userSchema = new Schema({
    Username:  String,
    Password: String,
});

module.exports = mongoose.model('users', userSchema);