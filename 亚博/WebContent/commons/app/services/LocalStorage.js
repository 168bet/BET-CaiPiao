angular.module('cpApp')
.factory('localStorage', function () {
	return {
		clear: store.clear,
		constructor: function () {},
		getItem: store.get,
		setItem: store.set,
		key: function () {
			console.error('不支持key方法');
		},
		removeItem: store.remove
	};
});