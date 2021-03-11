{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body"> 
    <div class="form-group"> <button class="btn purple btn-outline sbold" onclick="showProfileProjectModal();"> Add Project </button> </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption"> <i class=" icon-layers font-green"></i> <span class="caption-subject font-green bold uppercase">Projects</span> </div>
                </div>
                <div class="portlet-body">
                    <div class="mt-element-card mt-element-overlay">
                        <div class="row" id="projects_div"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-modal-lg" id="add_project_modal" tabindex="-1" role="dialog" aria-hidden="true"></div>
@push('css')
<style type="text/css">
    .datepicker>div {
        display: block;
    }
</style>
<link href="{{ asset('/') }}dropzone/dropzone.min.css" rel="stylesheet">
@endpush
@push('scripts') 
<script src="{{ asset('/') }}dropzone/dropzone.min.js"></script> 
<script type="text/javascript">
        function initdatepicker(){
        $(".datepicker").datepicker({
        autoclose: true,
                format:'yyyy-m-d'
        });
        }
        $(document).ready(function(){
        showProjects();
        initdatepicker();
        });
        function createDropZone(){
        var myDropzone = new Dropzone("div#dropzone", {
        url: "{{ route('upload.project.temp.image') }}",
                paramName: "image", // The name that will be used to transfer the file
                uploadMultiple: false,
                ignoreHiddenFiles: true,
                maxFilesize: <?php echo $upload_max_filesize; ?>, // MB
                acceptedFiles: 'image/*'
        });
        myDropzone.on("complete", function (file) {
        imageUploadedFlag = false;
        });
        }
        /**************************************************/
        function showProfileProjectModal(){
        $("#add_project_modal").modal();
        loadProfileProjectForm();
        }
        function loadProfileProjectForm(){
        $.ajax({
        type: "POST",
                url: "{{ route('get.profile.project.form', $user->id) }}",
                data: {"_token": "{{ csrf_token() }}"},
                datatype: 'json',
                success: function (json) {
                $("#add_project_modal").html(json.html);
                createDropZone();
                initdatepicker();
                }
        });
        }
        function submitProfileProjectForm() {
        var form = $('#add_edit_profile_project');
        $.ajax({
        url     : form.attr('action'),
                type    : form.attr('method'),
                data    : form.serialize(),
                dataType: 'json',
                success : function (json){
                $ ("#add_project_modal").html(json.html);
                showProjects();
                },
                error: function(json){
                if (json.status === 422) {
                var resJSON = json.responseJSON;
                $('.help-block').html('');
                $.each(resJSON.errors, function (key, value) {
                $('.' + key + '-error').html('<strong>' + value + '</strong>');
                $('#div_' + key).addClass('has-error');
                });
                } else {
                // Error
                // Incorrect credentials
                // alert('Incorrect credentials. Please try again.')
                }
                }
        });
        }
        /*****************************************/
        function showProfileProjectEditModal(project_id){
        $("#add_project_modal").modal();
        loadProfileProjectEditForm(project_id);
        }
        function loadProfileProjectEditForm(project_id){
        $.ajax({
        type: "POST",
                url: "{{ route('get.profile.project.edit.form', $user->id) }}",
                data: {"project_id": project_id, "_token": "{{ csrf_token() }}"},
                datatype: 'json',
                success: function (json) {
                $("#add_project_modal").html(json.html);
                createDropZone();
                initdatepicker();
                }
        });
        }
        /*****************************************/
        function showProjects()
        {
        $.post("{{ route('show.profile.projects', $user->id) }}", {user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                $('#projects_div').html(response);
                });
        }
        function delete_profile_project(id) {
        if (confirm('Are you sure! you want to delete?')) {
        $.post("{{ route('delete.profile.project') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                if (response == 'ok')
                {
                $('#project_' + id).remove();
                } else
                {
                alert('Request Failed!');
                }
                });
        }
        }
</script>
@endpush