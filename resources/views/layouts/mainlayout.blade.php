<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>

    {{-- Custom header includes --}}
    @include('components.header')

    @stack('styles')
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

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
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

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

    @stack('custome_js')

</body>
</html>