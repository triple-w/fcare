

var gulp = require('gulp');
var elixir = require('laravel-elixir');
var minifyCSS = require('gulp-minify-css');
var rename = require('gulp-rename');

var paths = {
    dev: 'resources/assets/',
    dist: 'public/webroot/'
};

gulp.task('mincss', function() {
    gulp.src(paths.dist + 'css/*.css')
        .pipe(minifyCSS())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(paths.dist + 'css/minified/'));
});

elixir(function(mix) {
    mix
    .sass('main.scss', paths.dist + 'css')
    .task('mincss');
});



// gulp.task('styles', function() {
//     gulp.src(paths.dev + 'sass/**/*.scss')
//         .pipe(sass().on('error', sass.logError))
//         .pipe(gulp.dest(paths.dist + 'css/'))
//         .pipe(minifyCSS())
//         .pipe(rename({
//             suffix: '.min'
//         }))
//         .pipe(gulp.dest(paths.dist + 'css/'));
// });


// gulp.task('js', function() {
// 	gulp.src(paths.dev + 'scss/**/*.scss')
//         .pipe(coffee({bare: true}).on('error', coffee.logError))
//         .pipe(gulp.dest(paths.dist + 'js/'));
// });

//Watch task
// gulp.task('watch',function() {
//     gulp.watch(paths.dev + 'sass/**/*.scss', ['styles']);
// });

//build
// gulp.task('build', ['styles']);