// =======================
// get the packages we need ============
// =======================
var express     = require('express');
var app         = express();
var bodyParser  = require('body-parser');
var morgan      = require('morgan');
var cors 	    = require('cors')
var https       = require('https');
var http        = require('http');
var fs          = require('fs');
var util        = require('util')

var sslkey = fs.readFileSync('/etc/ssl/private/apache.key');
var sslcert = fs.readFileSync('/etc/ssl/certs/apache.crt')

var options = {
    key: sslkey,
    cert: sslcert
};

var jwt    = require('jsonwebtoken'); // used to create, sign, and verify tokens
var config = require('./config'); // get our config file
var server = https.createServer(options, app);

var methodOverride = require('method-override');

// MODULES

const authenticationModule = require('./modules/authenticationModule.js');
const databaseModule = require('./modules/database.js');
const utilsModule = require('./modules/utilsModule.js');
var User                = databaseModule.User;

// =======================
// configuration =========
// =======================
var port = process.env.PORT || 8080; // used to create, sign, and verify tokens
app.set('superSecret', config.secret); // secret variable

// use body parser so we can get info from POST and/or URL parameters
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(cors());

// use morgan to log requests to the console
app.use(morgan('dev'));

/*
	*	#################
	*		ROUTES
	*	#################
	*/
app.get('/', function(req, res) {
    res.send('Hello! The API is at http://localhost:' + port + '/api');
});

app.get('/api/', function(req,res) {
    res.send('There was no API function specified!');
});

app.get('/api/users/', function(req, res, next){
    //authenticationModule.validateToken(req, res, next);
    res.status(200);
    User.find({},function(err, users){
        if(err) console.log(err);
        res.json(users);
    });
});

app.use('/api/authenticate', authenticationModule.router);

function errorHandler(err, req, res, next) {
    res.status(err.status).send(err).end();
}

app.use(errorHandler);



/*
	*	#################
	* 		START SERVER
	*	#################
	*/
var server;
if (process.env.NODE_ENV == "PROD"){
    server = https.createServer(options, app).listen(port, function(){
        console.log(process.env.ENVIRONMENT+" server listening on port " + port);
    });
} else {
    server = http.createServer(app).listen(port, function(){
        console.log(process.env.ENVIRONMENT+" server listening on port " + port);
    });
}

module.exports = {databaseModule, app};
