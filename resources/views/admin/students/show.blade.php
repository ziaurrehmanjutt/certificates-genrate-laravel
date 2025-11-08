@extends('admin.layouts.app')

@section('title', 'View Student Details')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Student Details: {{ $student->full_name }}</h4>
                    <p class="text-muted">Student ID: #{{ $student->id }}</p>

                    <div class="alert alert-info">
                        <i class="mdi mdi-information"></i>
                        Student details view coming soon...
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Full Name</th>
                                <td>{{ $student->full_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $student->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $student->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>CNIC</th>
                                <td>{{ $student->cnic ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>{{ ucfirst($student->gender ?? '-') }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ $student->dob ? $student->dob->format('d M, Y') : '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
