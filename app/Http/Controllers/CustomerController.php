<?php

namespace App\Http\Controllers;

use App\Http\Requests\{CustomerCreateRequest, CustomerListRequest};
use App\Models\Customer;
use Illuminate\Http\{JsonResponse, Request};
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    /**
     * Customer model instance.
     *
     * @var Customer
     */
    protected $customer;

    /**
     * CustomerController constructor.
     *
     * @param Customer $customer
     *
     * @return void
     */
    public function __construct(Customer $customer) {
        $this->customer = $customer;
    }

    /**
     * Handle the request to list customers.
     *
     * @param CustomerListRequest $request
     * @return JsonResponse
     */
    public function index(CustomerListRequest $request): JsonResponse
    {
        $customers = $this->customer->getCustomers($request->all());

        return response()->json($customers);
    }

    /**
     * Store a newly created customer in the database.
     *
     * @param CustomerCreateRequest $request The request object containing customer data.
     * @return JsonResponse A JSON response indicating the success of the operation.
     */
    public function store(CustomerCreateRequest $request): JsonResponse
    {
        $this->customer->saveCustomer($request->all());

        return response()->json(['message' => __('Customer Created.')], Response::HTTP_OK);
    }

    public function update(Request $request, Customer $customer)
    {
        //
    }

    public function destroy(Customer $customer)
    {
        //
    }
}
