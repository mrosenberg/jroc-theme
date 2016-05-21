module.exports = function(grunt) {

  grunt.config.set( 'clean', {
  dev: {
    src: ['./build/*']
  },
  prod: {
    src: ['./build/*']
  }
  });

  grunt.loadNpmTasks('grunt-contrib-clean');
};
