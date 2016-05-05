'use strict';
var bowerPath = '.bower';

module.exports = function (grunt) {

    grunt.initConfig({
        bower: {
            install: {
                options: {
                    targetDir: bowerPath,
                    layout: 'byComponent'
                }
            }
        },
        bowercopy: {
            options: {
                runBower: false,
                clean: false,
                srcPrefix: bowerPath
            },
            fontBootstrap: {
                options: {
                    destPrefix: 'assets/fonts'
                },
                files: {
                    '': 'bootstrap/glyphicons-*.*'
                }
            },
            fontAwesome: {
                options: {
                    destPrefix: 'assets/fonts'
                },
                files: {
                    '' : 'font-awesome/fonts/*.*'
                }
            },
            css: {
                options: {
                    destPrefix: 'assets/css'
                },
                files : {
                    'font-awesome.min.css': 'font-awesome/font-awesome.min.css'
                }
            },
            sass: {
                options: {
                    destPrefix: 'assets/scss/bootstrap'
                },
                files: {
                    '' : 'bootstrap-sass-official/bootstrap/*.scss',
                    'mixins' : 'bootstrap-sass-official/bootstrap/mixins/*.scss'
                }
            },
            javascript: {
                options: {
                    destPrefix: 'assets/js/bower'
                },
                files : {
                    'bootstrap.js': 'bootstrap/bootstrap.js'
                }
            }
        },
        sass: {
            dist: {
                files: {
                    'assets/css/main.min.css': 'assets/scss/structure.scss',
                    'assets/css/admin.min.css': 'assets/scss/admin.scss',
                    'assets/css/styles.min.css': 'assets/scss/styles.scss'
                },
                options: {
                    style: 'compressed',
                    sourceComments: 'none'
                }
            },
            dev: {
                files: {
                    'assets/css/main.min.css': 'assets/scss/structure.scss',
                    'assets/css/admin.min.css': 'assets/scss/admin.scss',
                    'assets/css/styles.min.css': 'assets/scss/styles.scss'
                },
                options: {
                    style: 'nested',
                    sourceComments: 'none' //map
                }
            }
        },
        uglify: {
            dist: {
                files: {
                    'assets/js/scripts.min.js': [
                        'assets/js/bower/*.js',
                        'assets/js/_*.js'
                    ]
                }
            }
        },
        version: {
            options: {
                file: 'lib/scripts.php',
                css: 'assets/css/main.min.css',
                cssHandle: 'roots_main',
                js: 'assets/js/scripts.min.js',
                jsHandle: 'roots_scripts'
            }
        },
        watch: {
            sass: {
                files: [
                    'assets/scss/*.scss',
                    'assets/scss/bootstrap/*.scss'
                ],
                tasks: ['sass:dev']
            }
        },
        clean: {
            dist: [
                'assets/css/main.min.css',
                'assets/css/styles.min.css',
                'assets/js/scripts.min.js'
            ],
            bower: [bowerPath,'assets/js/bower/*','scss/bootstrap/*','bower_components'],
            build: [
                'assets/scss',
                'assets/js/bower',
                'assets/js/_*.js',
                '.bower',
                'bower_components',
                '.sass-cache',
                'bower.json',
                'package.json',
                'Gruntfile.js',
                'config.rb',
                '.gitignore'
            ]
        }
    });

    // Load tasks
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-bower-task');
    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.loadNpmTasks('grunt-wp-version');

    // Register tasks
    grunt.registerTask('build', [
        'clean:dist',
        'sass:dist',
        'uglify:dist',
        'version',
        'clean:build'
    ]);

    grunt.registerTask('default', [
        'sass:dev',
        'watch:sass'
    ]);

    grunt.registerTask('packages',function(){
        var tasks = [
            'clean:bower',
            'bower:install',
            'bowercopy'
        ];

        grunt.task.run(tasks);
    });
};