<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatabaseTestCase extends TestCase
{

  /****************************************************************************/

  use DatabaseTransactions;

  /****************************************************************************/

  protected $connectionsToTransact = [
    'mysql',
    'mysql_travis'
  ];

  /****************************************************************************/

}
