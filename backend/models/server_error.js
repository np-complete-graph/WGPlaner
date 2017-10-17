'use strict';

module.exports = function ServerError(status, statusText, errorKey, misc) {
    Error.captureStackTrace(this, this.constructor);
    //TODO let this vary by environment
    Error.stackTraceLimit = 2;
    this.name = this.constructor.name;
    this.status = status;
    this.message = statusText;
    this.errorKey = errorKey;
    this.data = misc;
};

module.exports.ACCOUNT_LOCKED_ERROR_MESSAGE = "Account locked for %d %s. \r\nLocked until %s";