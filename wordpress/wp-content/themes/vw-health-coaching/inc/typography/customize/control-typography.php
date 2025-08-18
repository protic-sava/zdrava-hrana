<?php
/**
 * Typography control class.
 *
 * @since  1.0.0
 * @access public
 */

class VW_Health_Coaching_Control_Typography extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'typography';

	/**
	 * Array 
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $l10n = array();

	/**
	 * Set up our control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @param  string  $id
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $manager, $id, $args = array() ) {

		// Let the parent class do its thing.
		parent::__construct( $manager, $id, $args );

		// Make sure we have labels.
		$this->l10n = wp_parse_args(
			$this->l10n,
			array(
				'color'       => esc_html__( 'Font Color', 'vw-health-coaching' ),
				'family'      => esc_html__( 'Font Family', 'vw-health-coaching' ),
				'size'        => esc_html__( 'Font Size',   'vw-health-coaching' ),
				'weight'      => esc_html__( 'Font Weight', 'vw-health-coaching' ),
				'style'       => esc_html__( 'Font Style',  'vw-health-coaching' ),
				'line_height' => esc_html__( 'Line Height', 'vw-health-coaching' ),
				'letter_spacing' => esc_html__( 'Letter Spacing', 'vw-health-coaching' ),
			)
		);
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'vw-health-coaching-ctypo-customize-controls' );
		wp_enqueue_style(  'vw-health-coaching-ctypo-customize-controls' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// Loop through each of the settings and set up the data for it.
		foreach ( $this->settings as $setting_key => $setting_id ) {

			$this->json[ $setting_key ] = array(
				'link'  => $this->get_link( $setting_key ),
				'value' => $this->value( $setting_key ),
				'label' => isset( $this->l10n[ $setting_key ] ) ? $this->l10n[ $setting_key ] : ''
			);

			if ( 'family' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_families();

			elseif ( 'weight' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_weight_choices();

			elseif ( 'style' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_style_choices();
		}
	}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function content_template() { ?>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<ul>

		<# if ( data.family && data.family.choices ) { #>

			<li class="typography-font-family">

				<# if ( data.family.label ) { #>
					<span class="customize-control-title">{{ data.family.label }}</span>
				<# } #>

				<select {{{ data.family.link }}}>

					<# _.each( data.family.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.family.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.weight && data.weight.choices ) { #>

			<li class="typography-font-weight">

				<# if ( data.weight.label ) { #>
					<span class="customize-control-title">{{ data.weight.label }}</span>
				<# } #>

				<select {{{ data.weight.link }}}>

					<# _.each( data.weight.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.weight.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.style && data.style.choices ) { #>

			<li class="typography-font-style">

				<# if ( data.style.label ) { #>
					<span class="customize-control-title">{{ data.style.label }}</span>
				<# } #>

				<select {{{ data.style.link }}}>

					<# _.each( data.style.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.style.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.size ) { #>

			<li class="typography-font-size">

				<# if ( data.size.label ) { #>
					<span class="customize-control-title">{{ data.size.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.size.link }}} value="{{ data.size.value }}" />

			</li>
		<# } #>

		<# if ( data.line_height ) { #>

			<li class="typography-line-height">

				<# if ( data.line_height.label ) { #>
					<span class="customize-control-title">{{ data.line_height.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.line_height.link }}} value="{{ data.line_height.value }}" />

			</li>
		<# } #>

		<# if ( data.letter_spacing ) { #>

			<li class="typography-letter-spacing">

				<# if ( data.letter_spacing.label ) { #>
					<span class="customize-control-title">{{ data.letter_spacing.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.letter_spacing.link }}} value="{{ data.letter_spacing.value }}" />

			</li>
		<# } #>

		</ul>
	<?php }

	/**
	 * Returns the available fonts.  Fonts should have available weights, styles, and subsets.
	 *
	 * @todo Integrate with Google fonts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_fonts() { return array(); }

	/**
	 * Returns the available font families.
	 *
	 * @todo Pull families from `get_fonts()`.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	function get_font_families() {

		return array(
			'' => __( 'No Fonts', 'vw-health-coaching' ),
        'Abril Fatface' => __( 'Abril Fatface', 'vw-health-coaching' ),
        'Acme' => __( 'Acme', 'vw-health-coaching' ),
        'Anton' => __( 'Anton', 'vw-health-coaching' ),
        'Architects Daughter' => __( 'Architects Daughter', 'vw-health-coaching' ),
        'Arimo' => __( 'Arimo', 'vw-health-coaching' ),
        'Arsenal' => __( 'Arsenal', 'vw-health-coaching' ),
        'Arvo' => __( 'Arvo', 'vw-health-coaching' ),
        'Alegreya' => __( 'Alegreya', 'vw-health-coaching' ),
        'Alfa Slab One' => __( 'Alfa Slab One', 'vw-health-coaching' ),
        'Averia Serif Libre' => __( 'Averia Serif Libre', 'vw-health-coaching' ),
        'Bangers' => __( 'Bangers', 'vw-health-coaching' ),
        'Boogaloo' => __( 'Boogaloo', 'vw-health-coaching' ),
        'Bad Script' => __( 'Bad Script', 'vw-health-coaching' ),
        'Bitter' => __( 'Bitter', 'vw-health-coaching' ),
        'Bree Serif' => __( 'Bree Serif', 'vw-health-coaching' ),
        'BenchNine' => __( 'BenchNine', 'vw-health-coaching' ),
        'Cabin' => __( 'Cabin', 'vw-health-coaching' ),
        'Cardo' => __( 'Cardo', 'vw-health-coaching' ),
        'Courgette' => __( 'Courgette', 'vw-health-coaching' ),
        'Cherry Swash' => __( 'Cherry Swash', 'vw-health-coaching' ),
        'Cormorant Garamond' => __( 'Cormorant Garamond', 'vw-health-coaching' ),
        'Crimson Text' => __( 'Crimson Text', 'vw-health-coaching' ),
        'Cuprum' => __( 'Cuprum', 'vw-health-coaching' ),
        'Cookie' => __( 'Cookie', 'vw-health-coaching' ),
        'Chewy' => __( 'Chewy', 'vw-health-coaching' ),
        'Days One' => __( 'Days One', 'vw-health-coaching' ),
        'Dosis' => __( 'Dosis', 'vw-health-coaching' ),
        'Droid Sans' => __( 'Droid Sans', 'vw-health-coaching' ),
        'Economica' => __( 'Economica', 'vw-health-coaching' ),
        'Fredoka One' => __( 'Fredoka One', 'vw-health-coaching' ),
        'Fjalla One' => __( 'Fjalla One', 'vw-health-coaching' ),
        'Francois One' => __( 'Francois One', 'vw-health-coaching' ),
        'Frank Ruhl Libre' => __( 'Frank Ruhl Libre', 'vw-health-coaching' ),
        'Gloria Hallelujah' => __( 'Gloria Hallelujah', 'vw-health-coaching' ),
        'Great Vibes' => __( 'Great Vibes', 'vw-health-coaching' ),
        'Handlee' => __( 'Handlee', 'vw-health-coaching' ),
        'Hammersmith One' => __( 'Hammersmith One', 'vw-health-coaching' ),
        'Inconsolata' => __( 'Inconsolata', 'vw-health-coaching' ),
        'Indie Flower' => __( 'Indie Flower', 'vw-health-coaching' ),
        'IM Fell English SC' => __( 'IM Fell English SC', 'vw-health-coaching' ),
        'Julius Sans One' => __( 'Julius Sans One', 'vw-health-coaching' ),
        'Josefin Slab' => __( 'Josefin Slab', 'vw-health-coaching' ),
        'Josefin Sans' => __( 'Josefin Sans', 'vw-health-coaching' ),
        'Kanit' => __( 'Kanit', 'vw-health-coaching' ),
        'Lobster' => __( 'Lobster', 'vw-health-coaching' ),
        'Lato' => __( 'Lato', 'vw-health-coaching' ),
        'Lora' => __( 'Lora', 'vw-health-coaching' ),
        'Libre Baskerville' => __( 'Libre Baskerville', 'vw-health-coaching' ),
        'Lobster Two' => __( 'Lobster Two', 'vw-health-coaching' ),
        'Merriweather' => __( 'Merriweather', 'vw-health-coaching' ),
        'Monda' => __( 'Monda', 'vw-health-coaching' ),
        'Montserrat' => __( 'Montserrat', 'vw-health-coaching' ),
        'Muli' => __( 'Muli', 'vw-health-coaching' ),
        'Marck Script' => __( 'Marck Script', 'vw-health-coaching' ),
        'Noto Serif' => __( 'Noto Serif', 'vw-health-coaching' ),
        'Open Sans' => __( 'Open Sans', 'vw-health-coaching' ),
        'Overpass' => __( 'Overpass', 'vw-health-coaching' ),
        'Overpass Mono' => __( 'Overpass Mono', 'vw-health-coaching' ),
        'Oxygen' => __( 'Oxygen', 'vw-health-coaching' ),
        'Orbitron' => __( 'Orbitron', 'vw-health-coaching' ),
        'Patua One' => __( 'Patua One', 'vw-health-coaching' ),
        'Pacifico' => __( 'Pacifico', 'vw-health-coaching' ),
        'Padauk' => __( 'Padauk', 'vw-health-coaching' ),
        'Playball' => __( 'Playball', 'vw-health-coaching' ),
        'Playfair Display' => __( 'Playfair Display', 'vw-health-coaching' ),
        'PT Sans' => __( 'PT Sans', 'vw-health-coaching' ),
        'Philosopher' => __( 'Philosopher', 'vw-health-coaching' ),
        'Permanent Marker' => __( 'Permanent Marker', 'vw-health-coaching' ),
        'Poiret One' => __( 'Poiret One', 'vw-health-coaching' ),
        'Quicksand' => __( 'Quicksand', 'vw-health-coaching' ),
        'Quattrocento Sans' => __( 'Quattrocento Sans', 'vw-health-coaching' ),
        'Raleway' => __( 'Raleway', 'vw-health-coaching' ),
        'Rubik' => __( 'Rubik', 'vw-health-coaching' ),
        'Rokkitt' => __( 'Rokkitt', 'vw-health-coaching' ),
        'Russo One' => __( 'Russo One', 'vw-health-coaching' ),
        'Righteous' => __( 'Righteous', 'vw-health-coaching' ),
        'Slabo' => __( 'Slabo', 'vw-health-coaching' ),
        'Source Sans Pro' => __( 'Source Sans Pro', 'vw-health-coaching' ),
        'Shadows Into Light Two' => __( 'Shadows Into Light Two', 'vw-health-coaching'),
        'Shadows Into Light' => __( 'Shadows Into Light', 'vw-health-coaching' ),
        'Sacramento' => __( 'Sacramento', 'vw-health-coaching' ),
        'Shrikhand' => __( 'Shrikhand', 'vw-health-coaching' ),
        'Tangerine' => __( 'Tangerine', 'vw-health-coaching' ),
        'Ubuntu' => __( 'Ubuntu', 'vw-health-coaching' ),
        'VT323' => __( 'VT323', 'vw-health-coaching' ),
        'Varela Round' => __( 'Varela Round', 'vw-health-coaching' ),
        'Vampiro One' => __( 'Vampiro One', 'vw-health-coaching' ),
        'Vollkorn' => __( 'Vollkorn', 'vw-health-coaching' ),
        'Volkhov' => __( 'Volkhov', 'vw-health-coaching' ),
        'Yanone Kaffeesatz' => __( 'Yanone Kaffeesatz', 'vw-health-coaching' )
		);
	}

	/**
	 * Returns the available font weights.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_weight_choices() {

		return array(
			'' => esc_html__( 'No Fonts weight', 'vw-health-coaching' ),
			'100' => esc_html__( 'Thin',       'vw-health-coaching' ),
			'300' => esc_html__( 'Light',      'vw-health-coaching' ),
			'400' => esc_html__( 'Normal',     'vw-health-coaching' ),
			'500' => esc_html__( 'Medium',     'vw-health-coaching' ),
			'700' => esc_html__( 'Bold',       'vw-health-coaching' ),
			'900' => esc_html__( 'Ultra Bold', 'vw-health-coaching' ),
		);
	}

	/**
	 * Returns the available font styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_style_choices() {

		return array(
			'normal'  => esc_html__( 'Normal', 'vw-health-coaching' ),
			'italic'  => esc_html__( 'Italic', 'vw-health-coaching' ),
			'oblique' => esc_html__( 'Oblique', 'vw-health-coaching' )
		);
	}
}
