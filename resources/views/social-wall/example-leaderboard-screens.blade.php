@extends('layouts.social-wall')

@section('js-static')
@endsection

@section('content')

  <leaderboard-screen
    :screen-order="1"
    :schedule-frequency-ms="5000"
  ></leaderboard-screen>

@endsection

@section('script')
@endsection
