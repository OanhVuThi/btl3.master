<?php

namespace App\Exports;

use App\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $users = User::all();
        foreach ($users as $user) {
            $order[] = array(
                '0' => $user->id,
                '1' => $user->name,
                '2' => $user->email,
                '3' => $user->email_verified_at,
                '4' => $user->created_at,
                '5' => $user->updated_at,
            );
        }
        return (collect($order));
    }

    public function headings(): array
    {
        return [
            'id Người Quản Lý',
            'Tên',
            'Email',
            'email_verified_at',
            'Ngày tạo',
            'Ngày cập nhật',
        ];
    }
}
