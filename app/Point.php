<?php

namespace App;

use Kyslik\ColumnSortable\Sortable;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Point extends Model
{

  /****************************************************************************/

  use SoftDeletes;
  use Sortable;

  /****************************************************************************/

  protected $dates = [ "deleted_at" ];
  
  public $sortable = [
    'id',
    'team',
    'points',
    'audit',
    'source',
    'created_at',
    'updated_at'
  ];

  /****************************************************************************/

  public function latest ()
  {
    return $this->orderBy( 'updated_at', 'desc' );
  }

  /****************************************************************************/

  // TODO: This should be a relation:
  public static function audit ( $auditor_id )
  {

    $auditor = User::find( $auditor_id );

    if( $auditor == null )
    {
      return( "System" );
    }

    return( $auditor->name );

  }

  /****************************************************************************/

  public function reports ()
  {
    // TODO: Map out the report components here:
    //points by team
    $points_by_team = Point::all();
    //points by source
    // points by audit
    //top ten overall
    //top ten by teams
  }

  /****************************************************************************/

}
