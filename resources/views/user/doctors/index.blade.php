@extends('layouts')

@section('title')
  Doctors List
@endsection

@section('content')
<style>
    .container {
        max-width: 960px;
        margin: 0 auto; /* Center the container */
    }

    h1, h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem; 
        color: #212529;
        border-collapse: separate;
        border-spacing: 0 10px; 
    }

    .table th,
    .table td {
        padding: 15px;
        vertical-align: middle;
        text-align: center; /* Center text within cells */
        border-top: 1px solid #ddd;
    }

    .table th {
        background-color: #007bff; /* Blue background for headers */
        color: white;
        font-weight: 500; 
        border-top: 2px solid #007bff; /* Thicker top border for header */
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa; /* Light gray for odd rows */
    }

    .table .btn {
        margin: 2px;
        padding: 5px 10px; 
        font-size: 0.8rem; 
    }

    .table .btn-info {
        background-color: #00cc00; 
        border-color: #292b2c;
    }

    .table .btn-danger {
        background-color: #d9534f;
    }
    
    /* Pagination Styling */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
    }

    .pagination .page-item .page-link {
        border: 1px solid #ddd;
        color: #007bff;
    }
</style>
  <h1>Doctors</h1>

  @if (session('success'))
    <div class="alert alert-success" role="alert">
      {{ session('success') }}
    </div>
  @endif

  <a href="{{ route('doctors.create') }}" class="btn btn-success">Tambah Dokter</a>
  <br><br>

  @if (count($doctors) > 0)
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Specialization</th>
          <th>Email</th>
          <th>Phone Number</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($doctors as $doctor)
          <tr>
            <td>{{ $doctor->id }}</td>
            <td>{{ $doctor->full_name }}</td>
            <td>{{ $doctor->specialization }}</td>
            <td>{{ $doctor->email }}</td>
            <td>{{ $doctor->phone_number }}</td>
            <td>
              <a href="{{ route('doctors.edit', $doctor->id) }}" class="btn btn-sm btn-info">Edit</a>
              <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" style="display: inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this doctor?')">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p>No doctors found.</p>
  @endif
@endsection
