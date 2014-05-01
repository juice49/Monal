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
					'build/css/fruitful.css': 'css/fruitful.styl'
				}
			}
		},

		autoprefixer: {
			compile: {
				options: {
					browsers: ['last 2 version', '> 1%', 'ie 8', 'ie 7']
				},
				files: {
					'build/css/fruitful.css': 'build/css/fruitful.css'
				}
			}
		},

		cssmin: {
			compile: {
				files: {
					'build/css/fruitful.css': ['build/css/fruitful.css']
				}
			}
		},

		browserify: {
			dist: {
				files: {
					'build/js/fruitful.js' : ['js/core.js']
				}
			}
		},

		uglify: {
			compile: {
				files: {
					'build/js/fruitful.js': [
						'js/libs/jquery-1.10.2.js',
						'js/libs/jquery.conscious.js',
						'js/libs/freshalert/freshalert.js',
						'build/js/fruitful.js'
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