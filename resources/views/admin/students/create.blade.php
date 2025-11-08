@extends('admin.layouts.app')

@section('title', 'Add New Student')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/select2/select2.min.css') }}">
    <style>
        .error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .form-control.error, .form-select.error {
            border-color: #dc3545;
        }
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
        .preview-image {
            max-width: 150px;
            max-height: 150px;
            margin-top: 10px;
            display: none;
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

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-alert-circle"></i> <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="card-title mb-0">Add New Student</h4>
                            <p class="text-muted">Fill in the student information below</p>
                        </div>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> Back to List
                        </a>
                    </div>

                    <form id="studentForm" action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Personal Information -->
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="mdi mdi-account"></i> Personal Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="first_name" class="form-label required-field">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                               value="{{ old('first_name') }}" placeholder="Enter first name">
                                        @error('first_name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="middle_name" class="form-label">Middle Name</label>
                                        <input type="text" class="form-control" id="middle_name" name="middle_name"
                                               value="{{ old('middle_name') }}" placeholder="Enter middle name (optional)">
                                        @error('middle_name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="last_name" class="form-label required-field">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                               value="{{ old('last_name') }}" placeholder="Enter last name">
                                        @error('last_name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="email" class="form-label required-field">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="{{ old('email') }}" placeholder="student@example.com">
                                        @error('email')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                               value="{{ old('phone') }}" placeholder="03XX-XXXXXXX">
                                        @error('phone')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="cnic" class="form-label">CNIC</label>
                                        <input type="text" class="form-control" id="cnic" name="cnic"
                                               value="{{ old('cnic') }}" placeholder="XXXXX-XXXXXXX-X" maxlength="15">
                                        @error('cnic')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="dob" name="dob"
                                               value="{{ old('dob') }}">
                                        @error('dob')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="gender" class="form-label required-field">Gender</label>
                                        <select class="form-control form-select" id="gender" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="profile_image" class="form-label">Profile Image</label>
                                        <input type="file" class="form-control" id="profile_image" name="profile_image"
                                               accept="image/*">
                                        <img id="imagePreview" class="preview-image img-thumbnail" alt="Preview">
                                        @error('profile_image')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Family Information -->
                        <div class="card mb-3">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="mdi mdi-account-multiple"></i> Family Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="father_name" class="form-label">Father's Name</label>
                                        <input type="text" class="form-control" id="father_name" name="father_name"
                                               value="{{ old('father_name') }}" placeholder="Enter father's name">
                                        @error('father_name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="mother_name" class="form-label">Mother's Name</label>
                                        <input type="text" class="form-control" id="mother_name" name="mother_name"
                                               value="{{ old('mother_name') }}" placeholder="Enter mother's name">
                                        @error('mother_name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address" name="address" rows="3"
                                                  placeholder="Enter complete address">{{ old('address') }}</textarea>
                                        @error('address')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="card mb-3">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0"><i class="mdi mdi-information"></i> Additional Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <textarea class="form-control" id="remarks" name="remarks" rows="3"
                                                  placeholder="Any additional notes or remarks">{{ old('remarks') }}</textarea>
                                        @error('remarks')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                    <i class="mdi mdi-content-save"></i> Save Student
                                </button>
                                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="mdi mdi-close"></i> Cancel
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {

            // Image preview
            $('#profile_image').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result).show();
                    }
                    reader.readAsDataURL(file);
                } else {
                    $('#imagePreview').hide();
                }
            });

            // CNIC formatting
            $('#cnic').on('input', function() {
                let value = $(this).val().replace(/[^0-9]/g, '');
                if (value.length > 5) {
                    value = value.slice(0, 5) + '-' + value.slice(5);
                }
                if (value.length > 13) {
                    value = value.slice(0, 13) + '-' + value.slice(13, 14);
                }
                $(this).val(value);
            });

            // Phone formatting
            $('#phone').on('input', function() {
                let value = $(this).val().replace(/[^0-9]/g, '');
                if (value.length > 4) {
                    value = value.slice(0, 4) + '-' + value.slice(4, 11);
                }
                $(this).val(value);
            });

            // jQuery Validation
            $('#studentForm').validate({
                rules: {
                    first_name: {
                        required: true,
                        minlength: 2,
                        maxlength: 100
                    },
                    middle_name: {
                        maxlength: 100
                    },
                    last_name: {
                        required: true,
                        minlength: 2,
                        maxlength: 100
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 150
                    },
                    phone: {
                        minlength: 11,
                        maxlength: 12,
                        digits: false
                    },
                    cnic: {
                        minlength: 15,
                        maxlength: 15
                    },
                    dob: {
                        date: true
                    },
                    gender: {
                        required: true
                    },
                    profile_image: {
                        extension: "jpg|jpeg|png|gif",
                        filesize: 2048000 // 2MB
                    },
                    father_name: {
                        maxlength: 150
                    },
                    mother_name: {
                        maxlength: 150
                    },
                    address: {
                        maxlength: 500
                    },
                    remarks: {
                        maxlength: 1000
                    }
                },
                messages: {
                    first_name: {
                        required: "Please enter first name",
                        minlength: "First name must be at least 2 characters",
                        maxlength: "First name cannot exceed 100 characters"
                    },
                    last_name: {
                        required: "Please enter last name",
                        minlength: "Last name must be at least 2 characters",
                        maxlength: "Last name cannot exceed 100 characters"
                    },
                    email: {
                        required: "Please enter email address",
                        email: "Please enter a valid email address",
                        maxlength: "Email cannot exceed 150 characters"
                    },
                    phone: {
                        minlength: "Phone number must be at least 11 digits",
                        maxlength: "Phone number cannot exceed 12 characters"
                    },
                    cnic: {
                        minlength: "CNIC must be in format: XXXXX-XXXXXXX-X",
                        maxlength: "CNIC must be in format: XXXXX-XXXXXXX-X"
                    },
                    dob: {
                        date: "Please enter a valid date"
                    },
                    gender: {
                        required: "Please select gender"
                    },
                    profile_image: {
                        extension: "Please upload a valid image file (jpg, jpeg, png, gif)",
                        filesize: "File size must be less than 2MB"
                    }
                },
                errorClass: "error",
                errorElement: "span",
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass('error');
                },
                unhighlight: function(element) {
                    $(element).removeClass('error');
                },
                submitHandler: function(form) {
                    $('#submitBtn').prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Saving...');
                    form.submit();
                }
            });

            // Custom file size validation method
            $.validator.addMethod('filesize', function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param);
            }, 'File size must be less than {0} bytes');

        });
    </script>
@endpush

