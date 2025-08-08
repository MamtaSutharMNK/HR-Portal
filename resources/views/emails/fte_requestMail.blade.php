<x-mail::message>
 
    @php
        $email = $data->user->email ?? 'User';
        $name = explode('.', $email)[0];
        preg_match('/^[a-zA-Z]+/', $name, $matches);
        $firstName = $matches[0] ?? 'User';
    @endphp

    Hi {{$firstName}},
    <br>
    <br>
    There is a new request awaiting your approval.
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
 