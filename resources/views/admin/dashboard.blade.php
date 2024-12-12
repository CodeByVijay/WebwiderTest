@extends('admin.app')
@section('content')

<div class="container mt-5">

    <div class="card p-4 shadow-lg">
        <div class="card-header">

            <div class="card-title">
                <h4 class="float-start">Branch Lists</h4>
                <a href="javascript:void(0)" class="btn btn-primary float-end" id="refreshTable">Refresh Table</a>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="adminBranchTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Deleted By</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Load Data Using Ajax --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
