<?php 

/**
 * Adds Foo_Widget widget.
 */
class Custom_WP_Nav_Menu_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'custom_wp_nav_menu_widget', // Base ID
			esc_html__( 'Custom nav menu widget', 'ablog-theme' ), // Name display on backend
			array( 'description' => esc_html__( 'Custom Nav Menu Widget', 'ablog-theme' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		//Get Menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		$menu_class = ! empty( $instance['menu_class'] ) ? $instance['menu_class'] : esc_html__( 'New menu_class', 'ablog-theme' );
		$menu_id = ! empty( $instance['menu_id'] ) ? $instance['menu_id'] : esc_html__( 'New menu_id', 'ablog-theme' );
		// $container_class = ! empty( $instance['container_class'] ) ? $instance['container_class'] : esc_html__( 'New container_class', 'ablog-theme' );

		if ( ! $nav_menu ) {
			return;
		}

		$default_title = __( 'Menu' );
		$title         = ! empty( $instance['title'] ) ? $instance['title'] : '';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		echo $args['before_widget'];
		 ?>
				<?php 
				wp_nav_menu( array(
					'menu'  => $nav_menu,
					'fallback' => '',
					'container'  => 'div',
					'menu_class'  => $menu_class,
					'menu_id'  => $menu_id
				) ); ?>

	<?php
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		global $wp_customize;
		
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'ablog-theme' );
		$menu_class = ! empty( $instance['menu_class'] ) ? $instance['menu_class'] : esc_html__( 'New menu_class', 'ablog-theme' );
		$menu_id = ! empty( $instance['menu_id'] ) ? $instance['menu_id'] : esc_html__( 'New menu_id', 'ablog-theme' );
		// $container_class = ! empty( $instance['container_class'] ) ? $instance['container_class'] : esc_html__( 'New container_class', 'ablog-theme' );
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';
		// Get menus.
		$menus = wp_get_nav_menus();
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'ablog-theme' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

			<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'menu_class' ) ); ?>"><?php esc_attr_e( 'menu_class:', 'ablog-theme' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'menu_class' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'menu_class' ) ); ?>" type="text" value="<?php echo esc_attr( $menu_class ); ?>">
		</p>

			<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'menu_id' ) ); ?>"><?php esc_attr_e( 'menu_id:', 'ablog-theme' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'menu_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'menu_id' ) ); ?>" type="text" value="<?php echo esc_attr( $menu_id ); ?>">
		</p>

		<!-- <p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'container_class' ) ); ?>"><?php esc_attr_e( 'container_class:', 'ablog-theme' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'container_class' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'container_class' ) ); ?>" type="text" value="<?php echo esc_attr( $container_class ); ?>">
		</p> -->
			<p>
				<label for="<?php echo $this->get_field_id( 'nav_menu' ); ?>"><?php _e( 'Select Menu:' ); ?></label>
				<select id="<?php echo $this->get_field_id( 'nav_menu' ); ?>" name="<?php echo $this->get_field_name( 'nav_menu' ); ?>">
					<option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
					<?php foreach ( $menus as $menu ) : ?>
						<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $nav_menu, $menu->term_id ); ?>>
							<?php echo esc_html( $menu->name ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		$instance['nav_menu']  = ( ! empty( $new_instance['nav_menu'] ) ) ? (int) $new_instance['nav_menu'] : '';
		$instance['menu_class'] = ( ! empty( $new_instance['menu_class'] ) ) ? sanitize_text_field( $new_instance['menu_class'] ) : '';
		$instance['menu_id'] = ( ! empty( $new_instance['menu_id'] ) ) ? sanitize_text_field( $new_instance['menu_id'] ) : '';
		// $instance['container_class'] = ( ! empty( $new_instance['container_class'] ) ) ? sanitize_text_field( $new_instance['container_class'] ) : '';
		return $instance;
	}

} // class Foo_Widget


 ?>