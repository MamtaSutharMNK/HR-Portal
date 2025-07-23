<x-mail::message>
 
    Dear {{ $requestData->user->name ?? 'User' }},
    <br>
    <br>
    We wanted to let you know that positions for your request has been updated. 
    <br>
    <p>
        <x-mail::table>
            | FTE Request ID| REQUESTED BY|
            |:---------:|:-------:|:-----------:|
            |{{ $data->request_uuid }}|{{ $data->requested_by }}|
 
        </x-mail::table>
    </p>
    <br>
    <p>
        <x-mail::button :url="$url" color="success">
            View Details
        </x-mail::button>
    </p>
    <x-mail::subcopy>
        This is system generated email.
    </x-mail::subcopy>
</x-mail::message>