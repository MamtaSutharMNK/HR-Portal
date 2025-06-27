$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
            function confirmAction(id) {

    Swal.fire({

        title: 'Are you sure?',

        text: "Do you really want to accept the request?",

        icon: 'question',

        showCancelButton: true,

        confirmButtonText: 'Yes',

        cancelButtonText: 'Cancel'

    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/fte_request/status-update',
                type: 'POST',
                data: {
                    id: id,
                    action : 'accept'
                },
                success: function (response) {
                    Swal.fire('Success', response.message, 'success').then(() => location.reload());
                },

                error: function (error) {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                }

            });

        }

    });

}

function rejectAction(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const stage = 'entry';
     $(".saveReject").removeClass('disabled');
     $("#id").val(id);
    Swal.fire({
        title: "Are you sure you want to Reject the request ?",
        icon: "warning",
        showCancelButton: true,
        showDenyButton: false,
        confirmButtonText: "YES",
    }).then((result) => {
            if (result.isConfirmed) {
                 $('#rejectModal').modal('show');
                $('#reject_form')[0].reset();
            }
    });
}
 
$(document).on('submit', '#reject_form', function (e) {
    e.preventDefault();
     $(".saveReject").addClass('disabled');
    // let bookinguuid = $('#business_uuid').val();
    let formData = new FormData(this);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));  
    formData.append('action', 'reject'); 
    $.ajax({
        type: "POST",
        url: '/fte_request/status-update',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            // Add the loading spinner or any loading indication here
            $('#loadingIndicator').show();
        },
        success: function (response) {
 
            $('#rejectModal').modal('hide');
            $('#reject_form')[0].reset();
            $("#loadingIndicator").hide();
 
            console.log('response');
            console.log(response);
            Swal.fire({
                text: response.message,
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'ok'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = '/fte_request/create';
                }
            })
        },
        error: function (xhr, status, error) {
            $(".submit_btn").prop("disabled", false);
            $('#loadingIndicator').hide();
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let errorMessages = [];
 
                for (let field in errors) {
                    errorMessages.push(errors[field][0]);
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Please fix the following issues.',
                    html: errorMessages.join('<br>'),
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops Something went wrong',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                });
            }
        }
    });
});

function StatusFTE(id, status) {

    Swal.fire({

        title: 'Are you sure?',

        text: "Do you really want to " + status +" the request?",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Yes',

        cancelButtonText: 'Cancel'

    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: '/fte_request/status-change',
                type: 'POST',
                data: {
                    id: id,
                    action : status
                },
                success: function (response) {
                    Swal.fire('Success', response.message, 'success').then(() => location.reload());
                },

                error: function (error) {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                }

            });

        }

    });

}