<?php

namespace App\Imports;

use App\Models\Member;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MemberImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Member([
            'first_name'        => $row['first_name'],
            'last_name'         => $row['last_name'],
            'email'             => $row['email'],
            'status'            => $row['status'] == "Active" ? 1 : 0,
            'gender'            => $row['gender'] == "Male" ? 1 : 2,
            'member_since'      => new Carbon($row['member_since']),
            'date_of_birth'     => $row['date_of_birth'] ? new Carbon($row['date_of_birth']) : null,
            'phone'             => $row['phone'] ? $row['phone'] : null,
            'emergency_number'  => $row['emergency_number'] ? $row['emergency_number'] : null,
            'address'           => $row['address'] ? $row['address'] : null,
            'height'            => $row['height'] ? $row['height'] : null,
            'validity_date'     => $row['validity_date'] ? new Carbon($row['validity_date']) : null,
            'notes'             => $row['notes'] ? $row['notes'] : null,

        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
