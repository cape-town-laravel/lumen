var source = require('vinyl-source-stream');
var gulp = require('gulp');
var gutil = require('gulp-util');
var browserify = require('browserify');
var reactify = require('reactify');
var babelify = require('babelify');
var watchify = require('watchify');
var notify = require('gulp-notify');

function handleErrors() {
    var args = Array.prototype.slice.call(arguments);
    notify.onError({
        title: 'Compile Error',
        message: '<%= error.message %>'
    }).apply(this, args);
    this.emit('end'); // Keep gulp from hanging on this task
}

function buildScript(file, watch) {
    var props = {
        entries: ['./resources/scripts/' + file],
        debug: true
    };

    // watchify() if watch requested, otherwise run browserify() once
    var bundler = watch ?
        watchify(browserify(props).transform(babelify).transform(reactify)) :
        browserify(props).transform(babelify).transform(reactify);

    function rebundle() {
        var stream = bundler.bundle();
        return stream
            .on('error', handleErrors)
            .pipe(source('main.js'))
            .pipe(gulp.dest('./public/static/'));
    }

    // listen for an update and run rebundle
    bundler.on('update', function () {
        rebundle();
        gutil.log('Rebundle...');
    });

    // run it once the first time buildScript is called
    return rebundle();
}


// run once
gulp.task('scripts', function () {
    return buildScript('main.js', false);
});

// run 'scripts' task first, then watch for future changes
gulp.task('default', ['scripts'], function () {
    return buildScript('main.js', true);
});