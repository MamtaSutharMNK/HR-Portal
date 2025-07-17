@extends('layouts.mainlayout')

@section('content')

<div class="container-fluid">
    <!-- Request Status Cards -->
    <div class="card-header py-3 button-blue-50 mb-3">
        <h6 class="m-0 font-weight-bold" >Request Status Overview</h6>
    </div>    
    <div class="row">
        @foreach($status as $key => $label)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center clickable_card" data-status="{{ $label }}" style="cursor: pointer;">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                     {{ $label }}
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $statusCount[$key] ?? 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tasks fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <!-- Pie Chart -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 button-blue-50">
                    <h6 class="m-0 font-weight-bold ">Request Status Distribution</h6>
                </div>
                <div class="card-body mt-3" style="margin-top: 50px;">
                    <div class="chart-pie pt-4 pb-2 d-flex justify-content-center" >
                        <canvas id="statusPieChart" style="height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 button-blue-50">
                    <h6 class="m-0 font-weight-bold ">Email Status Summary</h6>
                </div>
                <div class="card-body">
                    @php
                        $totalEmails = array_sum($emailStatusCounts);
                        $barColors = [
                            1 => 'success', 2 => 'danger',
                            3 => 'success', 4 => 'danger',
                            5 => 'success', 6 => 'danger',
                            7 => 'success', 8 => 'danger',
                        ];
                    @endphp

                    @foreach ($emailStatus as $code => $label)
                        @php
                            $count = $emailStatusCounts[$code] ?? 0;
                            $percentage = $totalEmails > 0 ? round(($count / $totalEmails) * 100, 1) : 0;
                            $color = $barColors[$code] ?? 'info';
                        @endphp

                        <h4 class="small font-weight-bold">
                            {{ $label }}
                            <span class="float-right">{{ $count }} ({{ $percentage }}%)</span>
                        </h4>
                        <div class="progress mb-3" style="height: 0.75rem;">
                            <div class="progress-bar bg-{{ $color }}"
                                 role="progressbar"
                                 style="width: {{ $percentage }}%; transition: width 0.5s ease-in-out;"
                                 aria-valuenow="{{ $percentage }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Result Section -->
<div id="status-results" class="mt-4 d-none">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary" id="results-title">Results</h6>
            <button class="btn btn-sm btn-secondary close-results">Close</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Department</th>
                            <th>DEpartment Function</th>
                        </tr>
                    </thead>
                    <tbody id="results-body">
                        <!-- Results will be loaded here via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush

@push('charts')
<script>

    document.addEventListener("DOMContentLoaded", function () {
        const colorMap = {
            1: '#49BFB5', // e.g. Pending - blue
            2: '#1cc88a', // Approved - green
            3: '#36b9cc', // In Progress - cyan
            4: '#f6c23e', // Completed - yellow
            5: '#e74a3b', // Rejected - red
            6: '#858796', // On Hold - gray
            7: '#20c9a6', // HR Approved - teal
            8: '#f4b619', // HR Rejected - orange
        };
        const statusCounts = @json($statusCount);
        const statuses = @json($status);

        const pieLabels = [];
        const pieData = [];
        const pieColors = [];

        Object.entries(statuses).forEach(([key, label]) => {
            pieLabels.push(label);
            pieData.push(statusCounts[key] || 0);
            pieColors.push(colorMap[key] || '#999999');

        });

        const ctx = document.getElementById("statusPieChart").getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieData,
                    backgroundColor: pieColors,
                    hoverOffset: 10,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return `${context.label}: ${context.parsed} requests`;
                            }
                        }
                    }
                }
            }
        });

        function getRandomColor() {
            const letters = "0123456789ABCDEF";
            let color = "#";
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    });
</script>
@endpush


@push('modals')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: 2500,
            showConfirmButton: false,
        });
    });
</script>
@endif
@endpush