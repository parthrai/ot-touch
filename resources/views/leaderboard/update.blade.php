@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div
        class="
          col-xs-12
          col-sm-12
          col-md-12
          col-lg-12
        "
      >
        @include( 'comps.flash-messages' )
        <div class="panel panel-primary">
          <div class="panel-heading">Update Leaderboard</div>
          <div class="panel-body">
            @include( 'leaderboard/form' )
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
