{{-- resources/views/emails/fte_requestClose.blade.php --}}

@component('mail::message')
# FTE Request Closed

Hello Team,

This is to inform you that the FTE request (ID: **{{ $data->id }}**) has been successfully **closed**.

**Details:**

- **Department:** {{ $data->department->name }}
- **Requested By:** {{ $data->requested_by }}
- **Closure Date:** {{ \Carbon\Carbon::now()->format('d M Y') }}

If you have any questions, feel free to reach out to the HR team.

Thank You,<br>
{{ config('app.name') }}
@endcomponent