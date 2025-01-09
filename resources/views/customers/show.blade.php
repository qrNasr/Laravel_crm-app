@extends('layouts.app')

@section('content')
  <div class="container">
     <h2>Customer Details</h2>
     <div class="mb-3">
        <strong>Name:</strong> {{ $customer->name }}
     </div>
      <div class="mb-3">
          <strong>Email:</strong> {{ $customer->email }}
      </div>
       <div class="mb-3">
         <strong>Phone:</strong> {{ $customer->phone }}
      </div>
       <div class="mb-3">
          <strong>Address:</strong> {{ $customer->address }}
       </div>

     <div>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back to customers</a>
     </div>
    <hr/>
    <h2>Contacts</h2>
        <a href="{{ route('contacts.create', $customer->id) }}" class="btn btn-primary mb-3">Add Contact</a>

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
                  <th>Job Title</th>
                  <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($customer->contacts as $contact)
                <tr>
                   <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>{{ $contact->job_title }}</td>
                  <td>
                    <a href="{{ route('contacts.edit',[$customer->id, $contact->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                   <form action="{{ route('contacts.destroy', [$customer->id, $contact->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                         <button type="submit" class="btn btn-sm btn-danger"
                          onclick="return confirm('Are you sure?')">Delete</button>
                  </form>
                  </td>
             </tr>
              @endforeach
            </tbody>
        </table>
    <hr/>
    <h2>Interactions</h2>
    <a href="{{ route('interactions.create', $customer->id) }}" class="btn btn-primary mb-3">Add Interaction</a>
     @if(session('success'))
         <div class="alert alert-success">
              {{ session('success') }}
           </div>
        @endif
         <table class="table">
            <thead>
                <tr>
                   <th>Type</th>
                   <th>Notes</th>
                   <th>Interaction Date</th>
                    <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($customer->interactions as $interaction)
               <tr>
                  <td>{{ $interaction->type }}</td>
                   <td>{{ $interaction->notes }}</td>
                    <td>{{ $interaction->interaction_date }}</td>
                <td>
                  <a href="{{ route('interactions.edit',[$customer->id, $interaction->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('interactions.destroy', [$customer->id, $interaction->id]) }}" method="POST" class="d-inline">
                      @csrf
                      @method('DELETE')
                       <button type="submit" class="btn btn-sm btn-danger"
                           onclick="return confirm('Are you sure?')">Delete</button>
                   </form>
                </td>
             </tr>
              @endforeach
            </tbody>
        </table>
  </div>
@endsection