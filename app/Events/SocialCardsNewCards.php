<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\SocialCardHashtag;
use App\SocialCardHashtagLookup;
use App\SocialCardLookup;

class SocialCardsNewCards implements ShouldBroadcast
{

  /****************************************************************************/

  use Dispatchable;
  use InteractsWithSockets;
  use SerializesModels;

  /****************************************************************************/

  public $cards = null;

  /****************************************************************************/

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct ( Array $cards )
  {
    $this->cards = $cards;
  }

  /****************************************************************************/

  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
  public function broadcastOn ()
  {
    return( new Channel( 'socialcards' ) );
    //return new PrivateChannel( 'socialcards' );
  }

  /****************************************************************************/

}
