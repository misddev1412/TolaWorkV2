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
                <li> <span>Admin Users List</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title"> Manage Admin Users <small>Admin Users</small> </h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-dark"></i> <span class="caption-subject font-dark sbold uppercase">Admin User(s)</span> </div>
                        <div class="actions">
                            <a href="{{ route('create.admin.user') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Add New Admin User</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <table class="table table-striped table-bordered table-hover"  id="admin_user_datatable_ajax">
                                <thead>
                                    <tr role="row" class="heading"> 
                                      <!--<th><input type="checkbox" class="group-checkable"></th>-->
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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
        $('#admin_user_datatable_ajax').DataTable({
            "order": [[0, "asc"]],
            processing: true,
            serverSide: true,
            stateSave: true,
            /*
             searching: false,
             paging: true,
             info: true,
             */
            ajax: '{!! route('fetch.data.admin.users') !!}',
            columns: [
                /*{data: 'id_checkbox', name: 'id_checkbox', orderable: false, searchable: false},*/
                {data: 'name', name: 'admins.name'},
                {data: 'email', name: 'admins.email'},
                {data: 'role_name', name: 'roles.role_name'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
    function delete_user(id) {
        if (confirm('Are you sure! you want to delete?')) {
            $.post("{{ route('delete.admin.user') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        if (response == 'ok')
                        {
                            var table = $('#admin_user_datatable_ajax').DataTable();
                            table.row('admin_user_dt_row_' + id).remove().draw(false);
                        } else
                        {
                            alert('Request Failed!');
                        }
                    });
        }
    }
</script> 
@endpush