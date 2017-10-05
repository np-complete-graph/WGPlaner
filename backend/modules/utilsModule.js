exports.sendError = function(res, statusCode, reason){
	res.send( {
		httpStatusCode: statusCode,
		reason: reason
	});
}