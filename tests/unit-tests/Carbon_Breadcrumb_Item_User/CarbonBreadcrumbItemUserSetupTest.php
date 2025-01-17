<?php
/**
 * @group item
 */
class CarbonBreadcrumbItemUserSetupTest extends WP_UnitTestCase {

	public $default_mock_title = 'foobar';
	public $default_mock_link = 'http://example.com/';

	public function mockSetupTitle() {
		$this->item->mock_title = $this->default_mock_title;
	}

	public function mockSetupLink() {
		$this->item->mock_link = $this->default_mock_link;
	}

	public function setUp() {
		$this->item = $this->getMock('Carbon_Breadcrumb_Item_User', array('setup_title', 'setup_link', 'get_id'));
	}

	public function tearDown() {
		unset( $this->item );
	}

	/**
	 * @covers Carbon_Breadcrumb_Item_User::setup
	 * @expectedException Carbon_Breadcrumb_Exception
	 * @expectedExceptionMessage The author breadcrumb items must have author ID specified.
	 */
	public function testSetupWithoutId() {
		$this->item->setup();
	}

	/**
	 * @covers Carbon_Breadcrumb_Item_User::setup
	 */
	public function testSetupWithId() {
		$this->item->expects( $this->any() )
			->method( 'get_id' )
			->will( $this->returnValue( 123 ) );

		$this->item->expects( $this->any() )
			->method( 'setup_title' )
			->will( $this->returnCallback( array( $this, 'mockSetupTitle' ) ) );

		$this->item->expects( $this->any() )
			->method( 'setup_link' )
			->will( $this->returnCallback( array( $this, 'mockSetupLink' ) ) );

		$this->item->setup();

		$this->assertSame( $this->default_mock_title, $this->item->mock_title );
		$this->assertSame( $this->default_mock_link, $this->item->mock_link );
	}

}