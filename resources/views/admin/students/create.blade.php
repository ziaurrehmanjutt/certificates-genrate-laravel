@extends('admin.layouts.app')

@section('title', 'Add New Student')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add New Student</h4>
                    <p class="text-muted">This form will be implemented later</p>

                    <div class="alert alert-info">
                        <i class="mdi mdi-information"></i>
                        Student creation form coming soon...
                    </div>

                    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
