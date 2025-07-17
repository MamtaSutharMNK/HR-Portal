@component('mail::message')
#  New Support Ticket Created

A new support ticket has been submitted. Here are the details:

- **Ticket No:** {{ $data->ticket_no }}
- **Department:** {{ $data->department->name ?? 'N/A' }}
- **Category:** 
  @if ($data->issue_category_id)
    {{ $data->issueCategory->name ?? 'Unknown' }}
  @else
    _Temporary:_ {{ $data->temp_issue_cat }}
  @endif
- **Issue Type:** 
  @if ($data->issue_type_id)
    {{ $data->issueType->name ?? 'Unknown' }}
  @else
    _Temporary:_ {{ $data->temp_issue_type }}
  @endif
- **Description:**  
{!! nl2br(e(strip_tags($data->description))) !!}

- **Submitted By:** {{ $data->user->name ?? 'Unknown User' }}
- **Date Submitted:** {{ $data->created_at->format('d M Y, h:i A') }}

@component('mail::button', ['url' => route('support_tickets.show', $data->id)])
View Ticket
@endcomponent

Thank you,  
Team.
@endcomponent