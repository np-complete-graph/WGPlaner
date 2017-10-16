// REQUIREMENTS
const express           = require('express');
var config              = require('../config'); // get our config file
const router            = express.Router();
const jwt               = require('jsonwebtoken');
const jsesc             = require('jsesc');
const moment            = require('moment');
const async             = require('async');
var mysql               = require('mysql');
var CryptoJS            = require("crypto");
var mongoose            = require("mongoose");
const databaseModule    = require('./database.js');
const util              = require('util');
var User                = databaseModule.User;
var LoginAttempt        = databaseModule.LoginAttempt;

// IMPORTS
const utilsModule = require('./utilsModule.js');

// CONSTANTS

const numAttemptsThreshold = 3;
const lockDuration = '10';
const lockDurationUnit = 'seconds';

var ServerError = require('../models/server_error.js');

function isIPLocked(loginAttempt){
    console.log(loginAttempt);
    if (loginAttempt){
        // check if this ip is blocked for a certain amount
        var dateNow = moment(Date.now());
        var futureDate = moment(loginAttempt.Timestamp).add(lockDuration, lockDurationUnit);
        return (loginAttempt.NumAttempts >= numAttemptsThreshold) && (futureDate.diff(dateNow, lockDurationUnit) >= 0);
    }
    return false;
}

router.post('/', function(req, res, next){

    let username = jsesc(req.body.username);
    let password = CryptoJS.createHash("sha256").update(jsesc(req.body.password)).digest("hex");
    let ipaddress = req.connection.remoteAddress;

    User.find({Username: username, Password: password}, function(error, users){
        if (error) console.log(error);

        LoginAttempt.find({IpAddress : ipaddress}, function(error, loginAttempts){
            if (error) console.log(error);

            let loginAttempt = loginAttempts[0];

            let isLocked = false;
            if (loginAttempts.length == 1){
                isLocked = (users.length == 0 && (loginAttempt.NumAttempts >= numAttemptsThreshold));
                isLocked |= isIPLocked(loginAttempt); 
            }

            function returnError(){
                if (isLocked || (loginAttempt.NumAttempts >= numAttemptsThreshold)){
                    let futureDate =
                        moment(Date.now()).add(lockDuration, lockDurationUnit);
                    let messageText = util.format(ServerError.ACCOUNT_LOCKED_ERROR_MESSAGE, lockDuration, lockDurationUnit, futureDate.format("DD.MM.YYYY HH:mm:ss"));
                    return next(new ServerError(403, messageText, "LOGIN_ACCOUNT_LOCKED"));    
                }

                let remainingAttempts = (numAttemptsThreshold-loginAttempt.NumAttempts);
                return next(new ServerError(403, "Invalid credentials\r\n"+remainingAttempts+" attempts remaining!", "LOGIN_INVALID_CREDENTIALS")); 
            }

            if (isLocked){
                return returnError();
            }

            console.log(isLocked);

            if (users.length == 1){
                async.series([
                    function(callback){
                        if (loginAttempts.length == 1){
                            loginAttempt.NumAttempts = 0;
                            loginAttempt.save(callback());
                        } else {
                            callback();
                        }
                    },
                    function(callback){
                        user = users[0];

                        //Send User a token
                        let claims = {
                            roles: user.Roles
                        }

                        //TODO: define token lifetime
                        let token = jwt.sign(claims, "test", {
                            expiresIn : "3000s"
                        });
                        res.status(200);
                        res.send({'token': token}).end(callback);
                    }
                ]);
                return;
            }

            if (loginAttempts.length == 0){
                console.log("Created new login attempt entry for "+ipaddress);

                loginAttempt = new LoginAttempt();
                loginAttempt.Username = username;
                loginAttempt.IpAddress = ipaddress;
                loginAttempt.NumAttempts = 1;

                loginAttempt.Timestamp = Date.now();
                return loginAttempt.save(returnError);
            } else if (loginAttempts.length == 1){
                console.log("Update existing login attempt for "+ipaddress);

                loginAttempt.NumAttempts++;
                loginAttempt.Timestamp = Date.now();
                return loginAttempt.save(returnError);
            }
        })
    });
});

exports.validateToken = function(req, res, next){
    if (req.headers.hasOwnProperty('token')){
        let token = req.headers.token;
        jwt.verify(token, config.get('secret'), function(err, decoded) {
            if (err){
                return next(new ServerError(401, "Token expired", "LOGIN_INVALID_TOKEN"));
            } 
        });
    }
}

exports.router = router;


