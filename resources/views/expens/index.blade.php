@extends('layouts.app')

@section('title')
    Expense Index
@endsection

@section('body')
    <div class="container-fluid">
        <!-- PAGE HEADER -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Expense</li>
                </ol>
            </nav>
            <button class="btn btn-primary btn-sm" onclick="openAddModal()">Add Expense</button>
        </div>

        <!-- TABLE -->
        <div class="col-xl-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title">All Expense</h6>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table id="example" class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th scope="col">S#</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $index => $expense)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $expense->description }}</td>
                                        <td>{{ number_format($expense->price, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                                        <td>
                                            <!-- Delete Button -->
                                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>

                                            <!-- Edit Button -->
                                            <button class="btn btn-sm btn-warning"
                                                onclick="openEditModal({ 
                                                    id: {{ $expense->id }}, 
                                                    description: '{{ $expense->description }}', 
                                                    price: '{{ $expense->price }}', 
                                                    date: '{{ \Carbon\Carbon::parse($expense->date)->format('Y-m-d') }}' 
                                                })">
                                                <i class="fa fa-pen-to-square"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD / EDIT MODAL -->
    <div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="expenseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="expenseForm" method="POST" action="">
                @csrf
                <input type="hidden" name="_method" value="POST" id="formMethod">
                <input type="hidden" name="id" id="expense_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="expenseModalLabel">Add Expense</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="description">Expense Description</label>
                            <input type="text" class="form-control" name="description" id="description" required>
                        </div>

                        <div class="form-group mb-2">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price" id="price" required>
                        </div>

                        <div class="form-group mb-2">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" name="date" id="date"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        function openAddModal() {
            $('#expenseForm').attr('action', '{{ route('expenses.store') }}');
            $('#formMethod').val('POST');
            $('#expenseModalLabel').text('Add Expense');
            $('#description').val('');
            $('#price').val('');
            $('#date').val('{{ date('Y-m-d') }}');
            $('#expense_id').val('');
            $('#expenseModal').modal('show');
        }

        function openEditModal(expense) {
            $('#expenseForm').attr('action', '/expenses/' + expense.id);
            $('#formMethod').val('PUT');
            $('#expenseModalLabel').text('Edit Expense');
            $('#description').val(expense.description);
            $('#price').val(expense.price);
            $('#date').val(expense.date);
            $('#expense_id').val(expense.id);
            $('#expenseModal').modal('show');
        }
    </script>
@endsection
