<?php
/**
 * @group item
 */
class CarbonBreadcrumbItemPostSetupTitleTest extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		$this->item = $this->getMockForAbstractClass('Carbon_Breadcrumb_Item_Post', array(), '', false);
		$this->post = $this->factory->post->create();
		$this->item->set_id( $this->post );
	}

	public function tearDown() {
		unset( $this->item );
		unset( $this->post );

		parent::tearDown();
	}

	/**
	 * @covers Carbon_Breadcrumb_Item_Post::setup_title
	 */
	public function testItemTitle() {
		$this->assertSame( null, $this->item->get_title() );

		$this->item->setup_title();

		$title = apply_filters( 'the_title', get_post_field( 'post_title', $this->post ) );
		$this->assertSame( $title, $this->item->get_title() );
	}

}