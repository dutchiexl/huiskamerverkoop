var gulp = require('gulp'),
    browserSync = require('browser-sync').create(),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    prefix = require('gulp-autoprefixer'),
    sourcemaps = require('gulp-sourcemaps'),
    copy = require('gulp-copy'),
    rename = require('gulp-rename'),
    uglify = require('gulp-uglify'),
    uglifycss = require('gulp-uglifycss'),
    sassLint = require('gulp-sass-lint'),
    filter = require('gulp-filter'),
    modernizr = require('gulp-modernizr');
mainBowerFiles = require('main-bower-files');

var DEST = 'web/';

/**
 * @task js
 * Compile files from js
 */
gulp.task('js', function () {

    var jsFiles = ['src/js/*'];

    gulp.src(['web/**/*.js', '!web/**/modernizr.js'])
        .pipe(modernizr('modernizr.js'))
        .pipe(uglify())
        .pipe(gulp.dest("web/js"));

    return gulp.src(mainBowerFiles())
        .pipe(filter('*.js'))
        .pipe(concat('main.js'))
        .pipe(uglify())
        .pipe(gulp.dest(DEST + '/js'));
});

/**
 * @task sass
 * Compile files from scss
 */
gulp.task('sass', function () {
    gulp.src(['src/**/Resources/public/**/*.scss', '!src/AppBundle/Resources/public/**/_fonts.scss', '!src/AppBundle/Resources/public/sass/vendor/*'])
        .pipe(sassLint({
            options: {}
        }))
        .pipe(sassLint.format())
        .pipe(sassLint.failOnError());
    gulp.src('src/**/Resources/public/sass/style.scss')
        .pipe(sass())
        .pipe(concat('styles.css'))
        .pipe(prefix(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], {cascade: true}))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(DEST + '/css'))
        .pipe(uglifycss())
        .pipe(browserSync.stream())
        .pipe(gulp.dest(DEST + '/css'))
        .pipe(rename({extname: '.min.css'}))
});

/**
 * Launch the Server
 */
gulp.task('browser-sync', ['sass'], function () {
    browserSync.init({
        // Change as required
        proxy: "http://huiskamerverkoop.local",
        startPath: "/app_dev.php",
        socket: {
            // For local development only use the default Browsersync local URL.
            //domain: 'localhost:3000'
            // For external development (e.g on a mobile or tablet) use an external URL.
            // You will need to update this to whatever BS tells you is the external URL when you run Gulp.
            domain: 'localhost:3000'
        }
    });
});

/**
 * @task watch
 * Watch scss files for changes & recompile
 * Clear cache when Drupal related files are changed
 */
gulp.task('watch', function () {
    gulp.watch(['src/**/Resources/public/**/*.scss'], ['sass']);
    gulp.watch('**/*.{twig}', ['reload']);
});

/**
 * @task reload
 * Refresh the page after clearing cache
 */
gulp.task('reload', function () {
    browserSync.reload();
});

/**
 * Default task, running just `gulp` will
 * ...
 */
gulp.task('default', ['browser-sync', 'watch']);
