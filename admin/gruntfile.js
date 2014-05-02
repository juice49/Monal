module.exports = function(grunt) {

	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),

		stylus: {
			compile: {
				options: {
					paths: ['components', 'css'],
					'include css': true
				},
				files: {
					'build/css/monal.css': 'css/monal.styl'
				}
			}
		},

		autoprefixer: {
			compile: {
				options: {
					browsers: ['last 2 version', '> 1%', 'ie 8', 'ie 7']
				},
				files: {
					'build/css/monal.css': 'build/css/monal.css'
				}
			}
		},

		cssmin: {
			compile: {
				files: {
					'build/css/monal.css': ['build/css/monal.css']
				}
			}
		},

		browserify: {
			dist: {
				files: {
					'build/js/monal.js' : ['js/core.js']
				}
			}
		},

		uglify: {
			compile: {
				files: {
					'build/js/monal.js': [
						'js/libs/jquery-1.10.2.js',
						'js/libs/jquery.conscious.js',
						'js/libs/freshalert/freshalert.js',
						'build/js/monal.js'
					]
				}
			}
		},

		watch: {
			css: {
				files: ['css/**'],
				tasks: ['css']
			},
			js: {
				files: ['js/**'],
				tasks: ['js']
			}
		}

	});

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-stylus');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-browserify');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	grunt.registerTask('css', ['stylus', 'autoprefixer', 'cssmin']);
	grunt.registerTask('default', ['css']);
	grunt.registerTask('js', ['browserify', 'uglify']);
};