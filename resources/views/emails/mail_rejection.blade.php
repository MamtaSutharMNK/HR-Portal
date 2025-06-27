<x-mail::message>
# Request Rejection Notification

Dear {{ $data->employee_name ?? 'Team Member' }},

Your request has been reviewed and **has been rejected**.

**Reason:** {{ $data->reason }}

If you have any questions or need clarification, feel free to reach out to your reporting manager.

<x-mail::button :url="'mailto:' . $data->manager_email">
Contact Manager
</x-mail::button>

Thanks,  
{{ config('app.name') }}
</x-mail::message>