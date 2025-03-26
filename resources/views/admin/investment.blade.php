@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Investment</h1>
    <form action="{{ route('admin.investments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_id">User</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="investment_type">Investment Type</label>
            <select name="investment_type" class="form-control" required>
                <option value="Stocks">Stocks</option>
                <option value="Bonds">Bonds</option>
                <option value="Mutual Funds">Mutual Funds</option>
                <option value="Real Estate">Real Estate</option>
            </select>
        </div>
        <div class="form-group">
            <label for="investment_amount">Investment Amount</label>
            <input type="text" name="investment_amount" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="number_of_units">Number of Units</label>
            <input type="text" name="number_of_units" class="form-control">
        </div>
        <div class="form-group">
            <label for="interest_rate">Interest Rate (%)</label>
            <input type="text" name="interest_rate" class="form-control">
        </div>
        <div class="form-group">
            <label for="investment_date">Investment Date</label>
            <input type="date" name="investment_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
