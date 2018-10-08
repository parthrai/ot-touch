<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

use App\Fetchers\SocialCardsTweetsFetch;

class SocialCardsTweetsFetchNew extends Command
{

  /****************************************************************************/

  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'ot-socialcards:fetch-new-tweets';

  /****************************************************************************/

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Fetch new social cards from Twitter.';

  /****************************************************************************/

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct ()
  {
    parent::__construct ();
  }

  /****************************************************************************/

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle ()
  {

    $fetcher = new SocialCardsTweetsFetch( true );
    $results = array();
    $dirty   = false;

    array_push( $results, $fetcher->FetchTweets() );

    foreach( $results as $result )
    {
      if( $result == true )
      {
        $dirty = true;
      }
    }

    if( $dirty )
    {
      Cache::tags( [ 'SocialCards' ] )->flush();
    }

  }

  /****************************************************************************/

}
