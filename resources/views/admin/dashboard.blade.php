@extends('admin.layouts.app')

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">

        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script>
        console.log("Dashboard page JS loaded");
    </script>
@endpush
