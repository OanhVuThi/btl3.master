<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;

class ProductExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $products =Product::all();
        foreach ($products as $product) {
            $order[] = array(
                '0' => $product->id,
                '1' => $product->name,
                '2' => $product->count,
                '3' => $product->created_at,
                '4' => $product->updated_at,
            );
        }
       return (collect($order));
   }

    public function headings(): array
    {
        return [
            'STT',
            'Tên sản phẩm ',
            'số lượng',
            'Ngày tạo',
            'Ngày cập nhật',
        ];
    }
}
