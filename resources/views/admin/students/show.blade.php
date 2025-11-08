@extends('admin.layouts.app')

@section('title', 'Student Details - ' . $student->full_name)

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <style>
        .student-avatar {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }
        .info-label {
            font-weight: 600;
            color: #6c757d;
        }
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.875rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">

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

            <!-- Header Card -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1">{{ $student->full_name }}</h3>
                            <p class="text-muted mb-0">Student ID: #{{ $student->id }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-primary">
                                <i class="mdi mdi-pencil"></i> Edit Student
                            </a>
                            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Personal Information -->
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="mdi mdi-account"></i> Personal Information</h5>
                        </div>
                        <div class="card-body">
                            @if($student->profile_image)
                                <div class="text-center mb-3">
                                    <img src="{{ asset($student->profile_image) }}" alt="{{ $student->full_name }}" class="student-avatar">
                                </div>
                            @endif

                            <div class="mb-2">
                                <span class="info-label">First Name:</span>
                                <p>{{ $student->first_name }}</p>
                            </div>

                            @if($student->middle_name)
                            <div class="mb-2">
                                <span class="info-label">Middle Name:</span>
                                <p>{{ $student->middle_name }}</p>
                            </div>
                            @endif

                            <div class="mb-2">
                                <span class="info-label">Last Name:</span>
                                <p>{{ $student->last_name }}</p>
                            </div>

                            <div class="mb-2">
                                <span class="info-label">Email:</span>
                                <p><a href="mailto:{{ $student->email }}">{{ $student->email }}</a></p>
                            </div>

                            @if($student->phone)
                            <div class="mb-2">
                                <span class="info-label">Phone:</span>
                                <p>{{ $student->phone }}</p>
                            </div>
                            @endif

                            @if($student->cnic)
                            <div class="mb-2">
                                <span class="info-label">CNIC:</span>
                                <p>{{ $student->cnic }}</p>
                            </div>
                            @endif

                            @if($student->dob)
                            <div class="mb-2">
                                <span class="info-label">Date of Birth:</span>
                                <p>{{ $student->dob->format('d M, Y') }} ({{ $student->dob->age }} years)</p>
                            </div>
                            @endif

                            @if($student->gender)
                            <div class="mb-2">
                                <span class="info-label">Gender:</span>
                                <p>{{ ucfirst($student->gender) }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Family & Address Information -->
                <div class="col-md-8 mb-3">
                    <div class="card h-100">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="mdi mdi-home-account"></i> Family & Address Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if($student->father_name)
                                <div class="col-md-6 mb-3">
                                    <span class="info-label">Father's Name:</span>
                                    <p>{{ $student->father_name }}</p>
                                </div>
                                @endif

                                @if($student->mother_name)
                                <div class="col-md-6 mb-3">
                                    <span class="info-label">Mother's Name:</span>
                                    <p>{{ $student->mother_name }}</p>
                                </div>
                                @endif

                                @if($student->address)
                                <div class="col-md-12 mb-3">
                                    <span class="info-label">Address:</span>
                                    <p>{{ $student->address }}</p>
                                </div>
                                @endif

                                @if($student->remarks)
                                <div class="col-md-12 mb-3">
                                    <span class="info-label">Remarks:</span>
                                    <p>{{ $student->remarks }}</p>
                                </div>
                                @endif

                                <div class="col-md-6 mb-3">
                                    <span class="info-label">Created At:</span>
                                    <p>{{ $student->created_at->format('d M, Y h:i A') }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <span class="info-label">Last Updated:</span>
                                    <p>{{ $student->updated_at->format('d M, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrollments Section -->
            <div class="card mt-3">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="mdi mdi-school"></i> Program Enrollments</h5>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addEnrollmentModal">
                        <i class="mdi mdi-plus"></i> Add Enrollment
                    </button>
                </div>
                <div class="card-body">
                    @if($student->enrollments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Roll No</th>
                                        <th>Registration No</th>
                                        <th>Program</th>
                                        <th>Class/Section</th>
                                        <th>Admission Date</th>
                                        <th>Status</th>
                                        <th>Certificate Status</th>
                                        <th>CGPA</th>
                                        <th>Grade</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($student->enrollments as $index => $enrollment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $enrollment->roll_no }}</strong></td>
                                        <td>{{ $enrollment->registration_no ?? '-' }}</td>
                                        <td>{{ $enrollment->program ? $enrollment->program->name : '-' }}</td>
                                        <td>{{ $enrollment->classSection ? $enrollment->classSection->name : '-' }}</td>
                                        <td>{{ $enrollment->admission_date ? $enrollment->admission_date->format('d M, Y') : '-' }}</td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'admitted' => 'primary',
                                                    'active' => 'success',
                                                    'passed_out' => 'info',
                                                    'dropped' => 'warning',
                                                    'expelled' => 'danger',
                                                    'transferred' => 'secondary'
                                                ];
                                                $color = $statusColors[$enrollment->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}">{{ ucfirst($enrollment->status) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $certColors = [
                                                    'pending' => 'warning',
                                                    'generated' => 'info',
                                                    'issued' => 'success',
                                                    'revoked' => 'danger'
                                                ];
                                                $certColor = $certColors[$enrollment->certificate_status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $certColor }}">{{ ucfirst($enrollment->certificate_status) }}</span>
                                        </td>
                                        <td>{{ $enrollment->cgpa ?? '-' }}</td>
                                        <td>{{ $enrollment->grade ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-danger delete-enrollment-btn" data-id="{{ $enrollment->id }}">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="mdi mdi-information"></i> No enrollments found. Click "Add Enrollment" to enroll this student in a program.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Add Enrollment Modal -->
    <div class="modal fade" id="addEnrollmentModal" tabindex="-1" aria-labelledby="addEnrollmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addEnrollmentModalLabel">
                        <i class="mdi mdi-plus-circle"></i> Add New Enrollment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="enrollmentForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="program_id" class="form-label">Program <span class="text-danger">*</span></label>
                                <select class="form-control form-select" id="program_id" name="program_id" required>
                                    <option value="">Select Program</option>
                                    @foreach($programs as $program)
                                        <option value="{{ $program->id }}">{{ $program->name }} ({{ $program->code }})</option>
                                    @endforeach
                                </select>
                                <span class="error" id="program_id_error"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="class_id" class="form-label">Class/Section</label>
                                <select class="form-control form-select" id="class_id" name="class_id">
                                    <option value="">Select Class/Section</option>
                                    @foreach($classSections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }} - {{ $section->session }}</option>
                                    @endforeach
                                </select>
                                <span class="error" id="class_id_error"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="roll_no" class="form-label">Roll Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="roll_no" name="roll_no" required placeholder="e.g., 2024-CS-001">
                                <span class="error" id="roll_no_error"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="registration_no" class="form-label">Registration Number</label>
                                <input type="text" class="form-control" id="registration_no" name="registration_no" placeholder="e.g., REG-2024-001">
                                <span class="error" id="registration_no_error"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="admission_date" class="form-label">Admission Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="admission_date" name="admission_date" required>
                                <span class="error" id="admission_date_error"></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control form-select" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="admitted">Admitted</option>
                                    <option value="active" selected>Active</option>
                                    <option value="passed_out">Passed Out</option>
                                    <option value="dropped">Dropped</option>
                                    <option value="expelled">Expelled</option>
                                    <option value="transferred">Transferred</option>
                                </select>
                                <span class="error" id="status_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="mdi mdi-close"></i> Close
                        </button>
                        <button type="submit" class="btn btn-primary" id="saveEnrollmentBtn">
                            <i class="mdi mdi-content-save"></i> Save Enrollment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            // Add Enrollment Form Submit
            $('#enrollmentForm').on('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                $('.error').text('');
                $('.form-control').removeClass('is-invalid');

                $('#saveEnrollmentBtn').prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Saving...');

                $.ajax({
                    url: "{{ route('admin.students.enrollments.store', $student->id) }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.success) {
                            $('#addEnrollmentModal').modal('hide');
                            $('#enrollmentForm')[0].reset();
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if(xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + '_error').text(value[0]);
                                $('#' + key).addClass('is-invalid');
                            });
                        } else {
                            alert(xhr.responseJSON.message || 'An error occurred');
                        }
                    },
                    complete: function() {
                        $('#saveEnrollmentBtn').prop('disabled', false).html('<i class="mdi mdi-content-save"></i> Save Enrollment');
                    }
                });
            });

            // Delete Enrollment
            $('.delete-enrollment-btn').on('click', function() {
                if(!confirm('Are you sure you want to delete this enrollment?')) {
                    return;
                }

                let enrollmentId = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.students.enrollments.destroy', ['student' => $student->id, 'enrollment' => '__ID__']) }}".replace('__ID__', enrollmentId),
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if(response.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        alert('Error deleting enrollment');
                    }
                });
            });

            // Reset modal on close
            $('#addEnrollmentModal').on('hidden.bs.modal', function() {
                $('#enrollmentForm')[0].reset();
                $('.error').text('');
                $('.form-control').removeClass('is-invalid');
            });
        });
    </script>
@endpush

