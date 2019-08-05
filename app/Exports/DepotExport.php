<?php

namespace App\Exports;

use App\User;
use App\Depot;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepotExport implements FromCollection, WithHeadings
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $depots = Depot::all();
        $user = User::all();
        foreach ($depots as $depot) {
            $order[] = array(
                '0' => $depot->id,
                '1' => $depot->name,
                '2' => $depot->user ? $depot->user->name : '-',
                '3' => $depot->created_at,
                '4' => $depot->updated_at,
            );
        }
        return (collect($order));
    }

    public function headings(): array
    {
        return [
            'id kho',
            'Tên kho',
            'Người Quản Lý',
            'Ngày tạo',
            'Ngày cập nhật',
        ];
    }
}
