@extends('layouts.mainlayout')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/fte-show.css') }}">
@endpush

<div class="container-fluid">
    <div class="card o-hidden border-0 shadow-lg my-5 ">
        <div class="card-header py-3 button-blue-50 text-white text-center">
            <h4 class="m-0 font-weight-bold">Support Ticket Details</h4>
        </div>
        <div class="card-body">

            {{-- Basic Info --}}
            <div class="ant-description-row">
                <div class="ant-description-item">
                    <span class="ant-description-label">Ticket No:</span>
                    <span class="ant-description-content">{{ $ticket->ticket_no ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">UUID:</span>
                    <span class="ant-description-content">{{ $ticket->uuid ?? '-' }}</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Submitted By:</span>
                    <span class="ant-description-content">{{ $ticket->user->name ?? '-' }}</span>
                </div>
               
            </div>

            {{-- Department & Classification --}}
            <div class="ant-description-row">
                <div class="ant-description-item">
                    <span class="ant-description-label">Department:</span>
                    <span class="ant-description-content">{{ config('dropdown.department_list')[$ticket->department_id] ?? '-' }}
</span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Issue Category:</span>
                    <span class="ant-description-content">
                        @if ($ticket->issueCategory)
                            {{ $ticket->issueCategory->name }}
                        @elseif ($ticket->temp_issue_cat)
                            <em>Temporary:</em> {{ $ticket->temp_issue_cat }}
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="ant-description-item">
                    <span class="ant-description-label">Issue Type:</span>
                    <span class="ant-description-content">
                        @if ($ticket->issueType)
                            {{ $ticket->issueType->name }}
                        @elseif ($ticket->temp_issue_type)
                            <em>Temporary:</em> {{ $ticket->temp_issue_type }}
                        @else
                            -
                        @endif
                    </span>
                </div>
            </div>

            {{-- Description --}}
            <div class="ant-description-row">
                <div class="ant-description-item">
                    <span class="ant-description-label">Description:</span>
                    <span class="ant-description-content">{{ strip_tags($ticket->description) ?? '-' }}</span>
                </div>
                 <div class="ant-description-item">
                    <span class="ant-description-label">Date Submitted:</span>
                    <span class="ant-description-content">{{ $ticket->created_at->format('d M Y, h:i A') ?? '-' }}</span>
                </div>

                @if ($ticket->attachments->count())
                    <div class="ant-description-item" style="flex: 1;">
                        <span class="ant-description-label">Attachments</span>
                        <span class="ant-description-content">
                            <ul class="pl-3">
                                @foreach ($ticket->attachments as $file)
                                    <li>
                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                                            {{ $file->original_name }}
                                        </a> ({{ number_format($file->file_size / 1024, 2) }} KB)
                                    </li>
                                @endforeach
                            </ul>
                        </span>
                    </div>
                </div>
            @endif
          

         

              <div class="container-fluid">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('support_tickets.index')}}" class="btn btn-secondary btn-sm">
                        ← Go Back
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection