$(document).ready(function () {
    var userBranchTable = $("#userBranchTable").DataTable({
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
                data: "action",
                name: "action",
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

    $(document).on("click", ".openModal", function (e) {
        $("#addBranchLabel").html(`Add New Branch`);
        $("#addBranchForm")[0].reset();
        $("#addBranchButton").text("Create");
        $("#addBranch").modal("show");
    });

    $("#addBranchButton").on("click", function (e) {
        e.preventDefault();
        storeBranch(this);
    });

    function storeBranch(btnReference) {
        const orgtext = $(btnReference).text();
        let data = $("#addBranchForm").serialize();

        // Disable the button and change the text to "Please wait..."
        $(btnReference).attr("disabled", true);
        $(btnReference).text("Please wait...");

        $.ajax({
            url: "/user/store-branch",
            type: "POST",
            data: data,
            success: function (response) {
                if (response.status === true) {
                    $(btnReference).text(orgtext);
                    $("#addBranch").modal("hide");
                    $("#addBranchForm")[0].reset();
                    alert(response.message);
                    userBranchTable.ajax.reload();
                } else {
                    alert(
                        response.message ||
                            "An error occurred while adding the branch."
                    );
                }
            },
            error: function (xhr, status, error) {
                try {
                    const response = JSON.parse(xhr.responseText);

                    if (response && response.message) {
                        alert(response.message);
                    } else {
                        alert(
                            "An error occurred while processing your request. Please try again."
                        );
                    }

                    console.error("Error details:", error, xhr.responseText);
                } catch (e) {
                    alert("An unexpected error occurred. Please try again.");
                    console.error("Parsing error:", e);
                }
            },
            complete: function () {
                $(btnReference).attr("disabled", false);
                $(btnReference).text(orgtext);
            },
        });
    }

    $(document).on("click", ".editBranch", function (e) {
        e.preventDefault();
        $("#addBranchForm")[0].reset();
        getBranchDetails(this);
    });

    function getBranchDetails(btnReference) {
        const orgtext = $(btnReference).text();

        // Disable the button and change the text to "Please wait..."
        $(btnReference).attr("disabled", true);
        $(btnReference).text("Please wait...");
        let id = $(btnReference).data("id");

        $.ajax({
            url: "/user/get-branch/" + id,
            type: "GET",
            success: function (response) {
                if (response.status === true) {
                    console.log(response.branch);
                    $("#addBranchLabel").html(
                        `Update Branch - ${response.branch.name}`
                    );
                    $(".branch_id").val(response.branch.id);
                    $("#branch_name").val(response.branch.name);
                    $("#address").val(response.branch.address);
                    $("#latitude").val(response.branch.latitude);
                    $("#longitude").val(response.branch.longitude);
                    $("#addBranchButton").text("Update");
                    $("#addBranch").modal("show");
                } else {
                    alert(
                        response.message ||
                            "An error occurred while adding the branch."
                    );
                }
            },
            error: function (xhr, status, error) {
                try {
                    const response = JSON.parse(xhr.responseText);

                    if (response && response.message) {
                        alert(response.message);
                    } else {
                        alert(
                            "An error occurred while processing your request. Please try again."
                        );
                    }
                    console.error("Error details:", error, xhr.responseText);
                } catch (e) {
                    alert("An unexpected error occurred. Please try again.");
                    console.error("Parsing error:", e);
                }
            },
            complete: function () {
                $(btnReference).attr("disabled", false);
                $(btnReference).text(orgtext);
            },
        });
    }

    $(document).on("click", ".branchDelete", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        $(this).text("Please wait...");
        $(this).attr("disabled", true);
        $.ajax({
            url: "/user/delete-branch/" + id,
            type: "GET",
            success: function (response) {
                if (response.status === true) {
                    userBranchTable.ajax.reload();
                    alert(response.message);
                } else {
                    alert(
                        response.message ||
                            "An error occurred while adding the branch."
                    );
                }
            },
            error: function (xhr, status, error) {
                const response = JSON.parse(xhr.responseText);
                if (response && response.message) {
                    alert(response.message);
                } else {
                    alert(
                        "An error occurred while processing your request. Please try again."
                    );
                }
                console.error("Error details:", error, xhr.responseText);
            },
        });
    });
});
