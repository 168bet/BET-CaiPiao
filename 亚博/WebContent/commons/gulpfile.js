var gulp = require('gulp');
var cssnano = require('gulp-cssnano')
var concat = require('gulp-concat');
var streamqueue = require('streamqueue');
var uglify = require('gulp-uglify');
var jshint = require('gulp-jshint');
var jshintStylish = require('jshint-stylish');
var templateCache = require('gulp-angular-templatecache');
var ncp = require('ncp').ncp;
var path = require('path');
var fs = require('fs');

/**
 * production / vendor.min.js
 * production / vendor.js
 * production / main.min.js
 * production / main.js
 * production / template.min.js
 * production / template.js 
 * production css/ vendor.min.css
 * production css / main.css
 * production images
 */

var templateName = 'yabo.template.js';
 gulp.task('app.template', function () {
 	gulp.src("app/templates/**/*.html")
 		.pipe(templateCache(templateName,{
 			module: 'cpApp',
 			transformUrl: function (url) {
 				return url;
 			},
 			templateBody: "$templateCache.put(templateBaseURI + '/<%= url %>','<%= contents %>');",
 		}))
 		.pipe(gulp.dest("production"))
 });

 gulp.task('app.css', function () {
	 
	// 系统样式
 	gulp.src(['app/css/main.css',
 		'app/css/userCenter.css', 
 		'app/css/game.css',
 		'/app/css/response.css',
 		'app/css/default.css',
 		'vendor/skins/default/laydate.css',
 		'app/css/helps.css',
 		'app/css/draw.css',
 		'app/css/drawDetail.css',
 		'app/css/register.css',
 		'app/css/login.css',
 		'app/css/charts.css',
 		'app/css/siderbar.css',
 		'app/css/lotteryCenter.css',
 		'app/css/jnd28.css',
 		'app/css/betDialog.css',
 		'app/css/bjpk10.css',
 		'app/css/fc3d.css',
 		'app/css/klsf.css',
 		'app/css/lhc.css',
 		'app/css/ssc.css'])
 		.pipe(cssnano())
 		.pipe(concat('main.min.css'))
 		.pipe(gulp.dest("production/css"))
 		.on('end', function () {
 			var toPath = path.join(__dirname, 'production/images');
 			if (!fs.existsSync(toPath)) {
 				fs.mkdirSync(toPath)
 			}
 			ncp(path.join(__dirname, 'app/images'), toPath, function (err) {
 				if (err) {
 					console.error('复制图片目录失败');
 				}
 				else {
 					// TODO:: ??
 				}
 			});
 		});
 	
 	// 第三方插件样式
 	gulp.src(['app/css/reset.css', 
 	  		'app/css/vendor.css',
 	  		'vendor/need/laydate.css'])
 		.pipe(cssnano())
 		.pipe(concat('vendor.min.css'))
 		.pipe(gulp.dest('production/css'));
 	
 	// IE 单独处理
 	gulp.src(['app/css/ie.css'])
 		.pipe(cssnano())
 		.pipe(gulp.dest('production/css'));
 });

 gulp.task('app.deps', ['app.css', 'app.template'], function () {
 	gulp.src(['vendor/angular.js', 
 	          'vendor/angular-ui-router.js',
 	          'vendor/swiper.js',
 	          'vendor/chart.js',
 	          'vendor/*.js'])
 	.pipe(uglify({
    	mangle: true,
    	compress: {
    		//
    	},
    	//preserveComments: 'all'
    }))
    .pipe(concat('vendor.min.js'))
    .pipe(gulp.dest('production'));
 });

gulp.task('app.system', ['app.deps'], function() {
	gulp.src(['app/app.module.js' ,'app/**/*.js', 'production/'+ templateName])
	 	.pipe(jshint())
	 	.pipe(jshint.reporter(jshintStylish)) 
		 .pipe(uglify({
	     	mangle: true,
	     	compress: {
	     		//unused: false,
	     	},
	     	//preserveComments: 'all'
     	}))
		.pipe(concat('main.min.js'))
		.pipe(gulp.dest('production'));
});

gulp.task('default', ['app.system'], function () {
	console.log("完成压缩");
});