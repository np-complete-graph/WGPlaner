const mysqlModel = require('mysql-model');

var databaseConnection = mysqlModel.createConnection({
	host     : 'localhost',
	user     : 'root',
	password : 'quiscustodies',
	database : 'WGPlanerV2',
});

var User = databaseConnection.extend({
	tableName: "users",
});

var LoginAttempt = databaseConnection.extend({
	tableName: "login_attempts",
});

exports.User = function(){
	return new User();
};

exports.LoginAttempt = function(){
	return new LoginAttempt();
}

exports.databaseConnection = databaseConnection;
