@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Register New Voter</h2>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card p-4">
            <form action="{{ route('voters.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- First Name -->
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label fw-bold">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control" required>
                        @error('first_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="col-md-6 mb-3">
                        <label for="last_name" class="form-label fw-bold">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-control" required>
                        @error('last_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Date of Birth -->
                    <div class="col-md-6 mb-3">
                        <label for="dob" class="form-label fw-bold">Date of Birth <span class="text-danger">*</span></label>
                        <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob') }}" required>
                        @error('dob')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mobile -->
                    <div class="col-md-6 mb-3">
                        <label for="mobile" class="form-label fw-bold">Mobile <span class="text-danger">*</span></label>
                        <input type="tel" name="mobile" class="form-control" value="{{ old('mobile') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"  maxlength="10" id="mobile" pattern="[1-9]{1}[0-9]{9}" required>
                        @error('mobile')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label fw-bold">Address <span class="text-danger">*</span></label>
                        <textarea name="address" id="address" class="form-control" rows="2" required>{{old('address')}}</textarea>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Taluk -->
                    <div class="col-md-6 mb-3">
                        <label for="taluk" class="form-label fw-bold">Taluk <span class="text-danger">*</span></label>
                        <select name="taluk" id="taluk" class="form-control" required>
                            <option value="">Select State</option>
                            @foreach ($taluks as $taluk)
                                <option value="{{ $taluk }}" {{ old('taluk') == $taluk ? 'selected' : '' }}>
                                    {{ $taluk }}
                                </option>
                            @endforeach
                        </select>
                        @error('taluk')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- District -->
                    <div class="col-md-6 mb-3">
                        <label for="district" class="form-label fw-bold">District <span class="text-danger">*</span></label>
                        <select name="district" id="district" class="form-control" required>
                            <option value="">Select District</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district }}" {{ old('district') == $district ? 'selected' : '' }}>
                                    {{ $district }}
                                </option>
                            @endforeach
                        </select>
                        @error('district')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- State -->
                    <div class="col-md-12 mb-3">
                        <label for="state" class="form-label fw-bold">State <span class="text-danger">*</span></label>
                        <select name="state" id="state" class="form-control" required>
                            <option value="">Select State</option>
                            @foreach ($states as $state)
                            <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>
                                {{ $state }}
                                </option>
                            @endforeach
                        </select>
                        @error('state')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-center gap-3">
                    <button type="submit" class="btn btn-primary px-5">Register Voter</button>
                    <a href="{{ route('voters.index') }}" class="btn btn-secondary px-5">Cancel</a>

                </div>

            </form>
        </div>
    </div>
@endsection
