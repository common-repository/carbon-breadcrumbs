<?php
/**
 * Abstract breadcrumb item locator class.
 *
 * Used as a base for all breadcrumb locator types.
 */
abstract class Carbon_Breadcrumb_Locator extends Carbon_Breadcrumb_Factory {

	/**
	 * Breadcrumb item locator type.
	 *
	 * @access protected
	 * @var string
	 */
	protected $type = '';

	/**
	 * Breadcrumb item locator subtype.
	 *
	 * @access protected
	 * @var string
	 */
	protected $subtype = '';

	/**
	 * Build a new breadcrumb item locator of the selected type.
	 *
	 * @static
	 * @access public
	 *
	 * @param string $type Type of the breadcrumb item locator.
	 * @param string $subtype Subtype of the breadcrumb item locator.
	 * @return Carbon_Breadcrumb_Locator $locator The new breadcrumb item locator.
	 */
	public static function factory( $type, $subtype = '' ) {
		$class = self::verify_class_name( __CLASS__ . '_' . $type, 'Unexisting breadcrumb locator type: "' . $type . '".' );
		$locator = new $class( $type, $subtype );

		return $locator;
	}

	/**
	 * Constructor.
	 *
	 * Creates and configures a new breadcrumb item locator with the provided settings.
	 *
	 * @access public
	 *
	 * @param string $type Type of the breadcrumb item locator.
	 * @param string $subtype Subtype of the breadcrumb item locator.
	 */
	public function __construct( $type, $subtype ) {
		$this->set_type( $type );
		$this->set_subtype( $subtype );
	}

	/**
	 * Generate a set of breadcrumb items that found by the current type and the provided subtypes.
	 *
	 * @access public
	 *
	 * @param array $subtypes The subtypes to generate items for.
	 * @return array $items The items, generated by this locator.
	 */
	public function generate_items_for_subtypes( $subtypes ) {
		$all_items = array();

		foreach ( $subtypes as $subtype ) {
			$locator = Carbon_Breadcrumb_Locator::factory( $this->get_type(), $subtype );
			if ( $locator->is_included() ) {
				$items = $locator->get_items();
				$all_items = array_merge( $all_items, $items );
			}
		}

		return $all_items;
	}

	/**
	 * Retrieve the type of this locator.
	 *
	 * @access public
	 *
	 * @return string $type The type of this locator.
	 */
	public function get_type() {
		return $this->type;
	}

	/**
	 * Modify the type of this locator.
	 *
	 * @access public
	 *
	 * @param string $type The new locator type.
	 */
	public function set_type( $type ) {
		$this->type = $type;
	}

	/**
	 * Retrieve the subtype of this locator.
	 *
	 * @access public
	 *
	 * @return string $subtype The subtype of this locator.
	 */
	public function get_subtype() {
		return $this->subtype;
	}

	/**
	 * Modify the subtype of this locator.
	 *
	 * @access public
	 *
	 * @param string $subtype The new locator subtype.
	 */
	public function set_subtype( $subtype ) {
		$this->subtype = $subtype;
	}

	/**
	 * Whether this the items of this locator should be included in the trail.
	 *
	 * @abstract
	 * @access public
	 */
	abstract public function is_included();

	/**
	 * Get the breadcrumb items, found by this locator.
	 *
	 * @abstract
	 * @access public
	 *
	 * @param int $priority The priority of the located items.
	 * @param int $id The ID of the item to get items for. Optional.
	 */
	abstract public function get_items( $priority = 1000, $id = 0 );

	/**
	 * Generate a set of breadcrumb items that found by this locator type and any subtype.
	 *
	 * @abstract
	 * @access public
	 */
	abstract public function generate_items();

}