<?php
/**
 * @group locator
 */
class CarbonBreadcrumbLocatorPostGetParentIdTest extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();

		$this->locator = $this->getMockForAbstractClass( 'Carbon_Breadcrumb_Locator_Post', array( 'post', 'post' ) );
		$this->parent = $this->factory->post->create();
		$this->child = $this->factory->post->create(array(
			'post_parent' => $this->parent
		));
		$this->subchild = $this->factory->post->create(array(
			'post_parent' => $this->child
		));
	}

	public function tearDown() {
		unset( $this->locator );
		unset( $this->parent );
		unset( $this->child );
		unset( $this->subchild );

		parent::tearDown();
	}

	/**
	 * @covers Carbon_Breadcrumb_Locator_Post::get_parent_id
	 */
	public function testWithParentPost() {
		$this->assertSame( 0, $this->locator->get_parent_id( $this->parent ) );
	}

	/**
	 * @covers Carbon_Breadcrumb_Locator_Post::get_parent_id
	 */
	public function testWithChildPost() {
		$this->assertSame( $this->parent, $this->locator->get_parent_id( $this->child ) );
	}

	/**
	 * @covers Carbon_Breadcrumb_Locator_Post::get_parent_id
	 */
	public function testWithSubChildPost() {
		$this->assertSame( $this->child, $this->locator->get_parent_id( $this->subchild ) );
	}

}