@component('mail::message')
# Supprot ticket has been as {{ $ticket->status == '3' ? 'Closed' : 'Done' }}

- **Ticket No:** {{ $data->ticket_no }}
- **Department:** {{ $data->department->name ?? 'N/A' }}
- **Submitted By:** {{ $data->user->name ?? 'Unknown User' }}

**Reason:**
{{ strip_tags($ticket->reason) }}

@component('mail::button', ['url' => route('support_tickets.show', $data->id)])
View Ticket
@endcomponent


Thanks,  
Team.
@endcomponent