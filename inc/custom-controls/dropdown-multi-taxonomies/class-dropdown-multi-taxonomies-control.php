<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

/**
 * Customize Control for Taxonomy Select
 */
class Theme_Customize_Control_Multiple_Select extends WP_Customize_Control 
{
	public $type = 'multiple-taxonomies';
	public $taxonomy = '';

	public function __construct( $manager, $id, $args = array() ) 
	{
		$travel_tour_taxonomy = 'category';
		if ( isset( $args['taxonomy'] ) ) 
		{
			$taxonomy_exist = taxonomy_exists( esc_attr( $args['taxonomy'] ) );
			if ( true === $taxonomy_exist ) 
			{
				$our_taxonomy = esc_attr( $args['taxonomy'] );
			}
		}
		$this->taxonomy = esc_attr( $travel_tour_taxonomy );
		parent::__construct( $manager, $id, $args );
	}

	public function render_content() 
	{
		$tax_args = array(
			'hierarchical'	=> 0,
			'taxonomy'		=> $this->taxonomy,
			'hide_empty'	=> false,
		);
		$all_taxonomies = get_categories( $tax_args );
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<select <?php echo $this->link(); ?> multiple="multiple" >
				<?php if ( ! empty( $all_taxonomies ) ): ?>
					<?php foreach ( $all_taxonomies as $key => $tax ): ?>
						<?php
                        $selected = ( in_array( $tax->slug, $this->value() ) ) ? selected( 1, 1, false ) : '';
                        echo '<option value="' . esc_attr( $tax->slug ) . '"' . $selected . '>' . $tax->name . '</option>';
						?>
					<?php endforeach ?>
				<?php endif ?>
			</select>
		</label>
		<?php
	}
}