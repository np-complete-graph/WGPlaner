const express = require('express');
const app = express();
const router = express.Router();
const jwt = require('jsonwebtoken');

const databaseModule = require('./database.js');
const utilsModule = require('./utilsModule.js');

const databaseConnection = databaseModule.databaseConnection;

router.post('/', function(req, res){

	var userModel = databaseModule.User();

	let username = req.body.username;
	let password = req.body.password;

	userModel.find('all', {where: `Username = '${username}'`}, function(err, rows) {
		//TODO check login
		if (err) console.log(err);
		if(rows.length == 1){
			var user = rows[0];
			console.log(user);

			var claims = {
				roles: user.Roles
			}

			//TODO: define token lifetime
			var token = jwt.sign(claims, "test", {
				expiresIn : "3000s"
			});
			res.send({'token': token});
		} else {
			//TODO save ip in database
			/*var ip = req.headers['x-forwarded-for'] || 
			req.connection.remoteAddress || 
			req.socket.remoteAddress ||
			req.connection.socket.remoteAddress;
			var loginAttempt = tabaseModule.LoginAttempt();
			loginAttempt.read(ip);;*/
			utilsModule.sendError(res, 400, "Wrong credentials");
		}
	});
});

exports.validateToken = function(req, res){
	if (req.headers.hasOwnProperty('token')){
		var token = req.headers.token;
		jwt.verify(token, 'test', function(err, decoded) {
			if (err){
				utilsModule.sendError(res, 405, "Session expired");
				return false;
			} 
		});
	} else {
		utilsModule.sendError(res, 401, "Authorization required!");
		return false;
	}
	return true;
}

exports.router = router;


