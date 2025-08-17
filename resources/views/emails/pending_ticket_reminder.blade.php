@component('mail::message')
# Reminder: Ticket Still Pending

Ticket **{{ $ticket->ticket_no }}** is still unresolved after 48 hours.Please do resolve it immediatley.

**Reason:** {!! nl2br(e(strip_tags($ticket->description))) !!} 

@component('mail::button', ['url' => $url])
View Ticket
@endcomponent

Thanks,  
Team.
@endcomponent