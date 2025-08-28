<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $loggedUser = Auth::user();

        if ($loggedUser->user_type === 'employee') {
            // Show only this employee's records
            $attendance = Attendance::with('user')
                ->where('user_id', $loggedUser->id)
                ->orderBy('date', 'desc')
                ->paginate(10);
        } else {
            // Admin: Show all attendance for current date
            $attendance = Attendance::with('user')
                ->where('date', $today)
                ->orderBy('id', 'desc')
                ->paginate(10);
        }

        return view('attendance.index', compact('attendance', 'today', 'loggedUser'));
    }

    public function checkIn(Request $request)
    {
        $allowedIp = '127.0.0.1';
        $userIp = $request->ip(); // Get the client's IP

        if ($userIp !== $allowedIp) {
            return redirect()->back()->with('error', 'You are not allowed to check in from this IP.');
        }

        $today = Carbon::today()->toDateString();
        $loggedUser = Auth::user();

        // Check if already checked in
        $attendance = Attendance::where('user_id', $loggedUser->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            Attendance::create([
                'user_id'  => $loggedUser->id,
                'date'     => $today,
                'check_in' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('success', 'Checked in successfully.');
    }

    public function checkOut(Request $request)
    {
        $allowedIp = '127.0.0.1';
        $userIp = $request->ip(); // Get the client's IP

        if ($userIp !== $allowedIp) {
            return redirect()->back()->with('error', 'You are not allowed to check out from this IP.');
        }

        $today = Carbon::today()->toDateString();
        $loggedUser = Auth::user();

        $attendance = Attendance::where('user_id', $loggedUser->id)
            ->where('date', $today)
            ->first();

        if ($attendance && !$attendance->check_out) {
            $attendance->update([
                'check_out' => Carbon::now(),
            ]);
        }

        return redirect()->back()->with('success', 'Checked out successfully.');
    }

}
