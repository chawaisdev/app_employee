<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $loggedUser = Auth::user(); // This should be employee or admin

        if ($loggedUser->user_type === 'employee') {
            $attendance = Attendance::with('employee')
                ->where('employee_id', $loggedUser->id)
                ->orderBy('date', 'desc')
                ->paginate(10);
        } else {
            $attendance = Attendance::with('employee')
                ->where('date', $today)
                ->orderBy('id', 'desc')
                ->paginate(10);
        }

        return view('attendance.index', compact('attendance', 'today', 'loggedUser'));
    }

    public function checkIn(Request $request)
    {
        $allowedIp = '127.0.0.1';
        $userIp = $request->ip();

        if ($userIp !== $allowedIp) {
            return redirect()->back()->with('error', 'You are not allowed to check in from this IP.');
        }

        $today = Carbon::today()->toDateString();
        $loggedUser = Auth::user();

        $attendance = Attendance::where('employee_id', $loggedUser->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            Attendance::create([
                'employee_id' => $loggedUser->id,
                'date'        => $today,
                'check_in'    => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('success', 'Checked in successfully.');
    }

    public function checkOut(Request $request)
    {
        $allowedIp = '127.0.0.1';
        $userIp = $request->ip();

        if ($userIp !== $allowedIp) {
            return redirect()->back()->with('error', 'You are not allowed to check out from this IP.');
        }

        $today = Carbon::today()->toDateString();
        $loggedUser = Auth::user();

        $attendance = Attendance::where('employee_id', $loggedUser->id)
            ->where('date', $today)
            ->first();

        if ($attendance && !$attendance->check_out) {
            $attendance->update([
                'check_out' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('success', 'Checked out successfully.');
    }

    public function  attendanceall(Request $request)
    {
        $attendance = Attendance::with('employee')
            ->orderBy('date', 'desc')
            ->paginate(10);
        return view('attendance.all', compact('attendance'));
    }
}
