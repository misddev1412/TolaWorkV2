<div class="modal-dialog modal-lg">
    <div class="modal-content">
    <form class="form" id="add_edit_profile_cv" method="POST" action="{{ route('store.front.profile.cv', [$user->id]) }}">{{csrf_field()}}
    <input type="hidden" name="id" id="id" value="0"/>
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">{{__('Add CV')}}</h4>
      </div>
      @include('user.forms.cv.cv_form')
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="submitProfileCvForm();">{{__('Add CV')}} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
      </div>
      </form>
    </div>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog -->