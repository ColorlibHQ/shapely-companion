'use strict';
module.exports = function( grunt ) {
  require( 'load-grunt-tasks' )( grunt, { scope: 'devDependencies' } );

  grunt.config.init( {
    pkg: grunt.file.readJSON( 'package.json' ),
    checktextdomain: {
      standard: {
        options: {
          text_domain: [ 'shapely-companion' ], //Specify allowed
          // domain(s)
          create_report_file: 'true',
          keywords: [ //List keyword specifications
            '__:1,2d',
            '_e:1,2d',
            '_x:1,2c,3d',
            'esc_html__:1,2d',
            'esc_html_e:1,2d',
            'esc_html_x:1,2c,3d',
            'esc_attr__:1,2d',
            'esc_attr_e:1,2d',
            'esc_attr_x:1,2c,3d',
            '_ex:1,2c,3d',
            '_n:1,2,4d',
            '_nx:1,2,4c,5d',
            '_n_noop:1,2,3d',
            '_nx_noop:1,2,3c,4d'
          ]
        },
        files: [
          {
            src: [
              '**/*.php',
              '!**/node_modules/**'
            ],
            expand: true
          } ]
      }
    },

    clean: {
      init: {
        src: [ 'build/' ]
      },
      build: {
        src: [
          'build/*',
          '!build/<%= pkg.name %>.zip'
        ]
      }
    },

    copy: {
      build: {
        expand: true,
        src: [
          '**',
          '!node_modules/**',
          '!build/**',
          '!readme.md',
          '!README.md',
          '!phpcs.ruleset.xml',
          '!Gruntfile.js',
          '!package.json',
          '!package-lock.json',
          '!set_tags.sh',
          '!shapely.zip',
          '!nbproject/**' ],
        dest: 'build/'
      }
    },

    compress: {
      build: {
        options: {
          pretty: true,
          archive: '<%= pkg.name %>.zip'
        },
        expand: true,
        cwd: 'build/',
        src: [ '**/*' ],
        dest: '<%= pkg.name %>/'
      }
    },

    imagemin: {
      jpg: {
        options: {
          progressive: true
        }
      },
      png: {
        options: {
          optimizationLevel: 7
        }
      },
      dynamic: {
        files: [
          {
            expand: true,
            cwd: 'assets/img/',
            src: [ '**/*.{png,jpg,gif}' ],
            dest: 'assets/img/'
          } ]
      }
    }

  } );

  // Check Missing Text Domain Strings
  grunt.registerTask( 'textdomain', [
    'checktextdomain'
  ] );

  grunt.registerTask( 'build-archive', [
    'clean:init',
    'copy',
    'compress:build',
    'clean:init'
  ] );
};
