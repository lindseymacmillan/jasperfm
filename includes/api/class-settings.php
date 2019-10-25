<?php
/**
 * JasperFM Screens manager.
 *
 * @package JasperFM
 */

namespace JasperFM;

defined( 'ABSPATH' ) || exit;

/**
 * Manages the settings.
 */
class Settings {

    /**
	 * Defaults for all of the settings.
	 * See `init` for structure of the data.
	 *
	 * @var array
	 */
    protected static $defaults = [
        'custom_post_types' => [
            [
                'name' => 'mixtape',
                'singular_name' => 'Mixtape',
                'plural_name' => 'Mixtapes',
                'rewrite' => 'mixtape',
                'menu_position' => 40,
                'show_in_menu' => false
            ],
            [
                'name' => 'season',
                'singular_name' => 'Season',
                'plural_name' => 'Seasons',
                'rewrite' => 'season',
                'menu_position' => 40,
                'show_in_menu' => false
            ],
        ],
        'post_type_settings' => [],
        'use_contributor_structure' => false,
    ];

	/**
	 * Information about all of the settings.
	 * See `init` for structure of the data.
	 *
	 * @var array
	 */
    protected static $settings = [];
    
    /**
	 * Initialize and register all of the settings
	 */
	public static function init() {

        $jasperfmSettings = get_option( 'jasperfm-settings', false );
        if ($jasperfmSettings == false) {
            self::$settings = self::$defaults;
            add_option('jasperfm-settings', self::$settings, false, 'yes');
        } else {
            self::$settings = $jasperfmSettings;
        }

        add_action( 'init', [__CLASS__, 'register_post_types'] );
        add_action( 'init', [__CLASS__, 'register_dashboard_taxonomy'] );

        if (self::$settings['use_contributor_structure'] == true) {
            add_action( 'init', [__CLASS__, 'register_contributor_taxonomy'] );
            add_action( 'init', [__CLASS__, 'register_contributor_post_type'] );
        }

    }
    
    /**
	 * Register all the active post types
	 */
	public static function register_post_types() {
        $customPostTypes = self::$settings['custom_post_types'];

        if (!empty($customPostTypes)) {

            foreach ($customPostTypes as $postType) {

                $labels = array(
                    'name'               => _x( $postType['plural_name'], 'post type general name', 'jasperfm' ),
                    'singular_name'      => _x( $postType['singular_name'], 'post type singular name', 'jasperfm' ),
                    'menu_name'          => _x( $postType['plural_name'], 'admin menu', 'jasperfm' ),
                    'name_admin_bar'     => _x( $postType['singular_name'], 'add new on admin bar', 'jasperfm' ),
                    'add_new'            => _x( 'Add New', $postType['singular_name'], 'jasperfm' ),
                    'add_new_item'       => __( 'Add New ' . $postType['singular_name'], 'jasperfm' ),
                    'new_item'           => __( 'New ' . $postType['singular_name'], 'jasperfm' ),
                    'edit_item'          => __( 'Edit ' . $postType['singular_name'], 'jasperfm' ),
                    'view_item'          => __( 'View ' . $postType['singular_name'], 'jasperfm' ),
                    'all_items'          => __( 'All ' . $postType['plural_name'], 'jasperfm' ),
                    'search_items'       => __( 'Search ' . $postType['plural_name'], 'jasperfm' ),
                    'parent_item_colon'  => __( 'Parent ' . $postType['plural_name'] . ': ', 'jasperfm' ),
                    'not_found'          => __( 'No ' . $postType['plural_name'] . ' found.', 'jasperfm' ),
                    'not_found_in_trash' => __( 'No ' . $postType['plural_name'] . ' found in Trash.', 'jasperfm' )
                );

                // if ($postType['show_in_menu'] == 'true' || $postType['show_in_menu'] == true) {
                //     $show_in_menu = true;
                // } else {
                //     $show_in_menu = false;
                // }
            
                $args = array(
                    'labels'             => $labels,
                    'description'        => __( 'A JasperFM generated custom post type.', 'jasperfm' ),
                    'public'             => true,
                    'publicly_queryable' => true,
                    'show_ui'            => true,
                    'show_in_menu'       => $show_in_menu,
                    'show_in_rest'       => true,
                    'query_var'          => true,
                    'rewrite'            => array( 'slug' => $postType['rewrite'] ),
                    'capability_type'    => 'post',
                    'has_archive'        => true,
                    'hierarchical'       => false,
                    'menu_position'      => $postType['menu_position'],
                    'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
                );
            
                register_post_type( 'jasperfm_' . $postType['name'], $args );
                
            }

        }

        $postTypes = get_post_types(['public' => true], 'objects');
        unset($postTypes['attachment']);
        $postTypeSettings = self::$settings['post_type_settings'];

        $newPostTypeSettings = [];

        foreach ($postTypes as $postType) {

            $newPostTypeSettings[$postType->name] = $postType;

            foreach($postTypeSettings as $postTypeSetting) {
                if ($postType->name == $postTypeSetting->name) {
                    $newPostTypeSettings[$postType->name]->post_fields = $postTypeSetting->post_fields;
                    break;
                }
            }

        }

        foreach ($newPostTypeSettings as $key => $postType) {
            
            if (isset($postType->post_fields) == false) {
                $postType->post_fields = [
                    [
                        'eval' => '',
                        'key' => 'post_title',
                        'type' => 'text',
                        'label' => 'Title',
                        'value' => '',
                        'is_meta' => false
                    ],
                    [
                        'eval' => '',
                        'key' => 'post_excerpt',
                        'type' => 'textarea',
                        'label' => 'Excerpt',
                        'value' => '',
                        'is_meta' => false
                    ]
                ];
            }
        }


        self::$settings['post_type_settings'] = $newPostTypeSettings;
        update_option('jasperfm-settings', self::$settings, false, 'yes');

    }

    /**
	 * Register all dashboard taxonomies
	 */
	public static function register_dashboard_taxonomy() {
        $postTypes = get_post_types();

        foreach($postTypes as $postType) {
            $labels = array(
                'name'              => _x( 'Dashboards', 'taxonomy general name', 'textdomain' ),
                'singular_name'     => _x( 'Dashboard', 'taxonomy singular name', 'textdomain' ),
            );

            $args = array(
                'hierarchical'      => false,
                'labels'            => $labels,
                'show_ui'           => false,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'dashboard'),
            );

            register_taxonomy( 'jasperfm_dashboard', $publicTypes, $args );
        }
    }

    /**
	 * Register all dashboard taxonomies
	 */
	public static function register_contributor_taxonomy() {
        $postTypes = get_post_types();

        foreach($postTypes as $postType) {
            $labels = array(
                'name'              => _x( 'Contributors', 'taxonomy general name', 'textdomain' ),
                'singular_name'     => _x( 'Contributor', 'taxonomy singular name', 'textdomain' ),
            );

            $args = array(
                'hierarchical'      => false,
                'labels'            => $labels,
                'show_ui'           => false,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'contributor'),
            );

            register_taxonomy( 'jasperfm_contributor', $publicTypes, $args );
        }
    }

    /**
	 * Register contributor post type
	 */
	public static function register_contributor_post_type() {
        $labels = array(
            'name'               => _x( 'Contributors', 'post type general name', 'jasperfm' ),
            'singular_name'      => _x( 'Contributor', 'post type singular name', 'jasperfm' ),
        );
    
        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Description.', 'jasperfm' ),
            'public'             => false,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'show_in_rest'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'conributor' ),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' )
        );
    
        register_post_type( 'jasperfm_contributor', $args );
    }
}
Settings::init();