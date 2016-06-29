module.exports = function(grunt) {

  grunt.config.set( 'copy', {
    dev: {
      files: [
        // includes files within path and its sub-directories
        {expand: true, cwd: 'theme/', src: ['**'], dest: 'build/'}
      ]
    },
    prod: {
      files: [
        // includes files within path and its sub-directories
        {expand: true, cwd: 'theme/', src: ['**'], dest: 'build/'}
      ]
    }

  });

  grunt.loadNpmTasks('grunt-contrib-copy');

};
