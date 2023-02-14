<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
		return $row;
		
        /* return new Customer([
            'name' => $row['name'],
            'email' => $row['email'],
			 'phone_number' => $row['phone'],
			  'store_id' => $store_id,
        ]); */
    }
}
