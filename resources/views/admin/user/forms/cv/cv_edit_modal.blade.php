<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form class="form" id="add_edit_profile_cv" method="PUT" action="{{ route('update.profile.cv', [$profileCv->id, $user->id]) }}">
            {{csrf_field()}}
            <input type="hidden" name="id" id="id" value="{{$profileCv->id}}"/>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Cv</h4>
            </div>
            @include('admin.user.forms.cv.cv_form')
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-large btn-primary" onClick="submitProfileCvForm();">Update Cv <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
            </div>
        </form>
    </div>
    <!-- /.modal-content --> 
</div>
<!-- /.modal-dialog -->