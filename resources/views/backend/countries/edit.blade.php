@extends('layouts.backend_master')

@section('admin_contents')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Country: {{ $country->name }}</h5>
        <a href="{{ route('countries.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <form action="{{ route('countries.update', $country->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Country Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $country->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">ISO2 Code</label>
                    <input type="text" name="iso2" class="form-control @error('iso2') is-invalid @enderror" value="{{ old('iso2', $country->iso2) }}" maxlength="2">
                    @error('iso2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">ISO3 Code</label>
                    <input type="text" name="iso3" class="form-control @error('iso3') is-invalid @enderror" value="{{ old('iso3', $country->iso3) }}" maxlength="3">
                    @error('iso3') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Phone Code</label>
                    <input type="text" name="phone_code" class="form-control @error('phone_code') is-invalid @enderror" value="{{ old('phone_code', $country->phone_code) }}">
                    @error('phone_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Currency Code</label>
                    <input type="text" name="currency" class="form-control @error('currency') is-invalid @enderror" value="{{ old('currency', $country->currency) }}">
                    @error('currency') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Currency Symbol</label>
                    <input type="text" name="currency_symbol" class="form-control @error('currency_symbol') is-invalid @enderror" value="{{ old('currency_symbol', $country->currency_symbol) }}">
                    @error('currency_symbol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12">
                    <label class="form-label">Capital</label>
                    <input type="text" name="capital" class="form-control @error('capital') is-invalid @enderror" value="{{ old('capital', $country->capital) }}">
                    @error('capital') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Update Country
            </button>
        </div>
    </form>
</div>
@endsection