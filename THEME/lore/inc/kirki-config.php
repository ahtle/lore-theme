<?php
/**
 * Kirki plugin configuration
 *
 * This plugin is used as a framework for WP Customizer
 *
 * @link https://kirki.org/docs/getting-started/config.html
 */
if ( class_exists( 'Kirki' ) ) {

Kirki::add_config( 'lsvr_lore_theme', array(
	'capability' => 'edit_theme_options',
	'option_type' => 'theme_mod',
));

/**
 * Remove Kirki's (ugly) loader icon
 */
add_filter( 'kirki/config', function( $config ) {
    $config['disable_loader'] = true;
    return $config;
});

/**
 * Default home page
 *
 * Settings for a page with Default Front Page template
 */
Kirki::add_section( 'defaultfp_settings', array(
	'title' => esc_html__( 'Default Front Page Settings', 'lore' ),
    'priority' => 900,
));

	// Info text
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_info',
		'type' => 'custom',
		'label' => esc_html__( 'Info', 'lore' ),
		'default' => esc_html__( 'Following settings apply only to a page which has its Page Template set to Default Front Page. Also, do not forget to choose this page as your front page under Settings / Reading.', 'lore' ),
		'priority' => 10,
	));

	// Content grid enable
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Enable Content Grid', 'lore' ),
		'description' => esc_html__( 'Content grid can list your Knowledge Base categories, custom menu items or widgets', 'lore' ),
		'default'  => 1,
		'priority' => 20,
	));

	// Number of columns for categories grid
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_columns',
		'type' => 'slider',
		'label' => esc_html__( 'Grid Columns', 'lore' ),
		'description' => esc_html__( 'Number of columns for content grid', 'lore' ),
		'choices' => array(
			'min' => 1,
			'max' => 4,
			'step' => 1,
		),
		'default'  => 4,
		'priority' => 30,
		'required' => array(
			array(
				'setting' => 'defaultfp_grid_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Enable Masonry
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_masonry',
		'type' => 'switch',
		'label' => esc_html__( 'Enable Masonry', 'lore' ),
		'description' => esc_html__( 'Enable Masonry layout for content grid', 'lore' ),
		'default'  => 1,
		'priority' => 40,
		'required' => array(
			array(
				'setting' => 'defaultfp_grid_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Grid title
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_title',
		'type' => 'text',
		'label' => esc_html__( 'Grid Title', 'lore' ),
		'description' => esc_html__( 'Title which will be displayed above the grid', 'lore' ),
		'default' => esc_html__( 'Selected topics', 'lore' ),
		'priority' => 50,
		'required' => array(
			array(
				'setting' => 'defaultfp_grid_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Grid btn label
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_btn_label',
		'type' => 'text',
		'label' => esc_html__( 'Grid Button Label', 'lore' ),
		'description' => esc_html__( 'Label of button which will be displayed above the grid', 'lore' ),
		'default' => esc_html__( 'Go To Knowledge Base', 'lore' ),
		'priority' => 60,
		'required' => array(
			array(
				'setting' => 'defaultfp_grid_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Grid btn link
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_btn_link',
		'type' => 'text',
		'label' => esc_html__( 'Grid Button Link', 'lore' ),
		'description' => esc_html__( 'Link of button which will be displayed above the grid', 'lore' ),
		'default' => '#',
		'priority' => 70,
		'required' => array(
			array(
				'setting' => 'defaultfp_grid_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Content grid source
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_source',
		'type' => 'radio',
		'label' => esc_html__( 'Content Grid Source', 'lore' ),
		'description' => esc_html__( 'Source of content for content grid element.', 'lore' )
			. '<p>' . esc_html__( 'KNOWLEDGE BASE CATEGORIES: make sure to create some Knowledge Base categories with articles for this option to work. Articles order is inherited from global Knowledge Base articles order settings under Appeareance / Customize / Knowledge Base', 'lore' ) . '</p>'
			. '<p>' . esc_html__( 'CUSTOM MENU: create your custom menu under Appearance / Menus and set its location to Content Grid. You can use Description field of top level menu items to add an icon (for example "loreico loreico-heart")', 'lore' ) . '</p>'
			. '<p>' . esc_html__( 'WIDGETS: if you select this option, you can populate content grid with widgets under Appearance / Widgets. Just drag and drop any widget into Content Grid sidebar', 'lore' ) . '</p>',
		'choices' => array(
			'knowledgebase' => esc_html__( 'Knowledge Base Categories', 'lore' ),
			'menu' => esc_html__( 'Custom Menu', 'lore' ),
			'widgets' => esc_html__( 'Widgets', 'lore' ),
		),
		'default' => 'knowledgebase',
		'priority' => 80,
		'required' => array(
			array(
				'setting' => 'defaultfp_grid_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Knowledge Base categories list limit
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_kb_cat_limit',
		'type' => 'slider',
		'label' => esc_html__( 'Knowledge Base Categories Limit', 'lore' ),
		'description' => esc_html__( 'If grid content is set to Knowledge Base Categories, set how many categories will be displayed in grid. Set to 0 to show all. Only top categories will be shown', 'lore' ),
		'choices' => array(
			'min' => 0,
			'max' => 20,
			'step' => 1,
		),
		'default' => 8,
		'priority' => 90,
		'required' => array(
			array(
				'setting' => 'defaultfp_grid_enable',
				'operator' => '==',
				'value' => 1,
			),
			array(
				'setting' => 'defaultfp_grid_source',
				'operator' => '==',
				'value' => 'knowledgebase',
			),
		),
	));

	// Articles list limit
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_kb_articles_limit',
		'type' => 'slider',
		'label' => esc_html__( 'Articles Per Category', 'lore' ),
		'description' => esc_html__( 'How many articles per category to show. Set to 0 to show all. Only direct child articles will be shown', 'lore' ),
		'choices' => array(
			'min' => 0,
			'max' => 20,
			'step' => 1,
		),
		'default' => 3,
		'priority' => 100,
		'required' => array(
			array(
				'setting' => 'defaultfp_grid_enable',
				'operator' => '==',
				'value' => 1,
			),
			array(
				'setting' => 'defaultfp_grid_source',
				'operator' => '==',
				'value' => 'knowledgebase',
			),
		),
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'defaultfp_settings',
		'settings'    => 'defaultfp_grid_cta_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 105,
	));

	// CTA brick
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_cta_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Enable CTA Block', 'lore' ),
		'description' => esc_html__( 'Your grid can contain a small CTA block', 'lore' ),
		'default'  => 1,
		'priority' => 110,
	));

	// CTA brick position
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_cta_position',
		'type' => 'radio',
		'label' => esc_html__( 'CTA Block Position', 'lore' ),
		'description' => esc_html__( 'You can display CTA as the first or as the last item of grid. Please note that if you set content grid layout to masonry, the CTA may not appear in the first/last position as Masonry script uses its own algorithm to determine the optimal position for each block', 'lore' ),
		'choices' => array(
			'first' => esc_html__( 'First', 'lore' ),
			'last' => esc_html__( 'Last', 'lore' ),
		),
		'default' => 'last',
		'priority' => 120,
		'required' => array(
			array(
				'setting' => 'defaultfp_grid_cta_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// CTA brick title
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_cta_title',
		'type' => 'text',
		'label' => esc_html__( 'CTA Block Title', 'lore' ),
		'description' => esc_html__( 'Title of the CTA block', 'lore' ),
		'default' => esc_html__( 'Hello World!', 'lore' ),
		'priority' => 130,
		'required' => array(
			array(
				'setting' => 'defaultfp_grid_cta_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// CTA brick text
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_cta_text',
		'type' => 'textarea',
		'label' => esc_html__( 'CTA Block Text', 'lore' ),
		'description' => esc_html__( 'Text content of the CTA block', 'lore' ),
		'default' => esc_html__( 'Lorem ipsum', 'lore' ),
		'priority' => 140,
		'required' => array(
			array(
				'setting' => 'defaultfp_grid_cta_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// CTA brick button label
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_cta_btn_label',
		'type' => 'text',
		'label' => esc_html__( 'CTA Block Button Label', 'lore' ),
		'description' => esc_html__( 'Label of CTA button displayed under text', 'lore' ),
		'default' => esc_html__( 'Learn More', 'lore' ),
		'priority' => 150,
		'required' => array(
			array(
				'setting' => 'defaultfp_grid_cta_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// CTA brick button link
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_grid_cta_btn_link',
		'type' => 'text',
		'label' => esc_html__( 'CTA Block Button Link', 'lore' ),
		'description' => esc_html__( 'Link of CTA button. Add an absolute URL please (with http:// or https:// respectively)', 'lore' ),
		'default' => esc_html__( '#', 'lore' ),
		'priority' => 160,
		'required' => array(
			array(
				'setting' => 'defaultfp_grid_cta_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'defaultfp_settings',
		'settings'    => 'defaultfp_blog_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 165,
	));

	// Blog list enable
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_blog_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Enable Blog List', 'lore' ),
		'description' => esc_html__( 'List latest blog posts', 'lore' ),
		'default'  => 1,
		'priority' => 170,
	));

	// Blog list title
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_blog_title',
		'type' => 'text',
		'label' => esc_html__( 'Blog List Title', 'lore' ),
		'description' => esc_html__( 'Title which will be displayed above blog list', 'lore' ),
		'default' => esc_html__( 'Recent Blog Posts', 'lore' ),
		'priority' => 180,
		'required' => array(
			array(
				'setting' => 'defaultfp_blog_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Blog list btn label
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_blog_btn_label',
		'type' => 'text',
		'label' => esc_html__( 'Blog List Button Label', 'lore' ),
		'description' => esc_html__( 'Label of button which links to blog archive page. Leave blank to hide button', 'lore' ),
		'default' => esc_html__( 'More Posts', 'lore' ),
		'priority' => 190,
		'required' => array(
			array(
				'setting' => 'defaultfp_blog_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Post limit
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_blog_post_limit',
		'type' => 'slider',
		'label' => esc_html__( 'Post Count', 'lore' ),
		'description' => esc_html__( 'How many posts to show. Set to 0 to show all posts', 'lore' ),
		'choices' => array(
			'min' => 0,
			'max' => 20,
			'step' => 1,
		),
		'default' => 3,
		'priority' => 200,
		'required' => array(
			array(
				'setting' => 'defaultfp_blog_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Columns
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'defaultfp_settings',
		'settings' => 'defaultfp_blog_columns',
		'type' => 'slider',
		'label' => esc_html__( 'Columns Count', 'lore' ),
		'description' => esc_html__( 'How many posts per row to show', 'lore' ),
		'choices' => array(
			'min' => 1,
			'max' => 3,
			'step' => 1,
		),
		'default' => 3,
		'priority' => 210,
		'required' => array(
			array(
				'setting' => 'defaultfp_blog_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));


/**
 * Header settings
 */
Kirki::add_section( 'header_settings', array(
	'title' => esc_html__( 'Header Settings', 'lore' ),
    'priority' => 1000,
));

 	// Max Logo width
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'header_settings',
		'settings' => 'header_logo_width',
		'type' => 'number',
		'label' => esc_html__( 'Max Logo Width', 'lore' ),
		'description' => esc_html__( 'Limit the width of the header logo image (in pixels). Please note that max width of the logo is limited to approximately 30% of header width. Set to 0 to disable', 'lore' ),
		'choices' => array(
			'min' => 50,
			'max' => 500,
			'min' => 0,
		),
		'default' => 0,
		'priority' => 5,
	));

 	// Background image
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'header_settings',
		'settings' => 'header_bg_image',
		'type' => 'image',
		'label' => esc_html__( 'Background Image', 'lore' ),
		'description' => esc_html__( 'Optimal resolution is about 2000x1000px. You can override this background for regular pages using their Featured Image', 'lore' ),
		'priority' => 10,
	));

	// Background image alignment
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'header_settings',
		'settings' => 'header_bg_image_alignment',
		'type' => 'radio',
		'label' => esc_html__( 'Background Alignment', 'lore' ),
		'description' => esc_html__( 'Vertical alignment of the background image', 'lore' ),
		'choices' => array(
			'top' => esc_html__( 'Top', 'lore' ),
			'center' => esc_html__( 'Center', 'lore' ),
			'bottom' => esc_html__( 'Bottom', 'lore' ),
		),
		'default' => 'top',
		'priority' => 20,
		'transport' => 'postMessage'
	));

	// Background overlay
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'header_settings',
		'settings' => 'header_bg_image_overlay',
		'type' => 'slider',
		'label' => esc_html__( 'Background Overlay', 'lore' ),
		'description' => esc_html__( 'Opacity of dark layer displayed over background image for better readability. Set to 0 to completely disable it', 'lore' ),
		'choices' => array(
			'min' => 0,
			'max' => 100,
			'step' => 5,
		),
		'default' => 0,
		'priority' => 30,
		'transport' => 'postMessage'
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'header_settings',
		'settings'    => 'header_search_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 35,
	));

	// Header Search
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'header_settings',
		'settings' => 'header_search_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Header Search', 'lore' ),
		'description' => esc_html__( 'Show search input in Header', 'lore' ),
		'default'  => 1,
		'priority' => 40,
	));

	// Large header search
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'header_settings',
		'settings' => 'header_search_large_enable',
		'type' => 'radio',
		'label' => esc_html__( 'Large Header Search', 'lore' ),
		'description' => esc_html__( 'Choose where to display large version of header search. The compact version (in the form of header menu icon) will be displayed on pages where this large version is disabled', 'lore' ),
        'choices' => array(
        	'everywhere' => esc_html__( 'Show Everywhere', 'lore' ),
            'kbandfront' => esc_html__( 'Knowledge Base and Front Page Only', 'lore' ),
            'knowledgebase' => esc_html__( 'Knowledge Base Only', 'lore' ),
            'frontpage' => esc_html__( 'Front Page Only', 'lore' ),
            'disable' => esc_html__( 'Disable', 'lore' ),
        ),
        'default' => 'everywhere',
		'priority' => 50,
		'required' => array(
			array(
				'setting' => 'header_search_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Ajax search
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'header_settings',
		'settings' => 'header_search_ajax_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Ajax Search', 'lore' ),
		'description' => esc_html__( 'Return search results without refreshing the site', 'lore' ),
		'default'  => 1,
		'priority' => 60,
		'required' => array(
			array(
				'setting' => 'header_search_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Search filter
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'header_settings',
		'settings' => 'header_search_filter_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Search Filter', 'lore' ),
		'description' => esc_html__( 'Show search filter after clicking on search input', 'lore' ),
		'default'  => 1,
		'priority' => 65,
		'required' => array(
			array(
				'setting' => 'header_search_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Ajax search results limit
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'header_settings',
		'settings' => 'header_search_ajax_results_limit',
		'type' => 'slider',
		'label' => esc_html__( 'Number of Search Results', 'lore' ),
		'description' => esc_html__( 'Maximum number of search results to display in ajax search', 'lore' ),
		'choices' => array(
			'min' => 1,
			'max' => 100,
			'step' => 1,
		),
		'default'  => 10,
		'priority' => 70,
		'required' => array(
			array(
				'setting' => 'header_search_ajax_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Search input placeholder text
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'header_settings',
		'settings' => 'header_search_placeholder',
		'type' => 'text',
		'label' => esc_html__( 'Search Input Placeholder', 'lore' ),
		'default' => esc_html__( 'Search the Knowledge Base', 'lore' ),
		'priority' => 80,
		'required' => array(
			array(
				'setting' => 'header_search_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Suggested search keywords
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'header_settings',
		'settings' => 'header_search_suggestions',
		'type' => 'text',
		'label' => esc_html__( 'Suggested Keywords', 'lore' ),
		'description' => esc_html__( 'List of suggested keywords separated by comma. For example: "installation, demo import, translation" (without quotes). Leave blank to hide', 'lore' ),
		'priority' => 90,
		'required' => array(
			array(
				'setting' => 'header_search_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'header_settings',
		'settings'    => 'header_fixed_navbar_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 95,
	));

	// Fixed navbar
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'header_settings',
		'settings' => 'header_fixed_navbar_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Fixed Navbar', 'lore' ),
		'description' => esc_html__( 'Navbar will stick to the top of the page after scrolling down', 'lore' ),
		'default'  => 1,
		'priority' => 100,
	));

	/**
	 * Header content offset
	 *
	 * Prevents fixed navbar from overlapping the header content
	 */
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'header_settings',
		'settings' => 'header_content_offset',
		'type' => 'slider',
		'label' => esc_html__( 'Header Content Offset', 'lore' ),
		'description' => esc_html__( 'White space at the top of the Header which prevents Large Header Search being overlapped by Navbar. This value should be slighty higher than height of your Navbar', 'lore' ),
		'choices' => array(
			'min' => 0,
			'max' => 300,
			'step' => 1,
		),
		'default'  => 100,
		'priority' => 110,
		'required' => array(
			array(
				'setting' => 'header_fixed_navbar_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));


/**
 * Footer settings
 */
Kirki::add_section( 'footer_settings', array(
	'title' => esc_html__( 'Footer Settings', 'lore' ),
    'priority' => 1010,
));

	// Number of columns for footer widgets area
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'footer_settings',
		'settings' => 'footer_widgets_cols',
		'type' => 'slider',
		'label' => esc_html__( 'Footer Widgets Columns', 'lore' ),
		'description' => esc_html__( 'Set number of widgets per row for Footer Widgets area. Widgets can be added under Appearance / Widgets', 'lore' ),
		'choices' => array(
			'min' => 1,
			'max' => 4,
			'step' => 1,
		),
		'default'  => 3,
		'priority' => 10,
		'transport' => 'postMessage'
	));

	// Show social icons in footer
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'footer_settings',
		'settings' => 'footer_social_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Social Icons', 'lore' ),
		'description' => esc_html__( 'Show social icons in footer. Social icons can be defined under Social Link tab in Customizer', 'lore' ),
		'default'  => 1,
		'priority' => 20,
	));

	// Footer text
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'footer_settings',
		'settings' => 'footer_text',
		'type' => 'textarea',
		'label' => esc_html__( 'Footer Text', 'lore' ),
		'description' => esc_html__( 'Ideal for copyright notice', 'lore' ),
		'default'  => '&copy; ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ),
		'priority' => 30,
		'transport' => 'postMessage'
	));

	// Show scroll to top button
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'footer_settings',
		'settings' => 'footer_scroll_top_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Scroll To Top Button', 'lore' ),
		'description' => esc_html__( 'Show "scroll to top" button which will scroll the page to the very top after clicking', 'lore' ),
		'default'  => 1,
		'priority' => 40,
	));


/**
 * Blog settings
 */
Kirki::add_section( 'blog_settings', array(
	'title' => esc_html__( 'Standard Posts (Blog)', 'lore' ),
    'priority' => 1040,
));

	// Info text
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'blog_settings',
		'settings' => 'blog_info',
		'type' => 'custom',
		'label' => esc_html__( 'Info', 'lore' ),
		'default' => esc_html__( 'Do not forget to set your Posts page under Settings / Reading', 'lore' ),
		'priority' => 10,
	));

	// Header background image for blog pages
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'blog_settings',
		'settings' => 'blog_bg_image',
		'type' => 'image',
		'label' => esc_html__( 'Background Image', 'lore' ),
		'description' => esc_html__( 'Header background image for all standard post pages (post list, post detail, category view etc.). Optimal resolution is about 2000x1000px', 'lore' ),
		'priority' => 20,
	));

	// Sidebar position on blog pages
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'blog_settings',
		'settings' => 'blog_sidebar_position',
		'type' => 'radio',
		'label' => esc_html__( 'Sidebar Position', 'lore' ),
		'description' => esc_html__( 'Position of the sidebar on all standard post pages', 'lore' ),
        'choices' => array(
            'left' => esc_html__( 'Left', 'lore' ),
            'right' => esc_html__( 'Right', 'lore' ),
            'disable' => esc_html__( 'Disable Sidebar', 'lore' ),
        ),
        'default' => 'right',
		'priority' => 30,
	));

	// Show post author bio
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'blog_settings',
		'settings' => 'blog_single_author_bio_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Show Author Bio on Post Detail', 'lore' ),
		'description' => esc_html__( 'You can edit author bio under Users', 'lore' ),
		'default'  => 1,
		'priority' => 40,
	));

	// Show links to next and previous posts on post detail page
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'blog_settings',
		'settings' => 'blog_single_navigation_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Show Post Navigation', 'lore' ),
		'description' => esc_html__( 'Show links to previous and next post in post detail', 'lore' ),
		'default'  => 1,
		'priority' => 50,
	));


/**
 * Knowledge Base settings
 */
$lsvr_kb_slug = get_theme_mod( 'kb_slug', 'knowledge-base' );
$lsvr_kb_url = get_site_url() . '/' . $lsvr_kb_slug;
Kirki::add_section( 'kb_settings', array(
	'title' => esc_html__( 'Knowledge Base', 'lore' ),
    'priority' => 1050,
));

	// Info text
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_info',
		'type' => 'custom',
		'label' => esc_html__( 'Your current Knowledge Base URL', 'lore' ),
		'default' => '<p><a href="' . $lsvr_kb_url . '">' . $lsvr_kb_url . '</a></p><p>' . esc_html__( 'IMPORTANT: After making any changes in Knowledge Base URL Slug, Knowledge Base Category URL Slug and Knowledge Base Tag URL Slug settings, please go to Settings / Permalinks and hit Save Changes', 'lore' ) . '</p>',
		'priority' => 10,
	));

	// Knowledge Base pages title
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_title',
		'type' => 'text',
		'label' => esc_html__( 'Knowledge Base Title', 'lore' ),
		'description' => esc_html__( 'Title used for default Knowledge Base page, breadcrumbs etc.', 'lore' ),
		'default' => esc_html__( 'Knowledge Base', 'lore' ),
		'priority' => 20,
	));

	// Knowledge Base archive page URL slug
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_slug',
		'type' => 'text',
		'label' => esc_html__( 'Knowledge Base URL Slug', 'lore' ),
		'description' => esc_html__( 'Slug defines the URL of your default Knowledge Base page', 'lore' ),
		'default' => 'knowledge-base',
		'priority' => 30,
	));

	// Knowledge Base category URL page slug
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_cat_slug',
		'type' => 'text',
		'label' => esc_html__( 'Knowledge Base Category URL Slug', 'lore' ),
		'description' => esc_html__( 'This Slug defines the URL of page which shows posts from certain Knowledge Base category', 'lore' ),
		'default' => 'knowledge-base-category',
		'priority' => 40,
	));

	// Knowledge Base tag page URL slug
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_tag_slug',
		'type' => 'text',
		'label' => esc_html__( 'Knowledge Base Tag URL Slug', 'lore' ),
		'description' => esc_html__( 'This Slug defines the URL of page which shows posts with certain Knowledge Base tag', 'lore' ),
		'default' => 'knowledge-base-tag',
		'priority' => 50,
	));

	// Header background image for Knowledge Base pages
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_bg_image',
		'type' => 'image',
		'label' => esc_html__( 'Background Image', 'lore' ),
		'description' => esc_html__( 'Header background image for all Knowledge Base pages. Optimal resolution is about 2000x1000px', 'lore' ),
		'priority' => 60,
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'kb_settings',
		'settings'    => 'kb_archive_layout_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 65,
	));

	// Page layout of default Knowledge Base archive page
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_archive_layout',
		'type' => 'radio',
		'label' => esc_html__( 'Archive Page Layout', 'lore' ),
		'description' => esc_html__( 'Layout of the Knowledge Base archive page. If you choose "Category View", make sure to have your Knowledge Base articles assigned to categories for this layout to work', 'lore' ),
        'choices' => array(
        	'article_view' => esc_html__( 'Article View', 'lore' ),
        	'category_view' => esc_html__( 'Category View', 'lore' ),
        ),
        'default' => 'article_view',
		'priority' => 70,
	));

	// Number of columns if Knowledge base archive page layout is set to Category View
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_archive_columns',
		'type' => 'slider',
		'label' => esc_html__( 'Category View Columns', 'lore' ),
		'description' => esc_html__( 'Number of columns on Knowledge Base category view archive page', 'lore' ),
		'choices' => array(
			'min' => 1,
			'max' => 4,
			'step' => 1,
		),
		'default'  => 3,
		'priority' => 80,
		'required' => array(
			array(
				'setting' => 'kb_archive_layout',
				'operator' => '==',
				'value' => 'category_view',
			),
		),
	));

	// Enable Masonry for archive page Category View
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_archive_masonry',
		'type' => 'switch',
		'label' => esc_html__( 'Enable Masonry', 'lore' ),
		'description' => esc_html__( 'Enable Masonry layout for Knowledge Base category view archive page', 'lore' ),
		'default'  => 1,
		'priority' => 85,
		'required' => array(
			array(
				'setting' => 'kb_archive_layout',
				'operator' => '==',
				'value' => 'category_view',
			),
		),
	));

	// Sidebar position on Knowledge Base pages
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_sidebar_position',
		'type' => 'radio',
		'label' => esc_html__( 'Sidebar Position', 'lore' ),
		'description' => esc_html__( 'Position of the sidebar on Knowledge Base pages', 'lore' ),
        'choices' => array(
            'left' => esc_html__( 'Left', 'lore' ),
            'right' => esc_html__( 'Right', 'lore' ),
            'disable' => esc_html__( 'Disable Sidebar', 'lore' ),
        ),
        'default' => 'left',
		'priority' => 90,
	));

	// Order of Knowledge Base articles
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_articles_order',
		'type' => 'radio',
		'label' => esc_html__( 'Articles Order', 'lore' ),
		'description' => esc_html__( 'Articles order for all Knowledge Base pages and widgets. Leave it on "Default" if you want to use 3rd party plugin to set the order. On the other hand, if you want to use one of the other options, make sure to disable any other 3rd party plugin which can interfere with this functionality', 'lore' ),
        'choices' => array(
            'default' => esc_html__( 'Default', 'lore' ),
            'date_desc' => esc_html__( 'By Date (Newest First)', 'lore' ),
            'date_asc' => esc_html__( 'By Date (Oldest First)', 'lore' ),
            'title' => esc_html__( 'By Title', 'lore' ),
        ),
        'default' => 'default',
		'priority' => 100,
	));

	// Max number of articles shown on default Knowledge Base pages
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_per_page',
		'type' => 'slider',
		'label' => esc_html__( 'Articles Per Page', 'lore' ),
		'description' => esc_html__( 'Number of Knowledge Base articles per page on article view archive page, Category and Tag pages. Set to 0 to show all articles', 'lore' ),
		'choices' => array(
			'min' => 0,
			'max' => 100,
			'step' => 1,
		),
		'default'  => 10,
		'priority' => 105,
	));

	// Max number of articles shown on Category View archive page
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_archive_category_view_limit',
		'type' => 'slider',
		'label' => esc_html__( 'Category View Archive Page Articles Limit', 'lore' ),
		'description' => esc_html__( 'Number of articles per category on category view archive page. Set to 0 to show all articles', 'lore' ),
		'choices' => array(
			'min' => 0,
			'max' => 100,
			'step' => 1,
		),
		'default'  => 0,
		'priority' => 110,
		'required' => array(
			array(
				'setting' => 'kb_archive_layout',
				'operator' => '==',
				'value' => 'category_view',
			),
		),
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'kb_settings',
		'settings'    => 'kb_rating_enable_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 115,
	));

	// Enable rating for Knowledge Base articles
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_rating_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Allow Article Rating', 'lore' ),
		'description' => esc_html__( 'Enable likes and dislikes on Knowledge Base articles', 'lore' ),
		'default'  => 1,
		'priority' => 130,
	));

	/**
	 * Enable dislikes for Knowledge Base articles
	 *
	 * Article rating have to be enabled
	 */
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_rating_dislikes_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Allow Dislikes', 'lore' ),
		'description' => esc_html__( 'If disabled, only likes will be displayed', 'lore' ),
		'default'  => 1,
		'priority' => 140,
		'required' => array(
			array(
				'setting' => 'kb_rating_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	/**
	 * Rating interval
	 *
	 * How often can single user rate an article
	 */
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_rating_interval',
		'type' => 'select',
		'label' => esc_html__( 'Rating Interval', 'lore' ),
		'description' => esc_html__( 'How often can a visitor rate single article. Once per:', 'lore' ),
		'choices' => array(
			'1hour' => esc_html__( 'Hour', 'lore' ),
			'day' => esc_html__( 'Day', 'lore' ),
			'week' => esc_html__( 'Week', 'lore' ),
			'month' => esc_html__( 'Month', 'lore' ),
			'threemonths' => esc_html__( 'Three Months', 'lore' ),
			'sixmonths' => esc_html__( 'Six Months', 'lore' ),
			'year' => esc_html__( 'Year', 'lore' ),
			'tenyears' => esc_html__( '10 Years', 'lore' ),
		),
		'default'  => 'month',
		'priority' => 145,
		'required' => array(
			array(
				'setting' => 'kb_rating_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	/**
	 * Type of rating results to display
	 *
	 * Show both likes and dislikes, likes only or difference between the two
	 */
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_rating_type',
		'type' => 'radio',
		'label' => esc_html__( 'Rating Style', 'lore' ),
		'description' => esc_html__( 'How to display rating values. Please note that even if you choose "difference", both values will be displayed on Knowledge Base article detail page', 'lore' ),
		'choices' => array(
			'difference' => esc_html__( 'Show difference between likes and dislikes', 'lore' ),
			'both' => esc_html__( 'Show both likes and dislikes', 'lore' ),
		),
		'default'  => 'difference',
		'priority' => 150,
		'required' => array(
			array(
				'setting' => 'kb_rating_enable',
				'operator' => '==',
				'value' => 1,
			),
			array(
				'setting' => 'kb_rating_dislikes_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'kb_settings',
		'settings'    => 'kb_article_contents_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 175,
	));

	/**
	 * Show Table of Contents
	 *
	 * Automatically insert table of content before the article content
	 * Table of content is created via lore_contents shortcode
	 */
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_article_contents_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Show Table of Contents', 'lore' ),
		'description' => esc_html__( 'Display table of contents on article detail. It consists of links to all headline elements of article (H1, H2, H3, etc.) with ID attribute. You have to edit the HTML code of the article to add those IDs. For example &lt;h2 id="unique-id"&gt;My headline&lt;/h2&gt;', 'lore' ),
		'default'  => 0,
		'priority' => 170,
	));

	// Table of contents title
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_article_contents_title',
		'type' => 'text',
		'label' => esc_html__( 'Table of Contents Title', 'lore' ),
		'description' => esc_html__( 'Leave blank to hide title', 'lore' ),
		'default'  => esc_html__( 'Contents', 'lore' ),
		'priority' => 180,
		'required' => array(
			array(
				'setting' => 'kb_article_contents_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	/**
	 * List of exluded IDs for table of contents
	 *
	 * Elements with those IDs won't be included in table of contents
	 */
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_article_contents_excluded_ids',
		'type' => 'text',
		'label' => esc_html__( 'Table of Contents Excluded IDs', 'lore' ),
		'description' => esc_html__( 'Elements with these IDs will be ignored. Separate with comma', 'lore' ),
		'priority' => 190,
		'required' => array(
			array(
				'setting' => 'kb_article_contents_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));

	// Show date of last update of the article
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_single_last_update_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Show Last Update Date', 'lore' ),
		'description' => esc_html__( 'Show date of last modification of article on its detail page. The last modification date will be displayed only if it is different to publish date', 'lore' ),
		'default'  => 1,
		'priority' => 200,
	));

	/**
	 * Show related articles
	 *
	 * Random articles from the same category
	 */
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_single_related_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Show Related Articles', 'lore' ),
		'description' => esc_html__( 'Display random articles from the same category', 'lore' ),
		'default'  => 1,
		'priority' => 210,
	));

	// Number of random articles
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'kb_settings',
		'settings' => 'kb_single_related_limit',
		'type' => 'slider',
		'label' => esc_html__( 'Number of Related Articles', 'lore' ),
		'description' => esc_html__( 'Set to "0" to display all related articles', 'lore' ),
		'choices' => array(
			'min' => 0,
			'max' => 15,
			'step' => 1,
		),
		'default'  => 3,
		'priority' => 210,
		'required' => array(
			array(
				'setting' => 'kb_single_related_enable',
				'operator' => '==',
				'value' => 1,
			),
		),
	));


/**
 * FAQ settings
 */
$lsvr_faq_slug = get_theme_mod( 'faq_slug', 'faq' );
$lsvr_faq_url = get_site_url() . '/' . $lsvr_faq_slug;
Kirki::add_section( 'faq_settings', array(
	'title' => esc_html__( 'FAQ', 'lore' ),
    'priority' => 1060,
));

	// Info text
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'faq_settings',
		'settings' => 'faq_info',
		'type' => 'custom',
		'label' => esc_html__( 'Your current FAQ URL', 'lore' ),
		'default' => '<p><a href="' . $lsvr_faq_url . '">' . $lsvr_faq_url . '</a></p><p>' . esc_html__( 'IMPORTANT: After making any changes in FAQ URL Slug, FAQ Category URL Slug and FAQ Tag URL Slug settings, please go to Settings / Permalinks and hit Save Changes', 'lore' ) . '</p>',
		'priority' => 10,
	));

	// FAQ pages title
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'faq_settings',
		'settings' => 'faq_title',
		'type' => 'text',
		'label' => esc_html__( 'FAQ Title', 'lore' ),
		'description' => esc_html__( 'Title used for default FAQ page, breadcrumbs etc.', 'lore' ),
		'default' => esc_html__( 'FAQ', 'lore' ),
		'priority' => 20,
	));

	// FAQ archive page URL slug
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'faq_settings',
		'settings' => 'faq_slug',
		'type' => 'text',
		'label' => esc_html__( 'FAQ URL Slug', 'lore' ),
		'description' => esc_html__( 'Slug defines the URL of your default FAQ page', 'lore' ),
		'default' => 'faq',
		'priority' => 30,
	));

	// FAQ category page URL slug
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'faq_settings',
		'settings' => 'faq_cat_slug',
		'type' => 'text',
		'label' => esc_html__( 'FAQ Category URL Slug', 'lore' ),
		'description' => esc_html__( 'This Slug defines the URL of page which shows posts from certain FAQ category', 'lore' ),
		'default' => 'faq-category',
		'priority' => 40,
	));

	// FAQ category page URL slug
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'faq_settings',
		'settings' => 'faq_tag_slug',
		'type' => 'text',
		'label' => esc_html__( 'FAQ Tag URL Slug', 'lore' ),
		'description' => esc_html__( 'This Slug defines the URL of page which shows posts with certain FAQ tags', 'lore' ),
		'default' => 'faq-tag',
		'priority' => 50,
	));

	// Header background for FAQ pages
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'faq_settings',
		'settings' => 'faq_bg_image',
		'type' => 'image',
		'label' => esc_html__( 'Background Image', 'lore' ),
		'description' => esc_html__( 'Header background image for all FAQ pages. Optimal resolution is about 2000x1000px', 'lore' ),
		'priority' => 60,
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'faq_settings',
		'settings'    => 'faq_sidebar_position_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 65,
	));

	// Sidebar position for FAQ pages
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'faq_settings',
		'settings' => 'faq_sidebar_position',
		'type' => 'radio',
		'label' => esc_html__( 'Sidebar Position', 'lore' ),
		'description' => esc_html__( 'Position of the sidebar on all FAQ pages', 'lore' ),
        'choices' => array(
            'left' => esc_html__( 'Left', 'lore' ),
            'right' => esc_html__( 'Right', 'lore' ),
            'disable' => esc_html__( 'Disable Sidebar', 'lore' ),
        ),
        'default' => 'right',
		'priority' => 70,
	));

	// Order of FAQ posts
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'faq_settings',
		'settings' => 'faq_order',
		'type' => 'radio',
		'label' => esc_html__( 'FAQ Order', 'lore' ),
		'description' => esc_html__( 'Post order for all FAQ pages and widgets. Leave it on "Default" if you want to use 3rd party plugin to set the order. Otherwise, if you want to use one of the other options, make sure to disable any other 3rd party plugin which can interfere with this functionality', 'lore' ),
        'choices' => array(
            'default' => esc_html__( 'Default', 'lore' ),
            'date_desc' => esc_html__( 'By Date (Newest First)', 'lore' ),
            'date_asc' => esc_html__( 'By Date (Oldest First)', 'lore' ),
            'title' => esc_html__( 'By Title', 'lore' ),
        ),
        'default' => 'default',
		'priority' => 80,
	));

	// Number of posts per page for FAQ archive pages
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'faq_settings',
		'settings' => 'faq_per_page',
		'type' => 'slider',
		'label' => esc_html__( 'FAQ Posts Per Page', 'lore' ),
		'description' => esc_html__( 'Number of FAQ posts per page on default FAQ page and FAQ Category page. Set to 0 to show all FAQ posts', 'lore' ),
		'choices' => array(
			'min' => 0,
			'max' => 100,
			'step' => 1,
		),
		'default' => 0,
		'priority' => 90,
	));

	// Default state of FAQ posts
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'faq_settings',
		'settings' => 'faq_default_state',
		'type' => 'radio',
		'label' => esc_html__( 'FAQ Default State', 'lore' ),
		'description' => esc_html__( 'Set default state of all FAQ posts', 'lore' ),
        'choices' => array(
            'closed' => esc_html__( 'Collapsed', 'lore' ),
            'open' => esc_html__( 'Expanded', 'lore' ),
        ),
        'default' => 'closed',
		'priority' => 100,
	));

	// Show permalink for FAQ posts
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'faq_settings',
		'settings' => 'faq_permalink_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Show Permalink', 'lore' ),
		'description' => esc_html__( 'Show FAQ post permalink on default FAQ page and FAQ Category page', 'lore' ),
        'default' => 1,
		'priority' => 110,
	));


/**
 * Color scheme settings
 */
Kirki::add_section( 'color_settings', array(
	'title' => esc_html__( 'Color Scheme', 'lore' ),
    'priority' => 1070,
));

	// Source of color scheme
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'color_settings',
		'settings' => 'color_source',
		'type' => 'radio',
		'label' => esc_html__( 'Color Scheme Source', 'lore' ),
		'description' => esc_html__( 'You can choose a predefined color scheme, select an accent color or generate custom color scheme code (please read the documentation for more info). If you choose "Load From Child Theme" option, simply put your color scheme CSS into child theme style.css file', 'lore' ),
		'choices' => array(
			'predefined' => esc_html__( 'Predefined Color Scheme', 'lore' ),
			'colorpicker' => esc_html__( 'Pick Colors', 'lore' ),
			'inline' => esc_html__( 'Paste Generated CSS', 'lore' ),
			'childtheme' => esc_html__( 'Load From Child Theme', 'lore' ),
		),
		'default'  => 'predefined',
		'priority' => 10,
	));

	// List of predefined color schemes bundled with the theme
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'color_settings',
		'settings' => 'color_predefined',
		'type' => 'select',
		'label' => esc_html__( 'Choose Color Scheme', 'lore' ),
		'choices' => array(
			'green' => esc_html__( 'Green', 'lore' ),
			'orange' => esc_html__( 'Orange', 'lore' ),
			'cyan' => esc_html__( 'Cyan', 'lore' ),
			'yellow' => esc_html__( 'Yellow', 'lore' ),
		),
		'default'  => 'green',
		'priority' => 20,
		'required' => array(
			array(
				'setting' => 'color_source',
				'operator' => '==',
				'value' => 'predefined',
			),
		),
	));

	// Choose an accent color to create custom color scheme
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'color_settings',
		'settings' => 'color_pick_link',
		'type' => 'color',
		'label' => esc_html__( 'Pick Link Color', 'lore' ),
		'description' => esc_html__( 'Color of content links and few other elements', 'lore' ),
		'default'  => '#1565c0',
		'priority' => 30,
		'required' => array(
			array(
				'setting' => 'color_source',
				'operator' => '==',
				'value' => 'colorpicker',
			),
		),
	));

	// Choose an accent color to create custom color scheme
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'color_settings',
		'settings' => 'color_pick_accent',
		'type' => 'color',
		'label' => esc_html__( 'Pick Accent Color', 'lore' ),
		'description' => esc_html__( 'Main color of the color scheme', 'lore' ),
		'default'  => '#74aa7b',
		'priority' => 40,
		'required' => array(
			array(
				'setting' => 'color_source',
				'operator' => '==',
				'value' => 'colorpicker',
			),
		),
	));

	// Paste generated CSS code to use as color scheme
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'color_settings',
		'settings' => 'color_inline',
		'type' => 'textarea',
		'label' => esc_html__( 'Generated CSS', 'lore' ),
		'description' => esc_html__( 'Paste your CSS here. Please refer to the documentation to learn how to generate CSS for custom color scheme', 'lore' ),
		'priority' => 50,
		'required' => array(
			array(
				'setting' => 'color_source',
				'operator' => '==',
				'value' => 'inline',
			),
		),
	));

	/**
	 * Load color scheme from child theme
	 *
	 * CSS have to be added in style.css file in Child theme
	 */
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'color_settings',
		'settings' => 'color_child',
		'type' => 'custom',
		'label' => esc_html__( 'Info', 'lore' ),
		'description' => esc_html__( 'Paste your custom scheme CSS into style.css file in child theme folder', 'lore' ),
		'priority' => 60,
		'required' => array(
			array(
				'setting' => 'color_source',
				'operator' => '==',
				'value' => 'childtheme',
			),
		),
	));


/**
 * Typography settings
 */
Kirki::add_section( 'typography_settings', array(
	'title' => esc_html__( 'Typography', 'lore' ),
    'priority' => 1080,
));

	// Enable Google Fonts
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'typography_settings',
		'settings' => 'typography_gf_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Enable Google Fonts', 'lore' ),
		'description' => esc_html__( 'If you disable Google Fonts, default sans-serif font (Arial) will be used for all text', 'lore' ),
		'default'  => 1,
		'priority' => 10,
	));

	// Primary font
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'typography_settings',
		'settings' => 'typography_primary_font',
		'type' => 'select',
		'label' => esc_html__( 'Primary Font', 'lore' ),
		'description' => esc_html__( 'This font will be used for almost all text except some headlines and titles. Default primary font is Open Sans', 'lore' ),
		'choices' => array(
			'Alegreya' => 'Alegreya',
			'Alegreya+Sans' => 'Alegreya Sans',
			'Archivo+Narrow' => 'Archivo Narrow',
			'Fira+Sans' => 'Fira Sans',
			'Inconsolata' => 'Inconsolata',
			'Karla' => 'Karla',
			'Lato' => 'Lato',
			'Libre+Baskerville' => 'Libre Baskerville',
			'Lora' => 'Lora',
			'Merriweather' => 'Merriweather',
			'Montserrat' => 'Montserrat',
			'Open+Sans' => 'Open Sans',
			'PT+Serif' => 'PT Serif',
			'Playfair+Display' => 'Playfair Display',
			'Roboto' => 'Roboto',
			'Roboto+Slab' => 'Roboto Slab',
			'Source+Sans+Pro' => 'Source Sans Pro',
			'Source+Serif+Pro' => 'Source Serif Pro',
			'Work+Sans' => 'Work Sans',
		),
		'default' => 'Open+Sans',
		'priority' => 20,
		'required' => array(
			array(
				'setting' => 'typography_gf_enable',
				'operator' => '==',
				'value' => true,
			),
		),
	));

	// Secondary font
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'typography_settings',
		'settings' => 'typography_secondary_font',
		'type' => 'select',
		'label' => esc_html__( 'Secondary Font', 'lore' ),
		'description' => esc_html__( 'This font will be used for headlines. Default secondary font is Roboto Slab', 'lore' ),
		'choices' => array(
			'Alegreya' => 'Alegreya',
			'Alegreya+Sans' => 'Alegreya Sans',
			'Archivo+Narrow' => 'Archivo Narrow',
			'Fira+Sans' => 'Fira Sans',
			'Inconsolata' => 'Inconsolata',
			'Karla' => 'Karla',
			'Lato' => 'Lato',
			'Libre+Baskerville' => 'Libre Baskerville',
			'Lora' => 'Lora',
			'Merriweather' => 'Merriweather',
			'Montserrat' => 'Montserrat',
			'Open+Sans' => 'Open Sans',
			'PT+Serif' => 'PT Serif',
			'Playfair+Display' => 'Playfair Display',
			'Roboto' => 'Roboto',
			'Roboto+Slab' => 'Roboto Slab',
			'Source+Sans+Pro' => 'Source Sans Pro',
			'Source+Serif+Pro' => 'Source Serif Pro',
			'Work+Sans' => 'Work Sans',
		),
		'default' => 'Merriweather',
		'priority' => 30,
		'required' => array(
			array(
				'setting' => 'typography_gf_enable',
				'operator' => '==',
				'value' => true,
			),
		),
	));

	// Base font size
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'typography_settings',
		'settings' => 'typography_font_size',
		'type' => 'select',
		'label' => esc_html__( 'Base Font Size', 'lore' ),
		'description' => esc_html__( 'Font size of basic content text. All other font sizes will be also calculated from this value. Default font size is 16px', 'lore' ),
		'choices' => array(
			'10' => '10px',
			'11' => '11px',
			'12' => '12px',
			'14' => '14px',
			'16' => '16px',
			'18' => '18px',
		),
		'default' => '16',
		'priority' => 40,
		'required' => array(
			array(
				'setting' => 'typography_gf_enable',
				'operator' => '==',
				'value' => true,
			),
		),
	));

	// Font subsets
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'typography_settings',
		'settings' => 'typography_subsets',
		'type' => 'multicheck',
		'label' => esc_html__( 'Font Subsets', 'lore' ),
		'description' => esc_html__( 'Only the Latin subset is loaded by default. If your site is in any other language than English, you may need to load an additional font subset', 'lore' ),
		'choices' => array(
			'latin-ext' => esc_html__( 'Latin Extended', 'lore' ),
			'greek' => esc_html__( 'Greek', 'lore' ),
			'greek-ext' => esc_html__( 'Greek Extended', 'lore' ),
			'vietnamese' => esc_html__( 'Vietnamese', 'lore' ),
			'cyrillic' => esc_html__( 'Cyrillic', 'lore' ),
			'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'lore' ),
		),
		'priority' => 50,
		'required' => array(
			array(
				'setting' => 'typography_gf_enable',
				'operator' => '==',
				'value' => true,
			),
		),
	));


/**
 * Social links settings
 */
Kirki::add_section( 'social_settings', array(
	'title' => esc_html__( 'Social Links', 'lore' ),
    'priority' => 1090,
));

	// List of social links
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'social_settings',
		'settings' => 'social_links',
		'type' => 'repeater',
		'label' => esc_html__( 'Social Links', 'lore' ),
		'row_label' => array(
			'value' => esc_html__( 'Social Link', 'lore' ),
		),
		'fields' => array(
			'link_title' => array(
				'type' => 'text',
				'label' => esc_html__( 'Title', 'lore' ),
				'description' => esc_html__( 'This text will be displayed when you hover over the icon and will also be used as a link label if you will not define Icon in the field below', 'lore' ),
			),
			'link_icon' => array(
				'type' => 'text',
				'label' => esc_html__( 'Icon', 'lore' ),
				'description' => esc_html__( 'For example "fa fa-twitter". Please refer to the documentation to learn more about icons', 'lore' ),
			),
			'link_url' => array(
				'type' => 'text',
				'label' => esc_html__( 'URL', 'lore' ),
				'description' => esc_html__( 'Full URL starting with http:// or https:// respectively. Icon will not be displayed without filling this field', 'lore' ),
			),
		),
		'default' => array(
			array(
				'link_title' => 'Twitter',
				'link_icon' => 'fa fa-twitter',
				'link_url' => '#',
			),
			array(
				'link_title' => 'Facebook',
				'link_icon' => 'fa fa-facebook',
				'link_url' => '#',
			),
			array(
				'link_title' => 'Behance',
				'link_icon' => 'fa fa-behance',
				'link_url' => '#',
			),
			array(
				'link_title' => 'Dribbble',
				'link_icon' => 'fa fa-dribbble',
				'link_url' => '',
			),
			array(
				'link_title' => 'GitHub',
				'link_icon' => 'fa fa-github',
				'link_url' => '',
			),
			array(
				'link_title' => 'Bitbucket',
				'link_icon' => 'fa fa-bitbucket',
				'link_url' => '',
			),
		),
		'priority' => 10,
	));

	// Link target
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'social_settings',
		'settings' => 'social_links_target',
		'type' => 'switch',
		'label' => esc_html__( 'Open Social Links in New Tab', 'lore' ),
		'default' => 1,
		'priority' => 20,
	));


/**
 * Misc settings
 */
Kirki::add_section( 'misc_settings', array(
	'title' => esc_html__( 'Misc Settings', 'lore' ),
    'priority' => 1100,
));

	// Error 404 page text
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'misc_settings',
		'settings' => 'page404_content',
		'type' => 'textarea',
		'label' => esc_html__( 'Page 404 Text', 'lore' ),
		'description' => esc_html__( 'This page is displayed whenever someone visits a page that is not available on your site', 'lore' ),
		'default'  => esc_html__( 'The page you are looking for is no longer available or has been moved', 'lore' ),
		'priority' => 10,
		'transport' => 'postMessage'
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'misc_settings',
		'settings'    => 'page404_content_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 15,
	));

	// Sidebar position on search results page
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'misc_settings',
		'settings' => 'search_results_sidebar_position',
		'type' => 'radio',
		'label' => esc_html__( 'Search Results Sidebar Position', 'lore' ),
		'description' => esc_html__( 'Position of the sidebar on Search Results page', 'lore' ),
		'choices' => array(
			'left' => esc_html__( 'Left', 'lore' ),
			'right' => esc_html__( 'Right', 'lore' ),
			'disable' => esc_html__( 'Disable Sidebar', 'lore' ),
		),
		'default' => 'disable',
		'priority' => 20,
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'misc_settings',
		'settings'    => 'custom_sidebars_count_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 25,
	));

	// Number of Custom Sidebars
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'misc_settings',
		'settings' => 'custom_sidebars_count',
		'type' => 'slider',
		'label' => esc_html__( 'Number of Custom Sidebars', 'lore' ),
		'description' => esc_html__( 'Custom Sidebar is a widgetized area, editable under Appearance / Widgets, which can be inserted into a page content via [lsvr_custom_sidebar sidebar="1"] shortcode ("sidebar" attribute specifies which Custom Sidebar should be inserted)', 'lore' ),
		'choices' => array(
			'min' => 1,
			'max' => 20,
			'step' => 1,
		),
		'default'  => 1,
		'priority' => 30,
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'misc_settings',
		'settings'    => 'contact_form_page_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 35,
	));

	/**
	 * Contact page
	 *
	 * Page which contains a Contact Form 7 form
	 */
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'misc_settings',
		'settings' => 'contact_form_page',
		'type' => 'dropdown-pages',
		'label' => esc_html__( 'Contact Form Page', 'lore' ),
		'description' => esc_html__( 'Select the page where you are using contact form (via Contact Form 7 plugin). All necessary CSS and JS files will be loaded only on this page (for better performance). If you are using contact form on more than one page, leave this field blank', 'lore' ),
		'priority' => 40,
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'misc_settings',
		'settings'    => 'misc_lightbox_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 45,
	));

	// Enable default lightbox
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'misc_settings',
		'settings' => 'misc_lightbox_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Use Default Lightbox', 'lore' ),
		'description' => esc_html__( 'To open an image in lightbox, give his parent link (A tag) class "lightbox". For example &lt;a href="big_image_url" class="lightbox"&gt;&lt;img src="image_url"&gt;&lt;/a&gt;. Disable if you want to use 3rd party solution for lightboxes', 'lore' ),
		'default' => 1,
		'priority' => 50,
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'misc_settings',
		'settings'    => 'misc_lightbox_enable_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 55,
	));

	// Load FontAwesome
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'misc_settings',
		'settings' => 'misc_fontawesome_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Load Bundled FontAwesome Icons', 'lore' ),
		'description' => esc_html__( 'This theme contains only a limited number of FontAwesome icons. You can download a 3rd party plugin from official WordPress plugin repository which contains full set. If you do so, use the following option to disable loading of bundled FontAwesome icons to save bandwith', 'lore' ),
		'default' => 1,
		'priority' => 60,
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'misc_settings',
		'settings'    => 'misc_fontawesome_enable_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 65,
	));

	// Enable fluid embed elements
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'misc_settings',
		'settings' => 'misc_fluid_embeds_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Responsive Embed Elements', 'lore' ),
		'description' => esc_html__( 'All &lt;embed&gt; elements in content area will become responsive. Disable if this feature collides with some 3rd party plugins', 'lore' ),
		'default' => 1,
		'priority' => 70,
	));

	// Enable fluid iframe elements
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'misc_settings',
		'settings' => 'misc_fluid_iframes_enable',
		'type' => 'switch',
		'label' => esc_html__( 'Responsive Iframe Elements', 'lore' ),
		'description' => esc_html__( 'All &lt;iframe&gt; elements in content area will become responsive. Disable if this feature collides with some 3rd party plugins', 'lore' ),
		'default' => 1,
		'priority' => 80,
	));

	// Fluidify iframes with specific SRC attributes
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'misc_settings',
		'settings' => 'misc_fluid_iframes_include',
		'type' => 'text',
		'label' => esc_html__( 'Iframe Elements Filter', 'lore' ),
		'description' => esc_html__( 'Apply responsive feature only on those iframes, whose "src" attribute contains one of these keywords (separated by comma). Leave blank to apply responsiveness to all iframe elements in main content area', 'lore' ),
		'default' => 'youtube,vimeo,soundcloud',
		'priority' => 90,
		'required' => array(
			array(
				'setting' => 'misc_fluid_iframes_enable',
				'operator' => '==',
				'value' => true,
			),
		),
	));

	// Separator
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section'     => 'misc_settings',
		'settings'    => 'misc_fluid_iframes_include_separator',
		'type'        => 'custom',
		'default'     => '<hr style="margin: 20px 0; border: 0; border-top: 1px solid #ccc;">',
		'priority'    => 95,
	));

	// Enable theme's custom WPML language switcher
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'misc_settings',
		'settings' => 'wpml_lang_switcher_enable',
		'type' => 'switch',
		'label' => esc_html__( 'WPML Language Switcher', 'lore' ),
		'description' => esc_html__( 'Show link to other language versions in header. WPML plugin have to be installed and configured for this feature to work', 'lore' ),
		'default' => 1,
		'priority' => 100,
	));


/**
 * Custom CSS settings
 */
Kirki::add_section( 'custom_css_settings', array(
	'title' => esc_html__( 'Custom CSS', 'lore' ),
    'priority' => 1200,
));

	// Custom CSS code
	Kirki::add_field( 'lsvr_lore_theme', array(
		'section' => 'custom_css_settings',
		'settings' => 'custom_css_code',
		'type' => 'code',
		'label' => esc_html__( 'CSS Code', 'lore' ),
		'description' => esc_html__( 'Use this field only for small or temporary CSS changes. Whenever possible, use style.css in Child Theme for adding your custom CSS', 'lore' ),
		'choices' => array(
			'language' => 'css',
			'theme'    => 'monokai',
			'height'   => 250,
		),
		'priority' => 10,
		'transport' => 'postMessage'
	));

} ?>