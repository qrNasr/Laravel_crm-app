<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Http\Request;

class ContactController extends Controller
{
   public function index(Customer $customer)
    {
       $contacts = $customer->contacts;

       return view('contacts.index', compact('contacts','customer'));
    }

    public function create(Customer $customer)
    {
       return view('contacts.create', compact('customer'));
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
    public function edit(Customer $customer, Contact $contact)
    {
      return view('contacts.edit', compact('contact', 'customer'));
    }


    public function update(Request $request, Customer $customer, Contact $contact)
    {
        $request->validate([
           'name' => 'required',
           'email' => 'required|email|unique:contacts,email,' . $contact->id,
           'phone' => 'nullable',
           'job_title' => 'nullable'
        ]);
         $contact->update($request->all());

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Contact updated successfully');
    }


    public function destroy(Customer $customer, Contact $contact)
    {
       $contact->delete();
       return redirect()->route('customers.show', $customer)
           ->with('success', 'Contact deleted successfully');
    }

}