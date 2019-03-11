'use strict';
module.exports = function(grunt) {

    // load all grunt tasks matching the `grunt-*` pattern
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

		compass: {
			dist: {
				options: {
					sassDir: 'assets/scss',
					cssDir: 'assets/css'
				}
			}
		},

        // watch for changes and trigger sass, jshint, uglify and livereload
        watch: {
            compass: {
                files: ['assets/**/*.{scss,sass}'],
                tasks: ['compass', 'autoprefixer', 'cssmin']
            },
            js: {
                files: '<%= jshint.all %>',
                tasks: ['jshint', 'uglify']
            },
            livereload: {
                options: { livereload: true },
                files: ['style.css', 'assets/js/*.js', 'assets/images/*.{png,jpg,jpeg,gif,webp,svg}']
            }
        },

        // autoprefixer
        autoprefixer: {
            options: {
                browsers: ['last 2 versions', 'ie 9', 'ios 6', 'android 4'],
                map: true
            },
            files: {
                expand: true,
                flatten: true,
                src: 'assets/css/*.css',
                dest: 'assets/css/'
            },
        },

        //css sprites
        sprites: {

           sprite: {
                src: ['assets/images/sprites-source/*.png'],
                css: 'assets/scss/_sprites-source.scss',
                map: 'assets/images/sprite.png',
                classPrefix: 'bg',
                margin: 45
            }

        },

        // css minify
        cssmin: {
            options: {
                keepSpecialComments: 1
            },
            minify: {
                files: [{
                    expand: true,
                    cwd: 'assets/css/',
                    src: ['*.css', '!*.min.css'],
                    dest: 'assets/css/',
                    ext: '.min.css'
                },
				{
				    expand: true,
				    cwd: 'assets/css/skins/',
				    src: ['*.css', '!*.min.css'],
				    dest: 'assets/css/skins/',
				    ext: '.min.css'
				},
                {
                    expand: true,
                    cwd: 'assets/css/colors/',
                    src: ['*.css', '!*.min.css'],
                    dest: 'assets/css/colors/',
                    ext: '.min.css'
                }]
            }
        },

        // javascript linting with jshint
        jshint: {
            options: {
                jshintrc: '.jshintrc',
                force: true
            },

            all: [
                'Gruntfile.js',
                'assets/js/source/*.js',
                '!assets/js/source/buddypress.js',
                '!assets/js/source/jquery.stickypanel.js',
            ]
        },

        // uglify to concat, minify, and make source maps
        uglify: {
            plugins: {
                options: {
                    sourceMap: true,
                },
                files: {
                    'assets/js/plugins.min.js': [
                        'assets/js/vendor/imagesloaded.js',
                        'assets/js/vendor/jquery.ui.js',
                        'assets/js/vendor/fitvid.js',
                        'assets/js/vendor/jquery.easing.1.3.js',
                        'assets/js/vendor/retina.min.js',
                        'assets/js/vendor/jquery.scrollTo.min.js',
                        'assets/js/vendor/jquery.touchSwipe.min.js',
                        'assets/js/vendor/jquery.flexslider-min.js',
                        'assets/js/vendor/jcarousellite.js',
                        'assets/js/vendor/bootstrap.tabs.js',
                        'assets/js/vendor/bootstrap.tooltip.js',
                        'assets/js/vendor/bootstap.transition.js',
                        'assets/js/vendor/easypiechart.min.js',
                        'assets/js/vendor/foundation.tables.js',
                        'assets/js/vendor/jquery.waypoints.js',
                        'assets/js/vendor/hoverIntent.js',
                        'assets/js/vendor/smartresize.js',
                        'assets/js/vendor/packery.pkgd.min.js',
                    ],
                    'assets/js/pace.min.js' 		: 'assets/js/vendor/pace.js',
                    'assets/js/modernizr.min.js' 	: 'assets/js/vendor/modernizr.min.js',
                    'assets/js/jquery.validate.min.js' : 'assets/js/vendor/jquery.validate.min.js',
                }
            },
            main: {
                options: {
                    sourceMap: true,
                },
                files: {
                    'assets/js/main.min.js': [
                        'assets/js/source/radium-ismobile.js',
                        'assets/js/source/theme-ajax.js',
                        'assets/js/source/jquery.stickypanel.js',
                        'assets/js/source/radium-megamenu.js',
                        'assets/js/source/radium-megamenu-mobile.js',
                        'assets/js/source/theme-share-sticky.js',
                        'assets/js/source/theme-woocommerce-ajax.js',
                        'assets/js/source/theme-carousel.js',
                        'assets/js/source/theme-ratings.js',
                        'assets/js/source/theme-scripts.js',
                        'assets/js/source/large-carousel.js',
                        'assets/js/source/jquery.uitotop.js',
                        'assets/js/source/jquery.vticker.js',
                        'assets/js/source/waypoints-sticky.js'
                    ],
                    'assets/js/buddypress-global.min.js' : 'assets/js/source/buddypress-global.js',
                    'assets/js/buddypress.min.js' : 'assets/js/source/buddypress.js',
                    'assets/js/editor.min.js' : 'assets/js/source/bbpress/editor.js',
                    'assets/js/reply.min.js' : 'assets/js/source/bbpress/reply.js',
                    'assets/js/topic.min.js' : 'assets/js/source/bbpress/topic.js',
                    'assets/js/user.min.js' : 'assets/js/source/bbpress/user.js'
                }
            }
        },

        checktextdomain: {
        	options: {
        		correct_domain: false,
        		text_domain: 'radium',
        		keywords: [
        			'__:1,2d',
        			'_e:1,2d',
        			'_x:1,2c,3d',
        			'_n:1,2,4d',
        			'_ex:1,2c,3d',
        			'_nx:1,2,4c,5d',
        			'esc_attr__:1,2d',
        			'esc_attr_e:1,2d',
        			'esc_attr_x:1,2c,3d',
        			'esc_html__:1,2d',
        			'esc_html_e:1,2d',
        			'esc_html_x:1,2c,3d',
        			'_n_noop:1,2,3d',
        			'_nx_noop:1,2,3c,4d'
        		]
        	},
        	files: {
        		src: '**/*.php',
        		expand: true
        	}
        },

        addtextdomain: {
        	options: {
 	            textdomain: 'radium',    // Project text domain.
	        },

            target: {
                files: {
                    src: ['*.php', '**/*.php', '!node_modules/**']
                }
            }
        },

        makepot: {
        	target: {
        		options: {
         			domainPath: 'includes/languages',
        			mainFile: 'style.css',
        			potFilename: 'en_EN.pot',
        			processPot: function( pot ) {
        				pot.headers['report-msgid-bugs-to'] = 'frank@radiumthemes.com';
                    	pot.headers['language-team'] = 'RadiumThemes <http://radiumthemes.com>';
                    	pot.headers['Last-Translator'] = 'Franklin Gitonga <frank@radiumthemes.com>';
        				return pot;
        			},
        			type: 'wp-theme'
        		}
        	}
        },

    });

    // register task
    grunt.registerTask('build', ['compass', 'autoprefixer', 'cssmin', 'uglify', 'watch']);
	grunt.registerTask( 'build-commit',  ['checktextdomain', 'makepot', 'sprites' ] );

};
