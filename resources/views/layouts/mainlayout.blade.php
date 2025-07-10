<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ str_replace('_', ' ', config('app.name')) }}</title>
    <link rel="shortcut icon" href="{{ asset('static\img\MNK group Logo.svg')}}" type="image/x-icon">


    {{-- Custom header includes --}}
    @include('components.header')

    @stack('styles')
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

    <link href="{{asset('static/css/fte.css')}}" rel="stylesheet">  
    <link href="{{asset('static/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('static/css/sb-admin-2.css')}}" rel="stylesheet">
    
    
    <style>
        .dropdown-color{
                background-color:#1098F7;
                color:white;
        }
        .dropdown-color:hover{
                color:white;
        }
        .dropdown-color.active{
                background-color:white;
        }

        .sidebar-sticky-wrapper {
            position: sticky;
            top: 0;
            height: 100vh; 
            overflow-y: auto;
            }
          .ck-editor__editable_inline {
                min-height: 10px;     
                max-height: 70px;     
                overflow-y: auto;      
                resize: none;
                width: 100%; 
                max-width: 100%;     
          
            }

            .ck-editor__editable {
                box-sizing: border-box;
                padding: 0.75rem;
            }


    </style>

</head>
<body id="page-top">

    {{-- Wrapper --}}
    <div id="wrapper">
        
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Content Wrapper --}}
        <div id="content-wrapper" class="d-flex flex-column">

            {{-- Main Content --}}
            <div id="content">
                
                {{-- Topbar/Navbar --}}
                @include('components.navbar')

                {{-- Main Page Content --}}
                <div class="container-fluid">
                    @yield('content')
                </div>

            </div>
            {{-- End of Main Content --}}
            
            <!-- {{-- Custom footer includes --}}
            @include('components.footer') -->

        </div>
        {{-- End of Content Wrapper --}}
    </div>
    {{-- End of Page Wrapper --}}

    {{-- Scroll to Top Button --}}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- Logout Modal --}}
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to logout?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- jQuery & Bootstrap --}}

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{asset('static/js/fte.js')}}"></script>
    <script src="{{asset('static/js/sb-admin-2.min.js')}}"></script>
    


    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const editorElement = document.querySelector('#editor');
            const charCountDisplay = document.getElementById("char-count");
            const maxChars = 500;

            if (editorElement) {
                ClassicEditor.create(editorElement, {
                    simpleUpload: {
                        uploadUrl: "{{ route('fte.upload') }}",
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    }
                })
                .then(editor => {
                    console.log("CKEditor initialized");

                    const editableEl = document.querySelector('.ck-editor__editable_inline');
                    editableEl.style.transition = 'width 0.3s ease';

                    editor.model.document.on('change:data', () => {
                        const plainText = editor.getData().replace(/<[^>]*>/g, '');
                        charCountDisplay.textContent = `${plainText.length}/${maxChars} characters`;

                        if (plainText.length > maxChars) {
                            editor.execute('undo');
                            Swal.fire({
                                title: 'Character Limit Exceeded',
                                text: `Only ${maxChars} characters are allowed.`,
                                icon: 'warning',
                                confirmButtonText: 'Got it'
                            });
                        }
                    });
                })
                .catch(error => {
                    console.error("CKEditor Init Error:", error);
                });
            }
        });
    </script>
    @stack('custome_js')
    @stack('scripts')
    @stack('charts')
    @stack('modals')

</body>
</html>