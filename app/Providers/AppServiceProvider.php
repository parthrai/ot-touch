<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\ScoreboardMember;
use App\Observers\ScoreboardMemberObserver;

use App\SocialCardTweet;
use App\SocialCardPost;
use App\Observers\SocialCardObserver;

class AppServiceProvider extends ServiceProvider
{

  /****************************************************************************/

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot ()
  {

    /** BEGIN: Scoreboard Member Observers --------------------------------- **/
    ScoreboardMember::observe( ScoreboardMemberObserver::class );
    /** END: Scoreboard Member Observers ----------------------------------- **/

    /** BEGIN: Social Card Observers --------------------------------------- **/
    SocialCardTweet::observe( SocialCardObserver::class );
    SocialCardPost::observe( SocialCardObserver::class );
    /** END: Social Card Observers ----------------------------------------- **/

  }

  /****************************************************************************/

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register ()
  {
  }

  /****************************************************************************/

}
