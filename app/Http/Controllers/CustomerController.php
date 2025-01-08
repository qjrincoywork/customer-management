<?php

namespace App\Http\Controllers;

use App\Http\Requests\{CustomerCreateRequest, CustomerListRequest, CustomerUpdateRequest};
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

    /**
     * Display the specified customer.
     *
     * @param int $id The ID of the customer to retrieve.
     * @return JsonResponse A JSON response containing the customer data.
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->customer->findOrFail($id));
    }

    /**
     * Update the specified customer using the provided request data.
     *
     * @param CustomerUpdateRequest $request The request containing customer update data.
     * @return JsonResponse A JSON response indicating the success of the update operation.
     */
    public function update(CustomerUpdateRequest $request): JsonResponse
    {
        $this->customer->saveCustomer($request->all());

        return response()->json(['message' => __('Customer Updated.')], Response::HTTP_OK);
    }

    public function destroy(Customer $customer)
    {
        //
    }
}
