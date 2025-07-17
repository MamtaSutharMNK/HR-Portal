@component('mail::message')
# Reminder: Ticket Still Pending

Ticket **{{ $ticket->ticket_no }}** is still unresolved after 48 hours.

**Reason:** {{ $ticket->reason ?? 'N/A' }}

@component('mail::button', ['url' => route('support_tickets.show', $ticket->id)])
View Ticket
@endcomponent

Thanks,  
Team.
@endcomponent