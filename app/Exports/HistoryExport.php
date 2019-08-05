<?php

namespace App\Exports;

use App\depotProduct;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoryExport implements FromCollection, WithHeadings
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $historys = depotProduct::where('depot_id', '=', Auth::id())->get();
        foreach ($historys as $history) {
            $order[] = array(
                '1' => $history->product_id,
                '2' => $history->count,
                '3' => $history->depot_id,
            );
        }
        return (collect($order));
    }

    public function headings(): array
    {
        return [
            'ID sản Phẩm',
            'Số Lượng',
            'ID kho',        
        ];
    }
}
