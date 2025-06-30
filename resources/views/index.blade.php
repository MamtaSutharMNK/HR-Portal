@extends('layouts.mainlayout')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const colorMap = {
    1: '#4e73df', // e.g. Pending - blue
    2: '#1cc88a', // Approved - green
    3: '#36b9cc', // In Progress - cyan
    4: '#f6c23e', // Completed - yellow
    5: '#e74a3b', // Rejected - red
    6: '#858796', // On Hold - gray
    7: '#20c9a6', // HR Approved - teal
    8: '#f4b619', // HR Rejected - orange
};
    document.addEventListener("DOMContentLoaded", function () {
        const statusCounts = @json($statusCount);
        const statuses = @json($status);

        const pieLabels = [];
        const pieData = [];
        const pieColors = [];

        Object.entries(statuses).forEach(([key, label]) => {
            pieLabels.push(label);
            pieData.push(statusCounts[key] || 0);
            // pieColors.push(getRandomColor());
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

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <!-- <h1 class="h3 mb-0 text-gray-800">Dashboard</h1> -->
    </div>

    <!-- Request Status Cards -->
    <h1 class="m-0 font-weight-bold text-primary mb-4">Request Status Overview</h1>
    <div class="row">
        @foreach($status as $key => $label)
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
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

    <!-- Row with Pie Chart and Email Summary side by side -->
    <div class="row">
        <!-- Pie Chart -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Request Status Distribution</h6>
                </div>
                <div class="card-body mt-3" style="margin-top: 50px;">
                    <div class="chart-pie pt-4 pb-2 d-flex justify-content-center" >
                        <canvas id="statusPieChart" style="height: 300px; max-width: 100%;"></canvas>
                    </div>
                </div>
            
            </div>
        </div>

        <!-- Email Status Summary -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Email Status Summary</h6>
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

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
@endsection