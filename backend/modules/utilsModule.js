var isUndefined = function(variable){
    if (typeof variable === 'undefined'){
        return true;
    }
    return false;
}

module.exports = {
    isUndefined,
}