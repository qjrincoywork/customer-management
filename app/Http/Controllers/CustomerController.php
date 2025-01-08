<?php

namespace App\Http\Controllers;

use App\Http\Requests\{CustomerListRequest};
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

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
}
