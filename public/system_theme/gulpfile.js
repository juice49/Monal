var
	gulp = require('gulp'),
	plumber = require('gulp-plumber'),
	gutil = require('gulp-util'),
	source = require('vinyl-source-stream'),
	watch = require('gulp-watch'),
	concat = require('gulp-concat'),
	stylus = require('gulp-stylus'),
	csso = require('gulp-csso'),
	autoprefixer = require('gulp-autoprefixer'),
	streamify = require('gulp-streamify'),
	uglify = require('gulp-uglify');

gulp.task('watch', function() {
	gulp.watch(['./css/**/*'], ['css']);
	gulp.watch(['./js/**/*'], ['js']);
});

gulp.task('css', function() {

	var onError = plumber({
		errorHandler: function(err) {
			gutil.beep();
			gutil.log(err);
			this.emit('end');
		}
	});

	return gulp.src([
			'/js/libs/jquery-ui-1.10.4/css/no-theme/jquery-ui-1.10.4.custom.css',
			'./fonts/icons/style.css',
			'./css/app.styl'
		])
		.pipe(onError)
		.pipe(stylus())
		.pipe(autoprefixer('last 2 version', '> 1%', 'ie 8', 'ie 7'))
		.pipe(csso())
		.pipe(concat('app.css'))
		.pipe(gulp.dest('./build/'));
});


gulp.task('js', function() {

	var onError = plumber({
		errorHandler: function(err) {
			gutil.beep();
			gutil.log(err);
			this.emit('end');
		}
	});
	gulp.src([
		'./components/jquery-1.11.0/index.js',
		'./js/libs/jquery-ui-1.10.4/js/jquery-ui-1.10.4.custom.js',
		'./components/html5shiv/dist/html5shiv.js',
		'./components/conscious.js/src/conscious.js',
		'./js/app.js'
	])
	.pipe(onError)
	.pipe(streamify(uglify()))
	.pipe(concat('app.js'))
	.pipe(gulp.dest('./build/'));
});