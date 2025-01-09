@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Customers</h2>
          <div class="mb-3 d-flex justify-content-between align-items-center">
           <form action="{{ route('customers.index') }}" method="GET" class="d-inline-block">
                <div class="input-group">
                  <input type="text" name="search" class="form-control" placeholder="Search customers..." value="{{ request('search') }}">
                  <button type="submit" class="btn btn-outline-secondary">Search</button>
                </div>
            </form>

            <form action="{{ route('customers.index') }}" method="GET" class="d-inline-block">
                  <select name="filter" class="form-select" onchange="this.form.submit()">
                       <option value="">Filter by Name</option>
                      <option value="asc" {{ request('filter') === 'asc' ? 'selected' : ''}}>A-Z</option>
                      <option value="desc" {{ request('filter') === 'desc' ? 'selected' : ''}}>Z-A</option>
                  </select>
              </form>
         </div>
        <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">Add Customer</a>

        @if(session('success'))
             <div class="alert alert-success">
                {{ session('success') }}
             </div>
          @endif

        <table class="table">
            <thead>
            <tr>
                 <th>Name</th>
                 <th>Email</th>
                 <th>Phone</th>
                <th>Actions</th>
           </tr>
            </thead>
            <tbody>
            @if($customers->count() > 0)
            @foreach($customers as $customer)
                 <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                     <td>
                         <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info">View</a>
                         <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-primary">Edit</a>
                          <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                             @csrf
                             @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger"
                                      onclick="return confirm('Are you sure?')">Delete</button>
                          </form>
                     </td>
                </tr>
           @endforeach
           @else
              <tr>
                 <td colspan="4">No customers found.</td>
               </tr>
            @endif
            </tbody>
        </table>
        {{ $customers->appends(request()->query())->links() }}
    </div>
@endsection