exports.sendError = function(res, statusCode, reason){
	res.status(statusCode);
	res.send( {
		reason: reason
	});
}