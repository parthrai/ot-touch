<form
  class="form-horizontal"
  enctype="multipart/form-data"
  method="POST"
  action=""
>

  {{ csrf_field() }}

  <!-- BEGIN: Description ************************************************** -->
  <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    <label for="description" class="col-md-4 control-label">Description</label>
    <div class="col-md-6">
      <textarea
        id="description"
        class="form-control"
        name="description"
        required
        autofocus
      >@isset( $leaderboard->description ){{ $leaderboard->description }}@endisset</textarea>
      @if( $errors->has( 'description' ) )
        <span class="help-block">
          <strong>{{ $errors->first('description') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Description **************************************************** -->

  <!-- BEGIN: Images ******************************************************* -->
  @foreach( \App\Leaderboard::$image_sizes as $image_size )
    <div class="form-group{{ $errors->has( $image_size ) ? ' has-error' : '' }}">
      <label for="image" class="col-md-4 control-label">Image {{ strtoupper( substr( $image_size , -2, 2 ) ) }}</label>
      <div class="col-md-6">
        <input
          type="file"
          id="{{ $image_size }}"
          name="{{ $image_size }}"
          {{ $image_size == \App\Leaderboard::$image_sizes[0] ? 'required' : '' }}
        >
        @if( $errors->has( $image_size ) )
          <span class="help-block">
            <strong>{{ $errors->first( $image_size ) }}</strong>
          </span>
        @endif
        @isset( $leaderboard[$image_size] )
          <img
            src="{{ Storage::url( $leaderboard[$image_size] ) }}"
            style="width:100px;"
          >
        @endisset
      </div>
    </div>
  @endforeach
  <!-- END: Image ********************************************************** -->

  <!-- BEGIN: Order ******************************************************** -->
  <div class="form-group{{ $errors->has('orderis') ? ' has-error' : '' }}">
    <label for="orderis" class="col-md-4 control-label">Order</label>
    <div class="col-md-6">
      <select
        class="form-control"
        id="orderis"
        name="orderis"
        required="required"
      >
        @foreach( range( 1, 32 ) as $new_order )
          @if( isset( $leaderboard ) && ( $leaderboard->orderis == $new_order ) )
            <option
              value="{{ $new_order }}"
              selected="selected"
            >{{ $new_order }}</option>
          @else
            <option
              value="{{ $new_order }}"
            >{{ $new_order }}</option>
          @endif
        @endforeach
      </select>
      @if( $errors->has( 'orderis' ) )
        <span class="help-block">
          <strong>{{ $errors->first( 'orderis' ) }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Order ********************************************************** -->

  <!-- BEGIN: Submit ******************************************************* -->
  <div class="form-group">
    <div
      class="
        col-xs-2
        col-sm-2
        col-md-2
        col-lg-2
        col-xs-offset-4
        col-sm-offset-4
        col-md-offset-4
        col-lg-offset-4
      "
    >
      <button type="submit" class="btn btn-primary">
        Submit
      </button>
    </div>
    <div
      class="
        col-xs-2
        col-sm-2
        col-md-2
        col-lg-2
      "
    >
      <a
        class="btn btn-danger"
        href="/leaderboard"
      >Cancel</a>
    </div>
  </div>
  <!-- END: Submit ********************************************************* -->

</form>
