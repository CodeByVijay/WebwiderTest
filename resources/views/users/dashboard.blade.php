@extends('users.app')
@section('content')
    <div class="container mt-5">

        <div class="card p-4 shadow-lg">
            <div class="card-header">

                <div class="card-title">
                    <h4 class="float-start">Branch Lists</h4>
                    <a href="javascript:void(0)" class="btn btn-primary float-end openModal">Add
                        New Branch</a>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userBranchTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            {{-- Load Data Using Ajax --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- Add Branch Modal --}}

    <div class="modal fade" id="addBranch" tabindex="-1" aria-labelledby="addBranchLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addBranchLabel">Add New Branch</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBranchForm">
                        <div class="ids">
                            <input type="hidden" name="branch_id" class="branch_id">
                        </div>
                        <div class="mb-3">
                            <label for="branch_name" class="col-form-label">Branch: <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="branch_name" name="branch_name"
                                placeholder="Branch Name">
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="col-form-label">Latitude: <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude"
                            onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="col-form-label">Longitude: <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                placeholder="Longitude" onkeypress="return isNumberKey(event)">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="col-form-label">Address: <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="address" name="address" placeholder="Address"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addBranchButton">Create</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function isNumberKey(evt) {
            const charCode = (evt.which) ? evt.which : event.keyCode;
            // Allow: digits, decimal point, and minus sign
            if ((charCode >= 48 && charCode <= 57) || charCode == 46 || charCode == 45) {
                return true;
            }
            // Prevent entering any other characters
            return false;
        }
    </script>
@endsection
