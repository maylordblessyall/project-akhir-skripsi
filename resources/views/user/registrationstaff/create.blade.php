@extends('layouts')

@section('title')
  Create New Staff
@endsection

@section('content')
<style>
/* Overall Form Container */
.container {
    max-width: 500px;
    margin: 40px auto; /* Center the form and add top margin */
    padding: 30px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* More prominent shadow */
    background-color: #fff; /* White background for contrast */
}

/* Heading */
h1 {
    text-align: center;
    margin-bottom: 25px;
    color: #333; 
    font-size: 2.5rem; /* Larger font size for the heading */
}

/* Form Groups */
.form-group {
    margin-bottom: 20px;
}

/* Labels */
label {
    font-weight: bold;
    display: block;
    margin-bottom: 8px;
}

/* Form Controls (Inputs, Textareas, Selects) */
.form-control,
.form-select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    box-sizing: border-box; /* Include padding and border in element's total width and height */
}

.form-control:focus,
.form-select:focus {
    border-color: #007bff; /* Highlight border on focus (Bootstrap blue) */
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Add a subtle box shadow on focus */
}

/* Submit Button */
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    width: 100%; /* Make the button full width */
    padding: 12px; /* Increase button padding */
}

.btn-primary:hover {
    background-color: #0069d9; /* Slightly darker on hover */
    border-color: #0062cc;
}

/* Alert (Error Messages) */
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.alert-danger ul {
    margin-bottom: 0;
}
</style>

  <h2>Create New Staff</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('registrationstaff.create') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="nik">NIK:</label>
      <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" required>
    </div>
    <div class="form-group">
      <label for="full_name">Full Name:</label>
      <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name') }}" required>
    </div>
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
    </div>
    <div class="form-group">
      <label for="phone_number">Phone Number:</label>
      <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number') }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Create staff</button>
  </form>
@endsection
