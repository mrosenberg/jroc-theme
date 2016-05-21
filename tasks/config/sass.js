

module.exports = function(grunt) {

	var files = [{
		expand: true,
		cwd: 'sass/',
		src: ['*.scss'],
    dest: 'build',
		ext: '.css'
	}];

	grunt.config.set('sass', {
		dev: {
			options: {
        lineNumbers: true,
				trace: true,
				compass: true
			},
			files: files
		},
		prod: {
			options: {
				trace: false,
				compass: true,
				sourcemap:'none',
				style:'compressed'
			},
			files: files
		}
	});

	grunt.loadNpmTasks('grunt-contrib-sass');

};
