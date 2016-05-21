module.exports = function (grunt) {
  grunt.registerTask( 'default',    [ 'clean:dev', 'copy:dev', 'sass:dev' ]);
};
