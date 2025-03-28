<?php
include_once("./includes/config.php");
include(__DIR__ . "/includes/auth.php");
include(__DIR__ . "/includes/header.php");
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="p-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Recipients</h4>
                <button type="button" class="btn btn-primary sm-btn" data-toggle="modal" data-target="#addRecipientModal">
                    Add Recipient
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive" id="recipientTable">
                    <table class="table table-striped table-hover" id="tableExport" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="recipientData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "./includes/footer.php";
?>

<!-- model add Recipient start -->
<div class="modal fade" id="addRecipientModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Add Recipient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="addRecipientForm">
                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Email" name="email" id="emailInput" required>
                        </div>
                        <small id="emailFeedback" class="form-text mt-1"></small>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Name" name="name" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3" id="addButton">Add</button>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- model add Recipient end    -->

<!-- model Edit Recipient     -->
<div class="modal fade" id="editRecipientModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Recipient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="editRecipientForm">
                    <input type="hidden" name="id" id="edit-id">

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="edit-email" name="email" required>
                        <small id="editEmailFeedback" class="form-text mt-1"></small>
                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="edit-name" name="name">
                    </div>

                    <button type="submit" class="btn btn-primary" id="editSaveBtn">Update</button>
                </form>
            </div>

        </div>
    </div>
</div>


<!-- Toast container -->
<div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 2000;">
    <div id="toastMessage" class="toast" data-delay="2000">
        <div class="toast-header">
            <strong class="mr-auto" id="toastTitle">Info</strong>
            <small class="text-muted">Now</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body" id="toastBody">
            Placeholder message
        </div>
    </div>
</div>



<script>
    function showToast(title, message, type = 'info') {
        $('#toastTitle').text(title);
        $('#toastBody').text(message);

        let header = $('#toastMessage .toast-header');
        header.removeClass('bg-success bg-danger bg-info text-white');

        if (type === 'success') header.addClass('bg-success text-white');
        else if (type === 'error') header.addClass('bg-danger text-white');
        else header.addClass('bg-info text-white');

        $('#toastMessage').toast('show');
    }

    // show data in tables function
    function loadRecipients() {
        $.ajax({
            url: 'get-recipients.php',
            type: 'GET',
            success: function(data) {
                // Destroy existing DataTable
                if ($.fn.DataTable.isDataTable('#recipientTable')) {
                    $('#recipientTable').DataTable().clear().destroy();
                }

                // Inject new rows
                $('#recipientData').html(data);

                // Re-initialize DataTable
                $('#recipientTable').DataTable({
                    responsive: true,
                    pageLength: 10,
                    dom: 'Bfrtip',
                    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                });
            },
            error: function() {
                $('#recipientData').html('<tr><td colspan="5" class="text-center text-danger">Error loading data</td></tr>');
            }
        });
    }

    // delete the reciipients
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        if (confirm('Are you sure you want to delete this recipient?')) {
            $.ajax({
                url: 'delete-recipient.php',
                type: 'POST',
                data: {
                    id
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        showToast('Deleted', res.message, 'success');
                        loadRecipients(); // reload table
                    } else {
                        showToast('Error', res.message, 'error');
                    }
                },
                error: function() {
                    showToast('Error', 'Failed to delete recipient.', 'error');
                }
            });
        }
    });

    // Open edit modal with recipient data
    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const email = $(this).data('email');

        $('#edit-id').val(id);
        $('#edit-name').val(name);
        $('#edit-email').val(email);
        $('#editEmailFeedback').text('');
        $('#editRecipientModal').modal('show');
    });

    // Submit edited recipient via AJAX
    $('#editRecipientForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: 'update-recipient.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    showToast('Updated', res.message, 'success');
                    $('#editRecipientModal').modal('hide');
                    loadRecipients(); // reload table
                } else {
                    showToast('Error', res.message, 'error');
                }
            },
            error: function() {
                showToast('Error', 'Update failed.', 'error');
            }
        });
    });


    // check the email is exist or not in add Recipients
    $(document).ready(function() {
        loadRecipients();
        const $emailInput = $('#emailInput');
        const $emailFeedback = $('#emailFeedback');
        const $addButton = $('#addButton');
        const $modal = $('#addRecipientModal');
        const $form = $('#addRecipientForm');

        // Live email validation
        $emailInput.on('input', function() {
            const email = $(this).val().trim();

            if (email.length > 5) {
                $.ajax({
                    url: 'check-email.php',
                    type: 'POST',
                    data: {
                        email
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.invalid) {
                            $emailFeedback.text('⚠️ Invalid email format').css('color', 'orange');
                            $addButton.prop('disabled', true);
                        } else if (res.exists) {
                            $emailFeedback.text('❌ Email already exists').css('color', 'red');
                            $addButton.prop('disabled', true);
                        } else {
                            $emailFeedback.text('').css('color', 'green');
                            $addButton.prop('disabled', false);
                        }
                    },
                    error: function() {
                        $emailFeedback.text('Error checking email').css('color', 'gray');
                        $addButton.prop('disabled', true);
                    }
                });
            } else {
                $emailFeedback.text('');
                $addButton.prop('disabled', true);
            }
        });


        // Reset form when modal is closed
        $modal.on('hidden.bs.modal', function() {
            $form[0].reset(); // Reset all fields
            $emailFeedback.text(''); // Clear feedback message
            $addButton.prop('disabled', true); // Disable button again
        });
    });

    // check the email is exist or not in edit Recipients
    // Live email check on edit modal
    $('#edit-email').on('input', function() {
        const email = $(this).val().trim();
        const excludeId = $('#edit-id').val();
        const $feedback = $('#editEmailFeedback');
        const $btn = $('#editSaveBtn');


        if (email.length > 5) {
            $.ajax({
                url: 'check-email.php',
                type: 'POST',
                data: {
                    email: email,
                    excludeId: excludeId
                },
                dataType: 'json',
                success: function(res) {
                    if (res.invalid) {
                        $feedback.text('⚠️ Invalid email format').css('color', 'orange');
                        $btn.prop('disabled', true);
                    } else if (res.exists) {
                        $feedback.text('❌ Email already exists').css('color', 'red');
                        $btn.prop('disabled', true);
                    } else {
                        $feedback.text('✅ Email is available').css('color', 'green');
                        $btn.prop('disabled', false);
                    }
                },
                error: function() {
                    $feedback.text('Error checking email').css('color', 'gray');
                    $btn.prop('disabled', true);
                }


            });
        } else {
            $feedback.text('');
            $btn.prop('disabled', true);
        }
    });



    // add Recipient
    $(document).ready(function() {
        $("#addRecipientForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "add-recipient.php",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(res) {
                    if (res.status === "success") {
                        showToast("Success", res.message, "success");
                        $("#addRecipientModal").modal("hide");
                        $("#addRecipientForm")[0].reset();
                        loadRecipients();


                    } else {
                        showToast("Error", res.message, "error");
                    }
                },
                error: function() {
                    showToast("Error", "Something went wrong with the request.", "error");
                }
            });
        });
    });
</script>