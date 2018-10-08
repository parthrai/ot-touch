@extends('layouts.app')

@section('content')
  <div class="container">

    <div class="row">
      <div
        class="
          col-xs-12
          col-sm-12
          col-md-6
          col-lg-6
        "
      >
        @include( 'comps.flash-messages' )
      </div>
    </div>

    <div class="row">
      <div
        class="
          col-xs-12
          col-sm-12
          col-md-6
          col-lg-6
        "
      >

        <!-- BEGIN: LEFT COLUMN ******************************************** -->

        @if( Auth::user()->is_admin )
          <div class="panel panel-primary">
            <div class="panel-heading">Refresh Screens</div>
              <div class="panel-body">
                {!! Form::open(['method' => 'POST','route' => ['socialwall.refresh'],'style'=>'display:inline']) !!}
                {!! Form::submit('Refresh Main + Mobile leaderboards', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
                {!! Form::open(['method' => 'POST','route' => ['socialwall.mrefresh'],'style'=>'display:inline']) !!}
                {!! Form::submit('Refresh Touch Screens', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
              </div>
              <div class="panel-body">
            </div>
          </div>
        @endif
          
        @if( Auth::user()->is_admin )
          <div class="panel panel-primary">
            <div class="panel-heading">Open Leaderboards</div>
            <div class="panel-body">
              <ul class="list-unstyled list-inline">
                <li><a class="btn btn-success" href="{{ route( 'social-wall' ) }}" target="_blank">Open Main Leaderboard</a></li>
                <li><a class="btn btn-default" href="/socialwall/mobile" target="_blank">Open Mobile Leaderboard</a></li>
                <li><a class="btn btn-default" href="/socialwall/debug" target="_blank">Open Leaderboard in debug mode</a></li>
              </ul>
            </div>
          </div>
        @endif

        @if( Auth::user()->is_admin )
          <div class="panel panel-primary">
            <div class="panel-heading">Social Media</div>
            <div class="panel-body">
              <ul class="list-unstyled list-inline">
                <li><a class="btn btn-default" href="{{ route('appworks-posts.dashboard') }}">Posts Dashboard</a></li>
                <li><a class="btn btn-warning" href="{{ route('tweets.dashboard') }}">Tweets Dashboard</a></li>
              </ul>
            </div>
          </div>
        @endif

        <div class="panel panel-primary">
          <div class="panel-heading">Points</div>
          <div class="panel-body">
            <ul class="list-unstyled list-inline">
              @if( Auth::user()->is_admin )
                <a class="btn btn-default" href="{{ route('points') }}">Points Dashboard</a></li>
              @endif
              <a class="btn btn-default" href="{{ route('pointsapp.index') }}">Points Application</a></li>
            </ul>
          </div>
        </div>

        @if( Auth::user()->is_admin )
          <div class="panel panel-primary">
            <div class="panel-heading">Users</div>
            <div class="panel-body">
              <ul class="list-unstyled list-inline">
                <li><a class="btn btn-default" href="{{ route('user') }}">Users Dashboard</a></li>
                <li><a class="btn btn-default" href="{{ route('newuser') }}">Create New User</a></li>
              </ul>
            </div>
          </div>
        @endif

        <!-- END: LEFT COLUMN ********************************************** -->
      
      </div>
      <div
        class="
          col-xs-12
          col-sm-12
          col-md-6
          col-lg-6
        "
      >

        <!-- BEGIN: RIGHT COLUMN ******************************************* -->

        <div class="panel panel-primary">
          <div class="panel-heading">Screen Settings</div>
          <div class="panel-body">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Screen</th>
                  <th>Status</th>
                  <th>Toggle</th>
                </tr>
              </thead>
              <tbody>
                @foreach( $settings as $setting )
                  <tr>
                    <td>{{ $setting->screen }}</td>

                    <td>
                      @if( $setting->status )
                        <span class="text-success"><strong>ENABLED</strong></span>
                      @else
                      <span class="text-danger"><strong>DISABLED</strong></span>
                      @endif
                    </td>

                    <td>
                      @if( $setting->status )
                        <a href="/socialwall/disable/{{ $setting->id }}" class="btn btn-danger">Disable screen</a>
                      @else
                        <a href="/socialwall/enable/{{$setting->id}}" class="btn btn-success">Enable screen</a>
                      @endif
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <!-- END: RIGHT COLUMN ********************************************* -->

      </div>
    </div>
  </div>
@endsection
