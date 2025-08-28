@extends('layouts.app')

@section('title')
    Free Days Leaves
@endsection

@section('body')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Free Days Leaves</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboards</a></li>
                            <li class="breadcrumb-item active">Free Days Leaves</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header ">
                        <h5 class="card-title mb-0">All Free Days Leave</h5>
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Employee Name</th>
                                    <th>Type</th>
                                    <th>Start End</th>
                                    <th>End Date</th>
                                    <th>Document</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($leaves->isEmpty())
                                @else
                                    @foreach ($leaves as $leave)
                                        <tr>
                                            <td class="p-3">{{ $loop->iteration }}</td>
                                            <td class="p-3">{{ $leave->employee->name ?? 'N/A' }}</td>
                                            <!-- employee relation -->
                                            <td class="p-3">
                                                <span class="badge bg-success">{{ $leave->type ?? 'N/A' }}
                                                </span>
                                            </td> <!-- leave type -->
                                            <td class="p-3">
                                                {{ \Carbon\Carbon::parse($leave->start_date)->format('d M, Y') }}</td>
                                            <td class="p-3">
                                                {{ \Carbon\Carbon::parse($leave->end_date)->format('d M, Y') }}</td>
                                            <td class="p-3">{{ $leave->status ?? '-' }}</td>
                                            <td class="p-3">
                                                @if (!in_array($leave->status, ['approved', 'rejected']))
                                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#statusModal"
                                                        onclick="setLeaveData({{ $leave->id }}, '{{ $leave->status }}')">
                                                        Take Action
                                                    </a>
                                                @else
                                                    <span class="badge bg-success">{{ ucfirst($leave->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('leaves.updateStatus') }}">
                @csrf
                <input type="hidden" name="leave_id" id="leave_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Leave Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" id="statusSelect" class="form-select" required>
                                <option value="">Select</option>
                                <option value="approved">Approve</option>
                                <option value="rejected">Reject</option>
                            </select>
                        </div>

                        <div class="mb-3 d-none" id="rejectionReasonGroup">
                            <label>Rejection Reason</label>
                            <input type="text" class="form-control" name="reason" id="rejectionReason">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function setLeaveData(id, status) {
            document.getElementById('leave_id').value = id;
            document.getElementById('statusSelect').value = status;
            toggleReasonField(status);
        }

        document.getElementById('statusSelect').addEventListener('change', function() {
            toggleReasonField(this.value);
        });

        function toggleReasonField(status) {
            const reasonGroup = document.getElementById('rejectionReasonGroup');
            if (status === 'rejected') {
                reasonGroup.classList.remove('d-none');
            } else {
                reasonGroup.classList.add('d-none');
            }
        }
    </script>

@endsection
