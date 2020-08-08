var gulp = require("gulp"),
    sass = require("gulp-sass"),
    postcss = require("gulp-postcss"),
    autoprefixer = require("autoprefixer"),
    cssnano = require("cssnano"),
    sourcemaps = require("gulp-sourcemaps"),
    rename = require("gulp-rename"),
    notify = require("gulp-notify");

var paths = {
    styles: {
        src: "./source-css/sass/*.scss",
        dest: "./web/css/*.css"
    }
};


function style() {

    return (
        gulp
            .src("./source-css/sass/*.scss")
            .pipe(sass())
            .on("error", sass.logError)
            .pipe(gulp.dest("./web/css"))
            .pipe(postcss([autoprefixer(), cssnano()]))
            .pipe(rename({ suffix: ".min" }))
            .pipe(gulp.dest("./web/css"))
            .pipe(notify("front:compileSass was compiled!"))

    );
}


function watch() {
    //I usually run the compile task when the watch task starts as well
    style();

    gulp.watch(paths.styles.src, style);
}

// Expose the task by exporting it
// This allows you to run it from the commandline using
// $ gulp style
exports.default  = watch;
exports.style  = style;