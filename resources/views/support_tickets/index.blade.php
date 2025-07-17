@extends('layouts.mainlayout')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="d-flex justify-content-end">
        <a href="{{ route('support_tickets.create') }}" 
           class="btn btn-primary btn-sm d-flex align-items-center">
            Create New Ticket
        </a>
    </div>
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-header py-3 button-blue-50 text-center">
            <h4 class="m-0 font-weight-bold">Support Ticket List</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">SL.No</th>
                            <th class="text-center">Ticket No</th>
                            <th class="text-center">Issue Category</th>
                            <th class="text-center">Issue Type</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Department</th>
                            <th class="text-center">Date of request</th>
                            <th class="text-center">Requested By</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $index => $ticket)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $ticket->ticket_no }}</td>
                            <td class="text-center">  @if ($ticket->issueCategory)
                                    {{ $ticket->issueCategory->name }}
                                @elseif ($ticket->temp_issue_cat)
                                    <em>Temporary:</em> {{ $ticket->temp_issue_cat }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                              <td class="text-center">  @if ($ticket->issueType)
                                    {{ $ticket->issueType->name }}
                                @elseif ($ticket->temp_issue_type)
                                    <em>Temporary:</em> {{ $ticket->temp_issue_type }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>{!! Str::limit($ticket->description, 50) !!}</td>
                            <td class="text-center">
                                @if($ticket->department)
                                    {{ config('dropdown.department_list')[$ticket->department_id] ?? 'N/A' }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="text-center">{{ $ticket->created_at->format('d-m-Y H:i') }}</td>
                            <td class="text-center">{{ $ticket->user->name ?? 'N/A' }}</td>
                            <td class="text-center">
                                <span id="ticket-status-{{ $ticket->id }}">

                                @if($ticket->status == '0')
                                    <span class="badge bg-primary text-white">Pending</span>
                                @elseif($ticket->status == '1')
                                    <span class="badge bg-info text-white">In Progress</span>
                                @elseif($ticket->status == '3')
                                    <span class="badge bg-danger text-white">Closed</span>
                                @else
                                    <span class="badge bg-success text-white">Done</span>
                                @endif
                                  </span>

                            </td>
                            <td class="text-center">
                            @php
                             
                                  $departmentEmails = [
                                        '1' => env('ADMIN_SUPPORT_EMAIL'), 
                                        '2' => env('HR_SUPPORT_EMAIL'),      
                                        '3' => env('IT_SUPPORT_EMAIL'),      
                                    ];

                                    $ticketDeptEmail = $departmentEmails[$ticket->department_id] ?? null;


                            @endphp

                            <div class="dropdown">
                                <button class="btn btn-sm dropdown-color dropdown-toggle" type="button" data-toggle="dropdown">
                                     <i class="fas fa-cog mr-1"></i> Actions
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('support_tickets.show', $ticket->id) }}">
                                        <i class="fas fa-eye mr-1 text-primary"></i> View
                                    </a>
                                    @if(auth()->id() === $ticket->user_id && $ticket->status != 2)
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="handleTicketAction({{ $ticket->id }}, 'close')">
                                            <i class="fas fa-times-circle mr-1 text-danger"></i> Close
                                        </a>
                                    @endif

                                    @if($ticket->status != 3 && auth()->user()->email === $ticketDeptEmail)
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="handleTicketAction({{ $ticket->id }}, 'done')">
                                        <i class="fas fa-check-circle mr-1 text-success"></i> Done
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custome_js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
    $('#dataTable').DataTable({
        "order": [[4, "desc"]] 
    });
});

</script>


@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (performance.getEntriesByType('navigation')[0]?.type !== 'back_forward')
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
            @php
                session()->forget('success');
            @endphp

        });
        
    </script>
@endif

@endpush
@push('scripts')
<script>
    function handleTicketAction(ticketId, actionType) {
    Swal.fire({
        title: `${actionType.charAt(0).toUpperCase() + actionType.slice(1)} Ticket`,
        input: 'textarea',
        inputLabel: 'Enter the reason',
        inputPlaceholder: 'Type your message here...',
        confirmButtonColor: '#106073',
        confirmButtonText: 'Submit',
        showCancelButton: true,
        reverseButtons: true,
        preConfirm: (reason) => {
            if (!reason) {
                Swal.showValidationMessage('Please enter a reason');
            }
            return reason;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/support_tickets/${ticketId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: actionType,
                    reason: result.value
                })
            })
            .then(response => response.json())
            .then(data => {
               const statusSpan = document.querySelector(`#ticket-status-${ticketId}`);
                if (statusSpan) {
                    const newStatus = actionType === 'close' 
                        ? '<span class="badge bg-danger text-white">Closed</span>' 
                        : '<span class="badge bg-success text-white">Done</span>';

                    statusSpan.innerHTML = newStatus;
                }


                Swal.fire('Success', 'Ticket updated.', 'success');
            })
            .catch(() => {
                Swal.fire('Error', 'Failed to update ticket.', 'error');
            });
        }
    });
}
</script>
@endpush