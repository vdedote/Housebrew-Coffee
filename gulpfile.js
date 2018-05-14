const gulp = require('gulp');
const imagemin = require('gulp-imagemin');
const sass = require('gulp-sass');
const uglify = require('gulp-uglify');

/*

  --Top Level Functions--
  gulp.task - Define Tasks
  gulp.src - Point to the files to use
  gulp.dest - Point to the folder to output
  gulp.watch - watch files and folders for changes

*/

//  Logs Message
gulp.task('message', function(){
  return console.log('Gulp is running...');
})

//Copy all php files
gulp.task('copyphp', function(){
  gulp.src('src/*.php')
    .pipe(gulp.dest('compiled'));
})

//Copy all layout files
gulp.task('copylayout', function(){
  gulp.src('src/layout/*')
    .pipe(gulp.dest('compiled/layout'));
})

//Copy all pages files
gulp.task('copyAdmin', function(){
  gulp.src('src/Admin/*')
    .pipe(gulp.dest('compiled/Admin'));
})

//Copy all pages files
gulp.task('copypages', function(){
  gulp.src('src/pages/*')
    .pipe(gulp.dest('compiled/pages'));
})

//Copy all gallery files
gulp.task('copygallery', function(){
  gulp.src('src/img/HousebrewGallery/*')
    .pipe(gulp.dest('compiled/img/HousebrewGallery'));
})

//Optimize images
gulp.task('imageMin', () =>
    gulp.src('src/img/*')
        .pipe(imagemin())
        .pipe(gulp.dest('compiled/img'))
);


// Minify Javascript
gulp.task('minifyJS', function(){
  gulp.src('src/js/*.js')
      .pipe(uglify())
      .pipe(gulp.dest('compiled/js'));
})


//Compile Sass
gulp.task('sass', function(){
  gulp.src('src/scss/style.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('compiled/css'));
})

//Compile Sass
gulp.task('sasspages', function(){
  gulp.src('src/scss/pages/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('compiled/css'));
})


//This task will execute all the task above because you can create an array of it
gulp.task('default', ['message','copyphp','copypages','copylayout','copygallery','copyAdmin','imageMin','sass','sasspages','minifyJS']);
