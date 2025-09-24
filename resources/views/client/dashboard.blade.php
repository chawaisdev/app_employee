@extends('layouts.app')

@section('title', 'Projec OverView')

@section('body')
    <div class="container-fluid mt-4">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Project Projec OverView</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <!-- Tasks -->
            <div class="col-lg-3 col-md-6">
                <div class="card custom-card">
                    <div class="card-body d-flex align-items-center">
                        <span class="rounded p-3 bg-info-transparent me-3">
                            <i class="fa-solid fa-list-check fa-2x text-info"></i>
                        </span>
                        <div>
                            <div class="fw-bold">Tasks</div>
                            <div class="fs-5">{{ $totalTasks }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed Tasks -->
            <div class="col-lg-3 col-md-6">
                <div class="card custom-card">
                    <div class="card-body d-flex align-items-center">
                        <span class="rounded p-3 bg-success-transparent me-3">
                            <i class="fa-solid fa-circle-check fa-2x text-success"></i>
                        </span>
                        <div>
                            <div class="fw-bold">Completed</div>
                            <div class="fs-5">{{ $completedTasks }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="col-lg-3 col-md-6">
                <div class="card custom-card">
                    <div class="card-body d-flex align-items-center">
                        <span class="rounded p-3 bg-warning-transparent me-3">
                            <i class="fa-solid fa-hourglass-half fa-2x text-warning"></i>
                        </span>
                        <div>
                            <div class="fw-bold">Pending</div>
                            <div class="fs-5">{{ $pendingTasks }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ongoing Tasks -->
            <div class="col-lg-3 col-md-6">
                <div class="card custom-card">
                    <div class="card-body d-flex align-items-center">
                        <span class="rounded p-3 bg-secondary-transparent me-3">
                            <i class="fa-solid fa-spinner fa-2x text-secondary"></i>
                        </span>
                        <div>
                            <div class="fw-bold">Ongoing</div>
                            <div class="fs-5">{{ $ongoingTasks }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graph -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <h5 class="card-title">Project Completion Overview</h5>
                        <div style="max-width: 500px; margin: 0 auto;">
                            <canvas id="completionChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('completionChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Completed', 'Remaining'],
            datasets: [{
                data: [{{ $completionPercentage }}, {{ 100 - $completionPercentage }}],
                backgroundColor: ['#2196F3', '#FF5252'], // Blue & Red
                borderColor: ['#1565C0', '#C62828'], // Darker borders
                borderWidth: 2,
                hoverOffset: 0 // <-- hover pe zoom disable
            }]
        },
        options: {
            responsive: true,
            animation: {
                animateScale: true, // smooth load animation
                duration: 1200
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.parsed || 0;
                            return `${label}: ${value}%`;
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Project Completion Percentage',
                    font: {
                        size: 16
                    }
                }
            }
        }
    });
</script>

@endsection