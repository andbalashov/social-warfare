<?php

/**
 * SWP_Ooptions_Page: Manages the values used to generate the options page.
 *
 * This class is used to create and control the fields of input on the Social
 * Warfare options page. It will will by populated with SWP_Options_Page_Tab
 * objects, which in turn will be populated with SWP_Options_Page_Section objects,
 * which in turn will be populated with SWP_Option objects.
 *
 * SWP_Options_Page_HTML will then register and output the HTML for the actual
 * options page. This is simply used to create a global object containing values
 * that both core and all addons can then add to and manipulate as needed.
 *
 * @since  2.4.0   | Created | 02 MAR 2017
 * @access public
 *
 */
class SWP_Options_Page {


	/**
	 * The Options Page Tabs
	 *
	 * This property will contain all of the tabs as tab objects.
	 *
	 */
	public $tabs;

	public function __construct() {

		/**
		 * Create the Display Tab.
		 *
		 * This tab will contain all of the sections and options needed to control the
		 * basic "display" features of the plugin.
		 *
		 */
        $this->tabs = new stdClass();
		$this->tabs->display = new SWP_Options_Page_Tab();
		$this->tabs->display->set_priority( 10 );
		$this->tabs->display->set_name( 'Display' );

		/**
		 * Create the Share Counts section of the display tab.
		 *
		 */
		$this->tabs->display->sections->share_counts = new SWP_Options_Page_Section();
	    $this->tabs->display->sections->share_counts->set_priority( 20 );
		$this->tabs->display->sections->share_counts->set_title( 'Share Counts' , 'http://warfareplugins.com/the-knowledge-base-article-for-this-section-of-options' );
		$this->tabs->display->sections->share_counts->set_description( __( 'Use the toggles below to determine how to display your social proof.' , 'social-warfare' ) );
		$_options = $this->tabs->display->sections->share_counts->options;

	   $this->tabs->display->sections->test_section = new SWP_Options_Page_Section();
	   $this->tabs->display->sections->test_section->set_priority( 30 );

		// Display share counts on each button?
		$_options->network_count = new SWP_Option_Checkbox();
		$_options->network_count->set_name( __( 'Button Counts', 'social-warfare' ) )->set_priority(10)->set_size('two-thirds')->set_default(true);

		// Display the total share count?
		$_options->total_count = new SWP_Option_Checkbox();
		$_options->total_count->set_name( __( 'Total Counts ' , 'social-warfare') )->set_priority(20)->set_size('two-thirds')->set_default(true);


		/**
		 * Create the Styles Tab.
		 *
		 * This tab will contain all of the sections and options needed to control the
		 * basic "styles" features of the plugin.
		 *
		 */
 		$this->tabs->styles = new SWP_Options_Page_Tab();
 		$this->tabs->styles->set_priority( 20 );
 		$this->tabs->styles->set_name( 'Styles' );


		/**
		 * Create the Social Identity Tab.
		 *
		 * This tab will contain all of the sections and options needed to control the
		 * basic "social identity" features of the plugin.
		 *
		 */
		$this->tabs->social_identity = new SWP_Options_Page_Tab();
		$this->tabs->social_identity->set_priority( 30 );
		$this->tabs->social_identity->set_name( 'Social Identity' );


		/**
		 * Create the Advanced Tab.
		 *
		 * This tab will contain all of the sections and options needed to control the
		 * basic "advanced" features of the plugin.
		 *
		 */
 		$this->tabs->advanced = new SWP_Options_Page_Tab();
 		$this->tabs->advanced->set_priority( 40 );
 		$this->tabs->advanced->set_name( 'Advanced' );

		// TODO: This needs moved to a different tab and section.
		// $_options->frame_buster = new SWP_Option_Checkbox();
		// $_options->frame_buster->set_name( __( 'Frame Buster', 'social-warfare' ) )->set_priority(10)->set_size('two-thirds-advanced')->set_default(true);

		$this->sort_by_priority();

	}


	/**
	 * A method to sort tabs, section, and option according to their priority.
	 *
	 * This method will loop through all the tab objects, section objects, and
	 * option objects and sort them according to their priority.
	 *
	 * @since 2.4.0 | 02 MAR 2018 | Created
	 * @param null
	 * @return null
	 */
	public function sort_by_priority() {

		// Sort the tabs
		$tabs = new ArrayObject( $this->tabs );
        $tabs->uasort( array( $this , 'compare' ) );

		// Loop through the tabs and sort the sections
		foreach($this->tabs as $tab) {

			$sections = new ArrayObject( $tab->sections );
        	$sections->uasort( array( $this , 'compare' ) );

			// Loop through the sections and sort the options
			foreach($sections as $section){

				$options = new ArrayObject( $section->options );
				$options->uasort( array( $this , 'compare' ) );

			}

		}

	}

}
