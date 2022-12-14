// --------------------------
// Project settings
// --------------------------

const isProduction = (process.env.NODE_ENV === 'production');

var settings = {
    php: true,
    reload: true
};


// File-system and entry/main files
var GLOB_JS        = ["scripts/**/*.js"],
    GLOB_SASS      = "styles/**/*.scss";

var DIST_JS        = 'public/assets',
    DIST_CSS       = 'public/assets',
    DIST_HTML      = 'templates';

var MAIN_SASS      = [ 'styles/styles.scss', 'styles/errors.scss' ],
    MAIN_JS        = [ "scripts/index.js" ],
    MAIN_CACHEBUST = [ "public/assets/serviceworker.mjs"];




// --------------------------
// Environment
// --------------------------

var { gulp, src, dest, watch, series, parallel } = require('gulp');

// Grundlegendes
var webpack         = require ("webpack-stream"),
    webpackCompiler = require("webpack"),
    webpackConfig   = require("./webpack.config.js");


// Project plugins
var sourcemaps   = require ('gulp-sourcemaps'),
    replace      = require('gulp-replace'),
    clean        = require('gulp-clean');

// Plugins for styles
var autoprefixer = require ("autoprefixer"),
    cssnano      = require ("cssnano"),
    sass         =  require('gulp-sass')(require('sass')),
    postcss      = require ("gulp-postcss");

// Scripting plugins
var jshint       = require ("gulp-jshint"),
    terser       = require ("gulp-terser"),
    stylish      = require ("jshint-stylish");





var cacheBustTask = function() {
  var cbString = new Date().getTime();
  console.log(`Cache bust string is '${cbString}'`);
  return src( MAIN_CACHEBUST, {base: './'} )
    .pipe(
      replace(/buildId\s*=\s*\d+/g, function() {
        return "buildId=" + cbString;
      })
    )
    .pipe(dest('./'));
};




var cleanTask = function() {
  return src([DIST_JS, DIST_CSS], {read: false, allowEmpty: true})
        .pipe(clean());
};





var javascriptTask = function() {
  return src( MAIN_JS )
    .pipe(jshint())
    .pipe(jshint.reporter(stylish))
    .pipe(webpack(require("./webpack.config.js"), webpackCompiler))
    .pipe(dest( DIST_JS ));
};



var sassTask = function( done ) {

    return isProduction
    // Without Source maps
    ? src( MAIN_SASS )
      .pipe( sass())
      .pipe( postcss([
         autoprefixer(),
         cssnano()
      ]))
      .pipe( dest( DIST_CSS ))

    // With Source maps
    : src( MAIN_SASS )
      .pipe(sourcemaps.init())
      .pipe( sass())
      .pipe( postcss([
         autoprefixer(),
         cssnano()
      ]))
      .pipe(sourcemaps.write())
      .pipe( dest( DIST_CSS ));
};




var watchTask = function(done) {
    watch( GLOB_JS, series(javascriptTask, cacheBustTask));
    watch( GLOB_SASS, series(sassTask, cacheBustTask));
    done();
}





// --------------------------
// Export Tasks
// --------------------------

exports.default = series(
    cleanTask,
    parallel(
        sassTask,
        javascriptTask
    ),
    cacheBustTask
);

exports.watch = series(
    watchTask
);


exports.js = series(
    javascriptTask,
    cacheBustTask
);

exports.css = series(
    sassTask,
    cacheBustTask
);
