@extends('admin.layouts.admin_layout')
@section('content')
<style type="text/css">
    .table td, .table th {
        font-size: 12px;
        line-height: 2.42857 !important;
    }	
</style>
<div class="page-content-wrapper"> 
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content"> 
        <!-- BEGIN PAGE HEADER--> 
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="{{ route('admin.home') }}">Home</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Our Video</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">Manage Video languages <small>Video languages</small> </h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-dark"></i> <span class="caption-subject font-dark sbold uppercase">Video languages</span> </div>
                        <div class="actions"> <a href="{{ route('create.video') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Add New Video language</a> </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="video-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="videoDatatableAjax">
                                    <thead>                                        
                                        <tr role="row" class="filter">
                                            <td>{!! Form::select('lang', ['' => 'Select Language']+$languages, null, array('id'=>'lang', 'class'=>'form-control')) !!}</td><td><input type="text" class="form-control" name="video_title" id="video_title" autocomplete="off" placeholder="Video Title"></td><td><select name="is_active" id="is_active"  class="form-control"><option value="-1">Is Active?</option><option value="1" selected="selected">Active</option><option value="0">In Active</option></select></td>
                                        </tr>
                                        <tr role="row" class="heading">
                                            <th>Language</th><th>Video Title</th><th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY --> 
</div>
@endsection
@push('scripts') 
<script>
    $(function () {
        var oTable = $('#videoDatatableAjax').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            searching: false,
            /*		
             "order": [[1, "asc"]],            
             paging: true,
             info: true,
             */
            ajax: {
                url: '{!! route('fetch.data.videos') !!}',
                data: function (d) {
                    d.lang = $('#lang').val();
                    d.video_title = $('#video_title').val();
                    d.is_active = $('#is_active').val();
                }
            }, columns: [
                {data: 'lang', name: 'lang'}, {data: 'video_title', name: 'video_title'}, {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $('#video-search-form').on('submit', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#lang').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#video_title').on('keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#is_active').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
    });
    function deleteVideo(id, is_default) {
        var msg = 'Are you sure?';
        if (is_default == 1) {
            msg = 'Are you sure? You are going to delete default Video, all other non default Videos will be deleted too!';
        }
        if (confirm(msg)) {
            $.post("{{ route('delete.video') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'}, null, 'text')
                    .done(function (response) {
                        if (response == 'ok')
                        {
                            var table = $('#videoDatatableAjax').DataTable();
                            table.row('videoDtRow' + id).remove().draw(false);
                        } else
                        {
                            alert('Request Failed!');
                        }
                    });
        }
    }
    function makeActive(id) {
        $.post("{{ route('make.active.video') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#videoDatatableAjax').DataTable();
                        table.row('videoDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
    }
    function makeNotActive(id) {
        $.post("{{ route('make.not.active.video') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#videoDatatableAjax').DataTable();
                        table.row('videoDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('Request Failed!');
                    }
                });
    }
</script> 
@endpush