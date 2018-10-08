<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScreenSetting extends Model
{

  /****************************************************************************/

  protected $table = 'screen_settings';

  public $timestamps = false;

  protected $casts = [
    'status' => 'boolean'
  ];

  /****************************************************************************/

}
