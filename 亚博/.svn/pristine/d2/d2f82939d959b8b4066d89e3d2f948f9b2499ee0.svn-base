angular.module('cpApp')
.service('Global', ['$cookies', function ($cookies) {
	
	var _global = {};
	
	this.set = function (key, value) {
		this._global[key] = value;
		if (typeof value == 'string') $cookies.put(key, value);
		$cookies.putObject(key, value);
		
		return value;
	};
	
	this.get = function (key) {
		var v = this._global[key];
		if (!v) {
			v = $cookies.get(key);
		}
		return v;
	};
	
}]);