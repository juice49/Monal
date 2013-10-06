module.exports = function(grunt){

    'use strict';

    grunt.initConfig({

        pkg : grunt.file.readJSON('package.json'),

        stylus: {

            compile : {

                files: {

                    'css/fructose-base.css': 'css/stylus/fructose-base.styl',
                    'css/login.css': 'css/stylus/login.styl',
                
                }

            }

        },

        watch : {

            css : {

                files : [
                        'css/stylus/fructose-base.styl',
                        'css/stylus/login.styl'
                    ],
                tasks : ['compile_css']

            },

        }

    });

    grunt.loadNpmTasks('grunt-contrib-stylus');
    //grunt.loadNpmTasks('grunt-contrib-uglify');
    //grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');

    grunt.registerTask('default', ['stylus']);
    grunt.registerTask('compile_css', ['stylus']);

};