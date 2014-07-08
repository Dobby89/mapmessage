// Include Gulp
var gulp = require('gulp');

// Include Gulp plugins
var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var compass = require('gulp-compass');
var notify = require('gulp-notify');
var livereload = require('gulp-livereload');
var order = require("gulp-order");
var csso = require("gulp-csso");
var imagemin = require('gulp-imagemin');
var pngcrush = require('imagemin-pngcrush');

// Lint task
gulp.task('lint', function() {
//  return gulp.src('./src/js/*.js')
//    .pipe(jshint())
//    .pipe(jshint.reporter('default'));
});

// Compile SASS
gulp.task('sass', function() {
	return gulp.src('./src/sass/*.scss')
		.pipe(compass({
      config_file: 'compass.rb',
      css: 'dist/css',
      sass: 'src/sass'
		}))
		.on('error', notify.onError({
      message: "<%= error.message %>",
      title: "SASS Error"
		}))
    .pipe(csso())
		.pipe(gulp.dest('dist/css'));
});

// Concatenate and minify JS
gulp.task('scripts', function() {
  return gulp.src('./src/js/*.js')
    .pipe(order([
      'jquery-1.11.1.js', // Decide which order to concatenate the js files
      'custom.js'
    ]))
    .pipe(concat('all.js'))
    //.pipe(rename('all.js'))
    .pipe(gulp.dest('dist/js'));
});

// compress images
gulp.task('images', function () {
  return gulp.src('src/ui/**/*')
    .pipe(imagemin({
      progressive: true,
      svgoPlugins: [{removeViewBox: false}],
      use: [pngcrush()]
    }))
    .pipe(gulp.dest('dist/ui'));
});

// Watch files for changes
gulp.task('watch', function() {
  gulp.watch('./src/js/**/*.js', ['scripts']);
  gulp.watch('./src/sass/**/*.scss', ['sass']);
  gulp.watch('./src/ui/**/*', ['images']);
});

// Default task
gulp.task('default', ['sass', 'scripts', 'images', 'watch']);