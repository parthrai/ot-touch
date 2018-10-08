<form
  class="form-inline"
  enctype="multipart/form-data"
  method="POST"
  action="{{ route( 'twitter-hashtags.add' ) }}"
>

  {{ csrf_field() }}

  <!-- BEGIN: Hashtag ****************************************************** -->
  <div class="form-group{{ $errors->has('hashtag') ? ' has-error' : '' }}">
    <label
      for="hashtag"
      class="
        col-xs-3
        col-sm-3
        col-md-3
        col-lg-3
        control-label
      "
    >Hashtag</label>
    <div
      class="
        col-xs-3
        col-sm-3
        col-md-3
        col-lg-3
      "
    >
      <input
        class="form-control"
        id="hashtag"
        name="hashtag"
        type="text"
        required
        autofocus
      >
      @if( $errors->has( 'hashtag' ) )
        <span class="help-block">
          <strong>{{ $errors->first('hashtag') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Hashtag ******************************************************** -->

  <!-- BEGIN: Submit ******************************************************* -->
  <div class="form-group">
    <div
      class="
        col-xs-3
        col-sm=3
        col-md-3
        col-lg-3
      "
    >
      <button type="submit" class="btn btn-primary">
        Add Hashtag
      </button>
    </div>
  </div>
  <!-- END: Submit ********************************************************* -->

</form>
