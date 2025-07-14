<x-mail::message>
# Request Rejection Notification

Hello Team,

The request has been reviewed and **has been rejected**.

**Reason:** {{ $data->reason }}

If you have any questions or need clarification, feel free to reach out to your reporting manager.

Thanks,  
{{ config('app.name') }}
</x-mail::message>