<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            "customers" => Customer::when(request()->q, function ($query) {
                $query->where("name", "LIKE", "%" . \request()->q . "%");
            })->latest()->paginate(5),
        ];
        return Inertia::render("Apps/Customers/Index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Apps/Customers/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $values = $this->validate($request, [
            'name' => 'required',
            'no_telp' => 'required|unique:customers',
            'address' => 'required'
        ]);

        Customer::create($values);
        return \redirect()->route("apps.customers.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return Inertia::render("Apps/Customers/Edit", [
            "customer" => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $values = $this->validate($request, [
            'name' => 'required',
            'no_telp' => 'required|unique:customers',
            'address' => 'required'
        ]);

        $customer->update($values);
        return \redirect()->route("apps.customers.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('apps.customers.index');
    }
}
