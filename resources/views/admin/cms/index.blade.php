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
                <li> <span>C.M.S</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">Manage C.M.S <small>C.M.S</small> </h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-dark"></i> <span class="caption-subject font-dark sbold uppercase">C.M.S</span> </div>
                        <div class="actions"> <a href="{{ route('create.cms') }}" class="btn btn-xs btn-succes"><i class="glyphicon glyphicon-plus"></i> Add New C.M.S Page</a> </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="cms-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="cms_datatable_ajax">
                                    <thead>
                                        <tr role="row" class="filter">
                                            <td><input type="text" class="form-control" name="id" id="id" autocomplete="off"></td>
                                            <td><input type="text" class="form-control" name="page_slug" id="page_slug" autocomplete="off"></td>
                                            <td></td>
                                        </tr>
                                        <tr role="row" class="heading">
                                            <th>Id</th>
                                            <th>Page Slug</th>
                                            <th>Actions</th>
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
        var oTable = $('#cms_datatable_ajax').DataTable({
            procesing: true,
            serverSide: true,
            stateSave: true,
            searching: false,
            "order": [[0, "desc"]],
            /*		
             paging: true,
             info: true,
             */
            ajax: {
                url: '{!! route('fetch.data.cms') !!}',
                data: function (d) {
                    d.id = $('#id').val();
                    d.page_slug = $('#page_slug').val();
                }
            }, columns: [
                /*{data: 'id_checkbox', name: 'id_checkbox', orderable: false, searchable: false},*/
                {data: 'id', name: 'id'},
                {data: 'page_slug', name: 'page_slug'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $('#cms-search-form').on('submit', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#id').on('keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#page_slug').on('keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });
    });
    function delete_cms(id) {
        if (confirm('Are you sure! you want to delete? All content pages will be deleted too.')) {
            $.post("{{ route('delete.cms') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        if (response == 'ok')
                        {
                            var table = $('#cms_datatable_ajax').DataTable();
                            table.row('cms_dt_row_' + id).remove().draw(false);
                        } else
                        {
                            alert('Request Failed!');
                        }
                    });
        }
    }
</script> 
@endpush