<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
</head>
<body>
    <h2>Welcome, {{ $employee->full_name }}</h2>
    <p>Email: {{ $employee->email }}</p>
    <p>Email: {{ $employee->full_name }}</p>

    <form action="{{ route('employee.logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
