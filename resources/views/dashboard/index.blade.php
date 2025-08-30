@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('body')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
        <div class="row">

            {{-- Total Projects --}}
            <div class="col-lg-6 col-md-6 col-xl-3">
                <div class="card custom-card">
                    <div class="card-body d-flex align-items-center">
                        <span class="rounded p-3 bg-primary-transparent me-3">
                            <i class="fa-solid fa-diagram-project fa-2x text-primary"></i>
                        </span>
                        <div>
                            <div class="fw-bold">Projects</div>
                            <div class="fs-5">{{ $totalProjects }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Employees --}}
            <div class="col-lg-6 col-md-6 col-xl-3">
                <div class="card custom-card">
                    <div class="card-body d-flex align-items-center">
                        <span class="rounded p-3 bg-success-transparent me-3">
                            <i class="fa-solid fa-user-tie fa-2x text-success"></i>
                        </span>
                        <div>
                            <div class="fw-bold">Employees</div>
                            <div class="fs-5">{{ $totalEmployees }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Interns --}}
            <div class="col-lg-6 col-md-6 col-xl-3">
                <div class="card custom-card">
                    <div class="card-body d-flex align-items-center">
                        <span class="rounded p-3 bg-warning-transparent me-3">
                            <i class="fa-solid fa-user-graduate fa-2x text-warning"></i>
                        </span>
                        <div>
                            <div class="fw-bold">Interns</div>
                            <div class="fs-5">{{ $totalInterns }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Students --}}
            <div class="col-lg-6 col-md-6 col-xl-3">
                <div class="card custom-card">
                    <div class="card-body d-flex align-items-center">
                        <span class="rounded p-3 bg-info-transparent me-3">
                            <i class="fa-solid fa-graduation-cap fa-2x text-info"></i>
                        </span>
                        <div>
                            <div class="fw-bold">Students</div>
                            <div class="fs-5">{{ $totalStudents }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Leaves --}}
            <div class="col-lg-6 col-md-6 col-xl-3">
                <div class="card custom-card">
                    <div class="card-body d-flex align-items-center">
                        <span class="rounded p-3 bg-danger-transparent me-3">
                            <i class="fa-solid fa-calendar-check fa-2x text-danger"></i>
                        </span>
                        <div>
                            <div class="fw-bold">Leaves</div>
                            <div class="fs-5">{{ $totalLeaves }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Designations --}}
            <div class="col-lg-6 col-md-6 col-xl-3">
                <div class="card custom-card">
                    <div class="card-body d-flex align-items-center">
                        <span class="rounded p-3 bg-secondary-transparent me-3">
                            <i class="fa-solid fa-briefcase fa-2x text-secondary"></i>
                        </span>
                        <div>
                            <div class="fw-bold">Designations</div>
                            <div class="fs-5">{{ $totalDesignations }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tasks --}}
            <div class="col-lg-6 col-md-6 col-xl-3">
                <div class="card custom-card">
                    <div class="card-body d-flex align-items-center">
                        <span class="rounded p-3 bg-dark-transparent me-3">
                            <i class="fa-solid fa-tasks fa-2x text-dark"></i>
                        </span>
                        <div>
                            <div class="fw-bold">Tasks</div>
                            <div class="fs-5">{{ $totalTasks }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
