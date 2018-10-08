@extends('layouts.social-wall')

@section('js-static')
@endsection

@section('content')

  <div
    class="carousel slide"
    data-ride="carousel"
    data-interval="2000"
    data-pause="false"
    data-wrap="true"
    data-keyboard="false"
  >
    <div
      class="carousel-inner"
      role="listbox"
    >

      @if( array_key_exists( 'countdown', $screen_settings ) && $screen_settings['countdown'] )
        <div class="item active">
          <final-countdown></final-countdown>
        </div>
      @endif

      @if( array_key_exists( 'splash_screen', $screen_settings ) && $screen_settings['splash_screen'] )
        <div class="item active">
          <logo-screen
            logo-url="/images/opentext-logos/OpenText-Logo-2017.png"
          ></logo-screen>
        </div>
      @endif

      @if( array_key_exists( 'team_ranking', $screen_settings ) && $screen_settings['team_ranking'] )
        <div class="item">
          <scoreboard-teams
            :schedule-frequency-ms="5000"
          ></scoreboard-teams>
        </div>
      @endif

      @if( array_key_exists( 'individual_ranking', $screen_settings ) && $screen_settings['individual_ranking'] )
        @foreach( $team_sets[0] as $team_name => $team_details )

          @if( array_key_exists( strtolower( $team_name ) . '_ranking', $screen_settings ) && ( $screen_settings[ strtolower( $team_name ) . '_ranking' ] == true ) )
            <div class="item">
              <scoreboard-team-members
                team-name="{{ $team_name }}"
                team-hashtag="{{ $team_details['team_hashtag'] }}"
                team-background-color="{{ $team_details['team_background_color'] }}"
                team-text-color="{{ $team_details['team_text_color'] }}"
                :schedule-frequency-ms="5000"
              ></scoreboard-team-members>
            </div>
          @endif

        @endforeach
      @endif

      @if( array_key_exists( 'tweets_wall', $screen_settings ) && $screen_settings['tweets_wall'] )
        <div class="item">
          <social-cards
            :max-items="{{ getenv( 'SOCIALCARDS_MAX_ITEMS' ) }}"
            :schedule-frequency-ms="5000"
          ></social-cards>
        </div>
      @endif

      @if( array_key_exists( 'individual_ranking', $screen_settings ) && $screen_settings['individual_ranking'] )
        @foreach( $team_sets[1] as $team_name => $team_details )

          @if( array_key_exists( strtolower( $team_name ) . '_ranking', $screen_settings ) && ( $screen_settings[ strtolower( $team_name ) . '_ranking' ] == true ) )
            <div class="item">
              <scoreboard-team-members
                team-name="{{ $team_name }}"
                team-hashtag="{{ $team_details['team_hashtag'] }}"
                team-background-color="{{ $team_details['team_background_color'] }}"
                team-text-color="{{ $team_details['team_text_color'] }}"
                :schedule-frequency-ms="5000"
              ></scoreboard-team-members>
            </div>
          @endif
          
        @endforeach
      @endif

      @if( array_key_exists( 'leaderboards', $screen_settings ) && $screen_settings['leaderboards'] )
        @foreach( \App\Leaderboard::GetLeaderboardOrders() as $order )
          <div class="item">
            <leaderboard-screen
              :screen-order="{{ $order }}"
              :schedule-frequency-ms="10000"
            ></leaderboard-screen>
          </div>
        @endforeach
      @else
        <!-- NO LEADERBOARDS FOUND -->
      @endif

    </div>
  </div>

@endsection

@section('script')
@endsection
