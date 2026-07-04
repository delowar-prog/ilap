@extends('layouts.backend_master')

@section('admin_contents')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Create Country</h5>
        <a href="{{ route('countries.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="{{ route('countries.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Country Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">ISO2 Code</label>
                    <input type="text" name="iso2" class="form-control @error('iso2') is-invalid @enderror" value="{{ old('iso2') }}" maxlength="2" placeholder="BD">
                    @error('iso2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">ISO3 Code</label>
                    <input type="text" name="iso3" class="form-control @error('iso3') is-invalid @enderror" value="{{ old('iso3') }}" maxlength="3" placeholder="BGD">
                    @error('iso3') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Phone Code</label>
                    <input type="text" name="phone_code" class="form-control @error('phone_code') is-invalid @enderror" value="{{ old('phone_code') }}" placeholder="+880">
                    @error('phone_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Currency Code</label>
                    <input type="text" name="currency" class="form-control @error('currency') is-invalid @enderror" value="{{ old('currency') }}" placeholder="BDT">
                    @error('currency') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Currency Symbol</label>
                    <input type="text" name="currency_symbol" class="form-control @error('currency_symbol') is-invalid @enderror" value="{{ old('currency_symbol') }}" placeholder="৳">
                    @error('currency_symbol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Capital</label>
                    <input type="text" name="capital" class="form-control @error('capital') is-invalid @enderror" value="{{ old('capital') }}">
                    @error('capital') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Save Country
            </button>
        </div>
    </form>
</div>
@endsection