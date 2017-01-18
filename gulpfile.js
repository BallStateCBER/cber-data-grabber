var gulp = require('gulp');
var phpcs = require('gulp-phpcs');

gulp.task('default', ['php_cs']);

// Validates files using PHP Code Sniffer
gulp.task('php_cs', function (cb) {
    return gulp.src(['src/*.php', 'src/**/*.php'])
        .pipe(phpcs({
            bin: '.\\vendor\\bin\\phpcs.bat',
            standard: 'PSR2',
            errorSeverity: 1,
            warningSeverity: 1
        }))
        // Log all problems that was found
        .pipe(phpcs.reporter('log'));
});
