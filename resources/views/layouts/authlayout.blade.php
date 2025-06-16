<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{config('app.name')}}</title>
    <link rel="shortcut icon" href="{{ asset('static\img\specialty-mga-uk.png')}}" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="{{asset('static/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('static/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('static/css/sb-admin-2.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css">

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

    <script src="{{ asset('js/form-handler.js') }}"></script>

    <script>
document.addEventListener("DOMContentLoaded", function() {
    const jobroleSelect = document.getElementById("jobrole");
    const bandInput = document.getElementById("band");

    jobroleSelect.addEventListener("change", function() {
        const selectedOption = jobroleSelect.options[jobroleSelect.selectedIndex];
        bandInput.value = selectedOption.getAttribute("data-band") || "";
    });
});
</script>
</body>

</html>