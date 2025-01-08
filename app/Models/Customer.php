<?php

namespace App\Models;

use App\Enums\{SortOrder, SortTarget};
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    /**
     * Define an accessor for the 'created_at' attribute.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     *   The accessor that formats the 'created_at' timestamp to 'M d Y g:iA'.
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('M d Y g:iA'),
        );
    }

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
                $params['sort_target'] ?? SortTarget::DATE_CREATED,
                $params['sort_order'] ?? SortOrder::DESC,
            )
            ->paginate($params['per_page'] ?? config('customers.default_limit'));

        return $customers;
    }

    /**
     * Saves a customer record. If an 'id' is provided in the data array,
     * it updates the existing customer record with that ID. Otherwise,
     * it creates a new customer record.
     *
     * @param array $data An associative array containing customer data,
     *                    which may include an 'id' for updating an existing record.
     *
     * @return void
     */
    public function saveCustomer(array $data): void
    {
        if (isset($data['id'])) {
            $this->find($data['id'])->update($data);
        } else {
            $this->create($data);
        }
    }
}
