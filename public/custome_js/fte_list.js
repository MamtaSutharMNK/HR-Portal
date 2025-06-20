function confirmAction(id) {

    Swal.fire({

        title: 'Are you sure?',

        text: "Do you really want to accept the request?",

        icon: 'warning',

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

 

function rejectAction(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to reject this request?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, reject it!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/fte_request/status-update',
                type: 'POST',
                data: {
                    id: id,
                    action: 'reject',
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    Swal.fire('Rejected', response.message, 'success').then(() => location.reload());
                },
                error: function (error) {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                }
            });
        }
    });
}