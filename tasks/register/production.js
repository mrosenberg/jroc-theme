module.exports = function (grunt) {
  grunt.registerTask( 'production',    [ 'clean:prod', 'copy:prod', 'sass:prod' ]);
};
