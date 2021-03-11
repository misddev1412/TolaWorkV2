  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form class="form" id="add_edit_profile_cv" method="PUT" action="{{ route('update.front.profile.cv', [$profileCv->id, $user->id]) }}">
    {{csrf_field()}}
    <input type="hidden" name="id" id="id" value="{{$profileCv->id}}"/>
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{__('Edit CV')}}</h4>
      </div>
      @include('user.forms.cv.cv_form')
      <div class="modal-footer">
      <button type="button" class="btn btn-large btn-primary" onClick="submitProfileCvForm();">{{__('Update CV')}} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
      </div>
      </form>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog -->