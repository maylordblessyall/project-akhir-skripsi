@extends('layouts.app')

@section('title', 'Create New User')

@section('content')
<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Inter', sans-serif;
    }
    .container {
        max-width: 600px;
        margin-top: 3rem;
    }
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        background: #ffffff;
    }
    .card-header {
        background: none;
        border-bottom: none;
        padding-bottom: 0;
    }
    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.75rem;
        border: 1px solid #ced4da;
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .error {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 0.75rem;
        border-radius: 8px;
        font-weight: 500;
        transition: background-color 0.2s ease-in-out;
    }
    .btn-primary:hover {
        background-color: #0056b3;
    }
    h2 {
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 576px) {
        .card {
            padding: 1.5rem;
        }
    }
</style>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Daftar Pengguna</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('user.register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Username:</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    @error('password_confirmation')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="user_type" class="form-label">Jenis Pengguna:</label>
                    <select id="user_type" name="user_type" class="form-select" required>
                        <option value="">-- Pilih Jenis Pengguna --</option>
                        @foreach(['admin', 'doctor', 'registration_staff', 'perawat'] as $type)
                            <option value="{{ $type }}" {{ old('user_type') == $type ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $type)) }}</option>
                        @endforeach
                    </select>
                    @error('user_type')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection