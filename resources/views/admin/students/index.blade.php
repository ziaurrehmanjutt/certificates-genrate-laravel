@extends('admin.layouts.app')

@section('title', 'Students List')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <style>
        .filter-card {
            margin-bottom: 20px;
        }
        .dt-buttons {
            margin-bottom: 15px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-alert-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div>
                        <h3 class="mb-0">Students Management</h3>
                        <p class="text-muted">Manage all students enrolled in programs</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.students.create') }}" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                            <i class="mdi mdi-plus btn-icon-prepend"></i> Add New Student
                        </a>
                    </div>
                </div>

                <!-- Filters Card -->
                <div class="card filter-card mt-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="mdi mdi-filter-variant"></i> Filters
                        </h5>
                        <form id="filterForm">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="filter_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="filter_name" name="name" placeholder="Search by name...">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="filter_email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="filter_email" name="email" placeholder="Search by email...">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="filter_cnic" class="form-label">CNIC</label>
                                    <input type="text" class="form-control" id="filter_cnic" name="cnic" placeholder="CNIC...">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="filter_gender" class="form-label">Gender</label>
                                    <select class="form-control" id="filter_gender" name="gender">
                                        <option value="">All</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3 d-flex align-items-end">
                                    <button type="button" id="applyFilter" class="btn btn-primary me-2">
                                        <i class="mdi mdi-magnify"></i> Search
                                    </button>
                                    <button type="button" id="resetFilter" class="btn btn-secondary">
                                        <i class="mdi mdi-refresh"></i> Reset
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Students Table -->
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="studentsTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>CNIC</th>
                                        <th>Gender</th>
                                        <th>Phone</th>
                                        <th>Active Programs</th>
                                        <th>Total Enrollments</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#studentsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.students.index') }}",
                    data: function (d) {
                        d.name = $('#filter_name').val();
                        d.email = $('#filter_email').val();
                        d.cnic = $('#filter_cnic').val();
                        d.gender = $('#filter_gender').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'full_name', name: 'first_name' },
                    { data: 'email', name: 'email' },
                    { data: 'cnic', name: 'cnic', defaultContent: '-' },
                    { data: 'gender', name: 'gender', defaultContent: '-' },
                    { data: 'phone', name: 'phone', defaultContent: '-' },
                    { data: 'active_programs', name: 'active_programs', orderable: false },
                    { data: 'enrollments_count', name: 'enrollments_count', orderable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[1, 'asc']],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                }
            });

            // Apply Filter
            $('#applyFilter').click(function() {
                table.draw();
            });

            // Reset Filter
            $('#resetFilter').click(function() {
                $('#filterForm')[0].reset();
                table.draw();
            });

            // Enter key to search
            $('#filterForm input').keypress(function(e) {
                if(e.which == 13) {
                    e.preventDefault();
                    table.draw();
                }
            });

            // Delete functionality
            $(document).on('click', '.delete-btn', function() {
                var studentId = $(this).data('id');

                if(confirm('Are you sure you want to delete this student?')) {
                    $.ajax({
                        url: "{{ route('admin.students.index') }}/" + studentId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if(response.success) {
                                table.draw();
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('Error deleting student');
                        }
                    });
                }
            });
        });
    </script>
@endpush
