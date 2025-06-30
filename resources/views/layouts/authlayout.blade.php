<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name')}}</title>
    <link rel="shortcut icon" href="{{ asset('static\img\MNK group Logo.svg')}}" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="{{asset('static/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('static/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('static/css/sb-admin-2.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css">

    <!-- css for fte request form -->
    <link href="{{asset('static/css/fte.css')}}" rel="stylesheet">  

</head>

<body class="bg-gradient-primary">

    @yield('content')

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('static/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('static/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('static/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('static/js/sb-admin-2.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- script for fte page -->
    <script src="{{asset('static/js/fte.js')}}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/classic/ckeditor.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const editorElement = document.querySelector('#editor');
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
                        console.log("CKEditor ready");
                    })
                    .catch(error => {
                        console.error("CKEditor Init Error:", error);
                    });
                }
            });
        </script>

</body>

</html>