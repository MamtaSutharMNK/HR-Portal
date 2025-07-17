@component('mail::message')
# Your supprot ticket has been {{ $ticket->status == '3' ? 'Closed' : 'resolved' }}.

- **Ticket No:** {{ $data->ticket_no }}
- **Department:** {{ $data->department->name ?? 'N/A' }}
- **Submitted By:** {{ $data->user->name ?? 'Unknown User' }}

**Action:**
{{ strip_tags($ticket->reason) }}

@component('mail::button', ['url' => route('support_tickets.show', $data->id)])
View Ticket
@endcomponent


Thanks,  
Team.
@endcomponent