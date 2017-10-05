	// =======================
	// get the packages we need ============
	// =======================
	var express     = require('express');
	var app         = express();
	var bodyParser  = require('body-parser');
	var morgan      = require('morgan');
	var cors 	= require('cors')

	var jwt    = require('jsonwebtoken'); // used to create, sign, and verify tokens
	var config = require('./config'); // get our config file

	// MODULES

	const authenticationModule = require('./modules/authenticationModule.js');
	const databaseModule = require('./modules/database.js');
	const utilsModule = require('./modules/utilsModule.js');

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

	app.get('/api/test', function(req, res){
			if (!authenticationModule.validateToken(req, res))	return;
			//TODO Do what you want
			res.send("TOKEN IS VALID");
	});

	app.use('/api/authenticate', authenticationModule.router);


	/*
	*	#################
	* 		START SERVER
	*	#################
	*/
	app.listen(port);
	console.log('Server up and running');

	module.exports = {databaseModule};
