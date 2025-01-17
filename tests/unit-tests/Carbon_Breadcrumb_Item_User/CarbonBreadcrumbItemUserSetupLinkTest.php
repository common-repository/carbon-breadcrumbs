<?php
/**
 * @group item
 */
class CarbonBreadcrumbItemUserSetupLinkTest extends WP_UnitTestCase {

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
	 * @covers Carbon_Breadcrumb_Item_User::setup_link
	 */
	public function testItemLink() {
		$this->assertSame( null, $this->item->get_link() );

		$this->item->setup_link();

		$this->assertSame( get_author_posts_url( $this->user ), $this->item->get_link() );
	}

}