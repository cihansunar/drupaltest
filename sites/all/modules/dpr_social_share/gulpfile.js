

/**** Load gulp components*/
var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-cssnano'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    concatcss = require('gulp-concat-css'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    bower = require('main-bower-files'),
    filter = require('gulp-filter'),
    flatten = require('gulp-flatten'),
    sourcemaps = require('gulp-sourcemaps'),
    print = require('gulp-print'),
    del = require('del'),
    sassdoc = require('sassdoc');


gulp.task('debug', function() {

    var js, css, font;

    js = filter('**/*.js', {restore: true});
    css = filter('**/*.css', {restore: true});
    font = filter(['**/*.eot', '**/*.woff', '**/*.svg', '**/*.ttf'], {restore:true});

    /*Integrate bower components*/
    return gulp.src(bower())
        .pipe(js)
        .pipe(print());

});

gulp.task('styles', function() {
    return sass('scss/dpr-social-share.scss', { style: 'expanded', sourcemap: true })
        .pipe(autoprefixer({ browsers: ['> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1'], cascade: false }))
        .pipe(minifycss())
        .pipe(sourcemaps.write('.', {
            includeContent: false,
            sourceRoot: 'source'
        }))
        .pipe(gulp.dest('css'));
        //.pipe(notify({ message: 'Styles task complete' }));
});

gulp.task('docs', function() {
    return gulp
        .src('scss/**/*.scss')
        .pipe(sassdoc({dest: 'scss/docs'}))
        .resume();
});

gulp.task('watch', function () {
    console.log('Started SCSS watcher.. ');
    gulp.watch(['scss/*.scss', 'scss/partials/*.scss', 'scss/partials/modules/*.scss', 'scss/partials/modals/*.scss'], function (event) {
        gulp.start('styles');
    });
});

gulp.task('default', ['styles', 'watch']);