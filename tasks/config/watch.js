module.exports = function(grunt) {

	grunt.config.set('watch', {

    sass: {
      files: ['**/**/sass/**/*.scss'],
      tasks: ['sass:dev'],
      options: {
        livereload: true
      }
    },

    php: {
      files: ['**/**/theme/*.php'],
      tasks: ['copy:dev'],
      options: {
        livereload: true
      }
    },

    js: {
      files: ['**/**/theme/js/*.js'],
      tasks: ['copy:dev'],
      options: {
        livereload: true
      }
    }
	});

  grunt.loadNpmTasks('grunt-contrib-watch');

};
