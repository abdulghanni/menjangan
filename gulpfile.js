var gulp           = require('gulp');
var csso           = require('gulp-csso');
var autoprefixer   = require('gulp-autoprefixer');
var uglify         = require('gulp-uglify');
var imagemin       = require('gulp-imagemin');
var pngquant       = require('imagemin-pngquant');
var clean          = require('gulp-clean');
var mainBowerFiles = require('gulp-main-bower-files');
var concat         = require('gulp-concat');
var gulpFilter     = require('gulp-filter');
var plumber        = require('gulp-plumber');
var htmlmin        = require('gulp-htmlmin');
var HtmlComments   = require('gulp-remove-html-comments');
var merge          = require('merge-stream');

// Development Assets
var css_dev   = 'assets_dev/css/**/*.css';
var scss_dev  = 'assets_dev/css/**/*.scss';
var js_dev    = 'assets_dev/js/**/*.js';
var img_dev   = 'assets_dev/img/**/*';
var fonts_dev = 'assets_dev/fonts/';

// Production Assets
var css_dist     = 'assets/css/';
var js_dist      = 'assets/js/';
var plugins_dist = 'assets/plugins/';
var img_dist     = 'assets/img/';
var fonts_dist   = 'assets/fonts/';

// Gulp Clean
gulp.task('clean_bower', function () {
    return gulp.src('assets/plugins', {read: false})
        .pipe(clean());
});
gulp.task('clean_scripts', function () {
    return gulp.src('assets/js', {read: false})
        .pipe(clean());
});
gulp.task('clean_styles', function () {
    return gulp.src('assets/css', {read: false})
        .pipe(clean());
});
gulp.task('clean_images', function () {
    return gulp.src('assets/img', {read: false})
        .pipe(clean());
});

// Bower main
gulp.task('bower', function() {
    return gulp.src('bower.json')
        .pipe(plumber())
        .pipe(mainBowerFiles())
        .pipe(gulp.dest('assets/plugins'));
});

// Minify Scripts
gulp.task('scripts', function() {
	return gulp.src(js_dev)
        .pipe(plumber())
	    .pipe(uglify())
		.pipe(gulp.dest(js_dist));
});

// Minify Styles
gulp.task('styles', function() {
	return gulp.src(css_dev)
        .pipe(plumber())
        .pipe(csso())
        .pipe(autoprefixer('last 2 versions'))
        .pipe(gulp.dest(css_dist));
});

// Compress image
gulp.task('images', function() {
    return gulp.src(img_dev)
        .pipe(plumber())
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }))
        .pipe(gulp.dest(img_dist));
});

// Gulp Run
gulp.task('clean', ['clean_bower', 'clean_scripts', 'clean_styles', 'clean_images']);
gulp.task('watch', function() {
	gulp.watch([js_dev], ['scripts']);
	gulp.watch([css_dev], ['styles']);
    gulp.watch([img_dev], ['images']);
});
gulp.task('default', ['scripts', 'styles', 'images', 'bower']);