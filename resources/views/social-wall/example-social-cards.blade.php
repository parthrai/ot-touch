@extends('layouts.social-wall')

@section('js-static')
@endsection

@section('content')

  <social-cards
    :max-items="30"
    :schedule-frequency-ms="3000"
  ></social-cards>

@endsection

@section('script')
@endsection
