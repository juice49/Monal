module.exports = function(grunt){

    'use strict';

    grunt.initConfig({

        pkg : grunt.file.readJSON('package.json'),

        stylus: {
            compile : {
                files: {
                    'css/grid.css' : 'css/stylus/grid.styl',
                    'css/fructose-base.css': 'css/stylus/fructose-base.styl',
                    'css/login.css': 'css/stylus/login.styl',
                }
            }
        },

        uglify : {
            js : {
                src : [
                        'js/libs/jquery-1.10.2.js',
                        'js/libs/jquery.validate.js',
                        'js/libs/conscious.js',
                        'js/core.js',
                        'js/setup.js',
                    ],
                dest : 'js/compressed/core.js'
            }
        },

        watch : {
            css : {
                files : [
                        'css/stylus/grid.styl',
                        'css/stylus/fructose-base.styl',
                        'css/stylus/login.styl'
                    ],
                tasks : ['css']
            },
            js : {
                files : [
                        'js/libs/jquery-1.10.2.js',
                        'js/libs/jquery.validate.js',
                        'js/libs/conscious.js',
                        'js/core.js',
                        'js/setup.js',
                    ],
                tasks : ['js']
            }
        }

    });

    grunt.loadNpmTasks('grunt-contrib-stylus');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    //grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['stylus', 'uglify']);
    grunt.registerTask('css', ['stylus']);
    grunt.registerTask('js', ['uglify']);

};