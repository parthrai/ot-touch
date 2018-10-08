<?php

namespace Tests\Feature;

class HomePageTest extends DatabaseTestCase
{

  /****************************************************************************/

  /**
   * Test that home page is a 301 redirect.
   *
   * @return void
   */
  public function test_home_page_redirects ()
  {

    // TODO: this needs to eventually redirect to ot.com

    $response = $this->get( '/' );

    $response->assertStatus( 301 );

  }

  /****************************************************************************/

}
