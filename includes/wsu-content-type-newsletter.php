<?php

class WSU_Content_Type_Newsletter {

	var $post_type = 'wsu_newsletter';

	var $post_type_name = 'Newsletters';

	var $post_type_slug = 'newsletter';

	var $post_type_archive = 'newsletters';

	var $tax_newsletter_type = 'wsu_newsletter_type';

	public function __construct() {
		add_action( 'init',           array( $this, 'register_post_type'                ) );
		add_action( 'init',           array( $this, 'register_newsletter_type_taxonomy' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes'                    ) );

		add_filter( 'single_template', array( $this, 'single_template' ), 10, 1 );
	}

	public function register_post_type() {
		$labels = array(
			'name'               => $this->post_type_name,
			'singular_name'      => 'Newsletter',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Newsletter',
			'edit_item'          => 'Edit Newsletter',
			'new_item'           => 'New Newsletter',
			'all_items'          => 'All Newsletters',
			'view_item'          => 'View Newsletter',
			'search_items'       => 'Search Newsletters',
			'not_found'          => 'No newsletters found',
			'not_found_in_trash' => 'No newsletters found in Trash',
			'parent_item_colon'  => '',
			'menu_name'          => 'Newsletters',
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => $this->post_type_slug ),
			'capability_type'    => 'post',
			'has_archive'        => $this->post_type_archive,
			'hierarchical'       => false,
			'menu_position'      => 5,
			'supports'           => array( 'title' ),
			'taxonomies'         => array(),
		);

		register_post_type( $this->post_type, $args );
	}

	public function register_newsletter_type_taxonomy() {
		$labels = array(
			'name' => 'Newsletter Types',
			'singular_name' => 'Newsletter Type',
			'parent_item' => 'Parent Newsletter Type',
			'edit_item' => 'Edit Newsletter Type',
			'update_item' => 'Update Newsletter Type',
			'add_new_item' => 'Add Newsletter Type',
			'new_item_name' => 'New Newsletter Type',
		);

		$args = array(
			'hierarchical'          => true,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'query_var'             => true,
		);

		register_taxonomy( $this->tax_newsletter_type, array( $this->post_type ), $args );
	}

	public function add_meta_boxes() {
		add_meta_box( 'wsu_newsletter_items', 'Newsletter Items', array( $this, 'display_newsletter_items_meta_box' ), $this->post_type, 'normal' );
	}

	public function display_newsletter_items_meta_box() {
		// Select Newsletter Type
		?>
		<input type="button" value="Announcements" id="announcements" class="button button-large button-secondary newsletter-type" />
		<input type="button" value="News"          id="news"          class="button button-large button-secondary newsletter-type" />
		<?php
		// Add Subheads

		// Add Posts - from category, date range, text search

		// Add Announcements - from date range

		// Add text blurb, specifically for the bottom
	}

	public function single_template( $template ) {
		$current_object = get_queried_object();

		if ( isset( $current_object->post_type ) && $this->post_type === $current_object->post_type )
			return dirname( dirname( __FILE__ ) ) . '/templates/single-' . $this->post_type . '.php';
		else
			return $template;
	}
}
$wsu_content_type_newsletter = new WSU_Content_Type_Newsletter();
