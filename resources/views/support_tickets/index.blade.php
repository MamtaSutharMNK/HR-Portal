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
                <table class="table table-bordered nowrap " id="dataTable" width="100%" cellspacing="0">
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
                                    {{ $ticket->temp_issue_cat }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                              <td class="text-center">  @if ($ticket->issueType)
                                    {{ $ticket->issueType->name }}
                                @elseif ($ticket->temp_issue_type)
                                    {{ $ticket->temp_issue_type }}
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
                                    <span class="badge {{ $ticket->status_badge['class'] }} text-white">
                                        {{ $ticket->status_badge['label'] }}
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
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="handleTicketAction({{ $ticket->id }}, 'cancel')">
                                            <i class="fas fa-times-circle mr-1 text-danger"></i> Cancel Ticket
                                        </a>
                                    @endif

                                    @if($ticket->status != 3 && auth()->user()->email === $ticketDeptEmail)
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="handleTicketAction({{ $ticket->id }}, 'reviewed')">
                                        <i class="fas fa-check-circle mr-1 text-info"></i> Update Ticket
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="handleTicketAction({{ $ticket->id }}, 'resolved')">
                                        <i class="fas fa-check-circle mr-1 text-success"></i> Resolved
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
<script>
   
    $(document).ready(function() {
    $('#dataTable').DataTable({
        processing: true,
        serverSide: false,
        scrollX: true,
        pageLength: 10,
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },          
            { data: 'ticket_no', orderable: true, searchable: true, className: 'text-center' },     
            { data: 'issue_category', orderable: false, searchable: true, className: 'text-center' },
            { data: 'issue_type', orderable: false, searchable: true, className: 'text-center' },   
            { data: 'description', orderable: false, searchable: true },                            
            { data: 'department', orderable: false, searchable: true, className: 'text-center' },  
            { data: 'created_at', orderable: true, searchable: true, className: 'text-center' },    
            { data: 'requested_by', orderable: false, searchable: true, className: 'text-center' },
            { data: 'status', orderable: true, searchable: true, className: 'text-center' },        
            { data: 'action', orderable: false, searchable: false, className: 'text-center' }       
        ],
        order: [[1, 'desc']],
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
                    let newStatus = '';

                    if (actionType === 'cancel') {
                        newStatus = '<span class="badge bg-danger text-white">Cancelled</span>';
                    } else if (actionType === 'resolved') {
                        newStatus = '<span class="badge bg-success text-white">Resolved</span>';
                    } else if (actionType === 'reviewed') {
                        newStatus = '<span class="badge bg-warning text-dark">Reviewing</span>';
                    }

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