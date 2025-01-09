<?php

    namespace App\Http\Controllers;

    use App\Models\Customer;
    use App\Models\Interaction;
    use Illuminate\Http\Request;

    class InteractionController extends Controller
    {
        public function index(Customer $customer)
        {
           $interactions = $customer->interactions;

           return view('interactions.index', compact('interactions','customer'));
        }


        public function create(Customer $customer)
        {
             return view('interactions.create', compact('customer'));
        }

        public function store(Request $request, Customer $customer)
        {
           $request->validate([
               'type' => 'required',
                'notes' => 'nullable',
                'interaction_date' => 'required|date'
           ]);
           $customer->interactions()->create($request->all());

            return redirect()->route('customers.show', $customer)
               ->with('success', 'Interaction created successfully.');
        }


        public function edit(Customer $customer, Interaction $interaction)
        {
             return view('interactions.edit', compact('interaction', 'customer'));
        }


        public function update(Request $request, Customer $customer, Interaction $interaction)
        {
            $request->validate([
              'type' => 'required',
              'notes' => 'nullable',
              'interaction_date' => 'required|date'
            ]);
            $interaction->update($request->all());

            return redirect()->route('customers.show', $customer)
                ->with('success', 'Interaction updated successfully');
        }


        public function destroy(Customer $customer, Interaction $interaction)
        {
           $interaction->delete();
           return redirect()->route('customers.show', $customer)
               ->with('success', 'Interaction deleted successfully');
        }
    }