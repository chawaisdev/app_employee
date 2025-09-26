 <!-- SIDEBAR -->

 <aside class="app-sidebar sticky" id="sidebar">

     <!-- Start::main-sidebar-header -->
     <div class="main-sidebar-header">
         <a href="" class="header-logo">
             <img class="mb-2 mt-3" src="{{ asset('assets/images/Techlostack logo.png') }}">

             {{-- <img src="/.svg" alt="logo" class="toggle-dark">
            <img src="/assets/images/others/logo.svg" alt="logo" class="desktop-white">
            <img src="/assets/images/others/logo.svg" alt="logo" class="toggle-white"> --}}
         </a>
     </div>

     <!-- Start::main-sidebar -->
     <div class="main-sidebar" id="sidebar-scroll">
         <!-- Start::nav -->
         <nav class="main-menu-container nav nav-pills flex-column sub-open">
             <div class="slide-left" id="slide-left">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                     viewBox="0 0 24 24">
                     <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                 </svg>
             </div>
             <li class="slide__category"><span class="category-name">Main</span></li>
             <ul class="main-menu">
                 @php
                     $user = Auth::guard('web')->user(); // User guard (Admin types)
                     $employee = Auth::guard('employee')->user(); // Employee guard
                 @endphp

                 {{-- Admin Menu --}}
                 {{-- Admin Menu --}}
                 @if ($user && $user->user_type === 'admin')
                     {{-- Dashboard --}}
                     <li class="slide">
                         <a href="{{ route('dashboard') }}" class="side-menu__item">
                             <i class="fa-solid fa-gauge-high side-menu__icon"></i>
                             <span class="side-menu__label">Dashboard</span>
                         </a>
                     </li>

                     {{-- Add User --}}
                     <li class="slide">
                         <a href="{{ route('adduser.index') }}" class="side-menu__item">
                             <i class="fa-solid fa-user-plus side-menu__icon"></i>
                             <span class="side-menu__label">Add User</span>
                         </a>
                     </li>

                     {{-- Tasks --}}
                     <li class="slide">
                         <a href="{{ route('tasks.index') }}" class="side-menu__item">
                             <i class="fa-solid fa-list-check side-menu__icon"></i>
                             <span class="side-menu__label">Tasks</span>
                         </a>
                     </li>

                     {{-- Designation --}}
                     <li class="slide mt-2">
                         <a href="{{ route('designation.index') }}" class="side-menu__item">
                             <i class="fa-solid fa-id-card side-menu__icon"></i>
                             <span class="side-menu__label">Designation</span>
                         </a>
                     </li>

                     {{-- Projects --}}
                     <li class="slide mt-2">
                         <a href="{{ route('project.index') }}" class="side-menu__item">
                             <i class="fa-solid fa-diagram-project side-menu__icon"></i>
                             <span class="side-menu__label">Projects</span>
                         </a>
                     </li>

                     {{-- Students --}}
                     <li class="slide mt-2">
                         <a href="{{ route('students.index') }}" class="side-menu__item">
                             <i class="fa-solid fa-user-graduate side-menu__icon"></i>
                             <span class="side-menu__label">Students</span>
                         </a>
                     </li>

                     {{-- Employees --}}
                     <li class="slide mt-2">
                         <a href="{{ route('employees.index') }}" class="side-menu__item">
                             <i class="fa-solid fa-users side-menu__icon"></i>
                             <span class="side-menu__label">Employees</span>
                         </a>
                     </li>

                     {{-- Clients --}}
                     <li class="slide mt-2">
                         <a href="{{ route('client.index') }}" class="side-menu__item">
                             <i class="fa-solid fa-handshake side-menu__icon"></i>
                             <span class="side-menu__label">Clients</span>
                         </a>
                     </li>

                     {{-- Attendance --}}
                     <li class="slide mt-2">
                         <a href="{{ url('attendance/all') }}" class="side-menu__item">
                             <i class="fa-solid fa-calendar-check side-menu__icon"></i>
                             <span class="side-menu__label">Attendance</span>
                         </a>
                     </li>
                 @endif

                 {{-- Client Menu --}}
                 @if ($user && $user->user_type === 'client')
                     <li class="slide">
                         <a href="{{ url('client/dashboard') }}" class="side-menu__item">
                             <i class="fa-solid fa-gauge-high side-menu__icon"></i>
                             <span class="side-menu__label">Dashboard</span>
                         </a>
                     </li>
                     <li class="slide">
                         <a href="{{ url('client/tasks') }}" class="side-menu__item">
                             <i class="fa-solid fa-list-check side-menu__icon"></i>
                             <span class="side-menu__label">Tasks</span>
                         </a>
                     </li>
                 @endif

                 {{-- Employee Menu --}}
                 @if ($employee)
                     <li class="slide mt-2">
                         <a href="{{ route('attendance.index') }}" class="side-menu__item">
                             <i class="fa-solid fa-calendar-check side-menu__icon"></i>
                             <span class="side-menu__label">Attendance</span>
                         </a>
                     </li>
                     <li class="slide">
                         <a href="{{ route('tasks.create') }}" class="side-menu__item">
                             <i class="fa-solid fa-plus-circle side-menu__icon"></i>
                             <span class="side-menu__label">Add Tasks</span>
                         </a>
                     </li>
                     <li class="slide mt-2">
                         <a href="{{ route('settings.index') }}" class="side-menu__item">
                             <i class="fa-solid fa-gear side-menu__icon"></i>
                             <span class="side-menu__label">Settings</span>
                         </a>
                     </li>
                 @endif

                 {{-- Logout --}}
                 @if ($user || $employee)
                     <li class="slide mt-2">
                         <a href="#" class="side-menu__item"
                             onclick="event.preventDefault(); document.getElementById('logout-link').submit();">
                             <i class="fa-solid fa-right-from-bracket side-menu__icon"></i>
                             <span class="side-menu__label">Logout</span>
                         </a>
                         <form id="logout-link" action="{{ route('logout') }}" method="POST" style="display: none;">
                             @csrf
                         </form>
                     </li>
                 @endif


                 {{-- Employee Menu --}}
                 @if ($employee)
                     {{-- Attendance (Employee) --}}
                     <li class="slide mt-2">
                         <a href="{{ route('attendance.index') }}" class="side-menu__item">
                             <i class="fa-solid fa-calendar-check side-menu__icon"></i>
                             <span class="side-menu__label">Attendance</span>
                         </a>
                     </li>

                     {{-- Tasks --}}
                     <li class="slide">
                         <a href="{{ route('tasks.create') }}" class="side-menu__item">
                             <i class="fa-solid fa-tasks side-menu__icon"></i>
                             <span class="side-menu__label">Add Tasks</span>
                         </a>
                     </li>

                     {{-- Settings --}}
                     <li class="slide mt-2">
                         <a href="{{ route('settings.index') }}" class="side-menu__item">
                             <i class="fa-solid fa-gear side-menu__icon"></i>
                             <span class="side-menu__label">Settings</span>
                         </a>
                     </li>
                 @endif
             </ul>
             <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                     width="24" height="24" viewBox="0 0 24 24">
                     <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                 </svg>
             </div>
         </nav>
     </div>
 </aside>
