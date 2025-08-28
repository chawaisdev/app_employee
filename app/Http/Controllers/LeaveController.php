<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;   
class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $leaves = Leave::with('employee')->where('status', 'pending')->get();
        return view('leaves.index', compact('leaves'));
    }

    public function sickleaverequest(Request $request)
    {
        $leaves = Leave::with('employee')->where('type', 'sick')->get();
        return view('leaves.sick', compact('leaves'));
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            'leave_id' => 'required|exists:leaves,id',
            'status' => 'required|in:approved,rejected',
            'reason' => 'nullable|string|max:255',
        ]);

        $leave = Leave::findOrFail($request->leave_id);
        $leave->status = $request->status;
        if ($request->status === 'rejected') {
            $leave->reason = $request->reason; // Or store in separate field
        }
        $leave->save();
        return redirect()->back()->with('success', 'Leave status updated successfully.');
    }

}
