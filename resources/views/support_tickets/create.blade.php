@extends('layouts.mainlayout')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="card o-hidden border-0 shadow-lg my-5 ">
            <div class="card shadow">
                <div class="card-header bg-primary button-blue-50 text-white">
                    <h1 class="h4 mb-0 ">Create Support Ticket</h1>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('support_tickets.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title"
                                    class="form-label block text-black font-medium ml-2 uppercase">Ticket Title</label>
                            <input type="text" name="title" id="title"
                                    class="form-control text-black focus:text-black border-gray-300 rounded"
                                    required value="{{old('title')}}"/>
                        </div>
                        <div class="mb-3 mt-2">
                            <label for="issue_type" class="form-label block text-black font-medium ml-2
                                uppercase">Department</label>
                            <select name="department_id" id="department_id" required
                                    class="form-select form-control text-black focus:text-black
                                        border-gray-300 rounded uppercase">
                                        <option value="" selected disabled>Please Select Department</option>
                                @foreach(config('dropdown.department_list') as $key => $department)
                                        <option value="{{$key}}" @selected(old('department') == $key)>
                                                {{$department}}</option>
                                    @endforeach
                            </select>
                            <p class="ml-2 mt-1 text-danger uppercase" id="department_id_description"></p>
                        </div>
                        <div>
                            <label for="description" class="form-label block text-black font-medium ml-2 uppercase">Detailed
                                Description</label>
                            <div id="editor" style="color: black;height: 200px">
                            </div>
                            <input class="mb-3 d-none" name="job_description" disabled
                                    id="quill-editor-area"/>
                            <input id="descriptionDetails" type="hidden" name="description"
                                    value="{{old('description')}}">
                        </div>
                        <div class="mb-3 mt-2">
                            <label for="title"
                                    class="form-label block text-black font-medium ml-2 uppercase">Attachments</label>
                            <input type="file"
                                    class="filepond text-black focus:text-black border-gray-300 rounded"
                                    name="attachments[]" multiple>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-50">Create Ticket</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection

@push('custome_js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
