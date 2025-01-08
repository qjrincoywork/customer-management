<?php

namespace App\Models;

use App\Enums\SortOrder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact_number',
    ];

    /**
     * Retrieves a paginated list of customers based on the provided filter parameters.
     *
     * @param array $params An associative array of filter parameters, which may include:
     *                      - 'first_name': Filter by first name using a LIKE query.
     *                      - 'last_name': Filter by last name using a LIKE query.
     *                      - 'email': Filter by exact email match.
     *                      - 'contact_number': Filter by exact contact number match.
     *                      - 'sort_order': Optional sort order, defaults to descending.
     *                      - 'per_page': Optional number of results per page, defaults to a configured limit.
     *
     * @return LengthAwarePaginator A paginator instance containing the filtered list of customers.
     */
    public function getCustomers(array $params): LengthAwarePaginator
    {
        $customers = $this
            ->when(isset($params['first_name']), function ($query) use ($params) {
                $query->where('first_name', 'LIKE', '%' . $params['first_name'] . '%');
            })
            ->when(isset($params['last_name']), function ($query) use ($params) {
                $query->where('last_name', 'LIKE', '%' . $params['last_name'] . '%');
            })
            ->when(isset($params['email']), function ($query) use ($params) {
                $query->where('email', $params['email']);
            })
            ->when(isset($params['contact_number']), function ($query) use ($params) {
                $query->where('contact_number', $params['contact_number']);
            })
            ->orderBy(
                $params['sort_order'] ?? SortOrder::DESC
            )
            ->paginate($params['per_page'] ?? config('customers.default_limit'));

        return $customers;
    }
}
