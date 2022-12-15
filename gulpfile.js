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
    GLOB_SASS      = ["styles/**/*.scss"],
    ASSETS_DIST    = 'public/assets';

var MAIN_SASS      = [ 'styles/styles.scss', 'styles/errors.scss' ],
    MAIN_JS        = [ "scripts/index.js" ],
    MAIN_SW        = [ "scripts/serviceworker.js"];




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





var buildIdTask = () => {
  var cbField = 'buildId',
      cbString = new Date().getTime();
  console.log(`${MAIN_SW}: update revision ID '${cbField}=${cbString}'`);
  return src( MAIN_SW, {base: './'} )
    .pipe(
      replace(/buildId\s*=\s*\d+/g, () => `${cbField}=${cbString}`)
    )
    .pipe(dest( './' ));
};



var cleanTask = () => src([ASSETS_DIST, ASSETS_DIST], {read: false, allowEmpty: true}).pipe(clean());



var javascriptTask = () =>
    src( MAIN_JS )
    .pipe(jshint())
    .pipe(jshint.reporter(stylish))
    .pipe(webpack(require("./webpack.config.js"), webpackCompiler))
    .pipe(dest( ASSETS_DIST ));



var sassTask = ( done ) =>
    isProduction

    // Without Source maps
    ? src( MAIN_SASS )
      .pipe( sass())
      .pipe( postcss([
         autoprefixer(),
         cssnano()
      ]))
      .pipe( dest( ASSETS_DIST ))

    // With Source maps
    : src( MAIN_SASS )
      .pipe(sourcemaps.init())
      .pipe( sass())
      .pipe( postcss([
         autoprefixer(),
         cssnano()
      ]))
      .pipe(sourcemaps.write())
      .pipe( dest( ASSETS_DIST ));





var watchTask = (done) => {
    watch( GLOB_JS, series(buildIdTask, javascriptTask ));
    watch( GLOB_SASS, series(buildIdTask, sassTask ));
    done();
}





// --------------------------
// Export Tasks
// --------------------------

exports.default = series(
    cleanTask,
    buildIdTask,
    parallel(
        sassTask,
        javascriptTask
    )
);

exports.watch = series(
    watchTask
);


exports.js = series(
    buildIdTask,
    javascriptTask
);

exports.css = series(
    buildIdTask,
    sassTask
);
