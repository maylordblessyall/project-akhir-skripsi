@extends('inpatient')

@section('title')
Select Payment Method
@endsection

@section('content')
<h2>Select Payment Method for Admission ID: {{ $admission->id }}</h2>

<form action="{{ route('billing.selectPaymentMethod', $admission->id) }}" method="POST">
    @csrf
    <div>
        <label for="cash">Cash:</label>
        <input type="radio" id="cash" name="payment_method" value="cash" required>
    </div>
    <div>
        <label for="e_cash">E-Cash:</label>
        <input type="radio" id="e_cash" name="payment_method" value="e_cash" required>
    </div>
    <div>
        <button type="submit" class="btn btn-primary">Proceed to Payment</button>
    </div>
</form>
@endsection