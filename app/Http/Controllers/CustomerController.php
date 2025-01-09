<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // public function index(Request $request)
    // {
    //     $search = $request->input('search');
    //     $customers = Customer::query()
    //        ->when($search, function ($query) use ($search) {
    //          return $query->where('name', 'like', '%' . $search . '%');
    //        })
    //        ->paginate(10);

    //     return view('customers.index', compact('customers'));
    // }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter');

        $customers = Customer::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($filter, function ($query) use ($filter) {
                return $query->orderBy('name', $filter);
            })
           ->paginate(10);


        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'phone' => 'nullable',
            'address' => 'nullable'
        ]);
         try {
             Customer::create($request->all());
              return redirect()->route('customers.index')
                 ->with('success', 'Customer created successfully.');
          } catch (\Illuminate\Validation\ValidationException $e) {
               return redirect()->back()->withErrors($e->errors())->withInput();
          }
    }

    public function show(Customer $customer) {
      return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
             'name' => 'required',
             'email' => 'required|email|unique:customers,email,' . $customer->id,
             'phone' => 'nullable',
             'address' => 'nullable'
         ]);
        $customer->update($request->all());
        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully');
    }


    public function destroy(Customer $customer)
    {
       $customer->delete();
       return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully');
    }
}