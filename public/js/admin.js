$(document).ready(function () {
    var adminBranchTable = $("#adminBranchTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "dashboard",
        },
        columns: [
            { data: "id", name: "id" },
            { data: "name", name: "name" },
            { data: "address", name: "address" },
            { data: "latitude", name: "latitude" },
            { data: "longitude", name: "longitude" },
            {
                data: "created_by",
                name: "created_by",
                orderable: false,
                searchable: false,
            },

            {
                data: "updated_by",
                name: "updated_by",
                orderable: false,
                searchable: false,
            },
            {
                data: "deleted_by",
                name: "deleted_by",
                orderable: false,
                searchable: false,
            },
        ],
        order: [[0, "asc"]],
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        // createdRow: function (row, data, dataIndex) {
        //     $('td:eq(0)', row).html(dataIndex + 1);
        // },
        language: {
            emptyTable: "No records found", // Message to show when no data is available
        },
    });


    $(document).on("click", "#refreshTable", function (e) {
        adminBranchTable.ajax.reload();
    });

});
