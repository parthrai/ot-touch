<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use App\ScoreboardMember;
use App\Events\ScoreboardRefresh;

class ScoreboardMemberObserver
{

  /****************************************************************************/

  /**
   * Listen to the ScoreboardMember created event and fire events.
   *
   * @param  \App\ScoreboardMember $member
   * @return void
   */
  public function created ( ScoreboardMember $member )
  {
    ScoreboardRefresh::dispatch();
  }

  /****************************************************************************/

}
