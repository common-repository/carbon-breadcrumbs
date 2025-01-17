<?php
/**
 * @group item
 */
class CarbonBreadcrumbItemUserSetupTitleTest extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		$this->item = $this->getMockForAbstractClass('Carbon_Breadcrumb_Item_User', array(), '', false);
		$this->user = $this->factory->user->create();
		$this->item->set_id( $this->user );
	}

	public function tearDown() {
		unset( $this->item );
		unset( $this->user );

		parent::tearDown();
	}

	/**
	 * @covers Carbon_Breadcrumb_Item_User::setup_title
	 */
	public function testItemTitle() {
		$this->assertSame( null, $this->item->get_title() );

		$this->item->setup_title();

		$title = apply_filters( 'the_title', get_the_author_meta( 'display_name', $this->user ) );
		$this->assertSame( $title, $this->item->get_title() );
	}

}