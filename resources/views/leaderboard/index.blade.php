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
          <div class="panel-heading">Main Screen Leaderboards</div>
          <div class="panel-body">

            <p><a class="btn btn-primary" href="{{ route('leaderboard.create') }}">Add Leaderboard</a></p>

            <table class="table table-condensed table-striped table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Description</th>
                  @foreach( \App\Leaderboard::$image_size_codes as $image_size )
                    <th>Image: {{ strtoupper( $image_size ) }}</th>
                  @endforeach
                  <th>Created</th>
                  <th>Order</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                @foreach( $leaderboards as $leaderboard )
                  <tr>
                    <td>{{ $leaderboard->id }}</td>
                    <td>{{ $leaderboard->description }}</td>
                    @foreach( \App\Leaderboard::$image_sizes as $image_size )
                      <td>
                        <img
                          src="{{ Storage::url( $leaderboard[$image_size] ) }}"
                          style="width:100px;"
                        >
                      </td>
                    @endforeach
                    <td>{{ $leaderboard->created_at }}</td>
                    <td>
                      <a
                        class="btn btn-default"
                        href="/leaderboard/bump-order-down/{{ $leaderboard->id }}"
                      >-</a>
                      &nbsp;
                      {{ $leaderboard->orderis }}
                      &nbsp;
                      <a
                        class="btn btn-default"
                        href="/leaderboard/bump-order-up/{{ $leaderboard->id }}"
                      >+</a>
                    </td>
                    <td>
                      <a
                        class="btn btn-primary"
                        href="/leaderboard/edit/{{ $leaderboard->id }}"
                      >Edit</a>
                    </td>
                    <td>
                      <a
                        class="btn btn-danger"
                        href="/leaderboard/delete/{{ $leaderboard->id }}"
                      >Delete</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </div>

      </div>
    </div>
  </div>

@endsection
