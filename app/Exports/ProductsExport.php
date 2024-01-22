<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Fetch the data from the database
        $data = Product::select('product_name', 'price', 'size_type', 'small_quantity', 'medium_quantity', 'large_quantity', 'xlarge_quantity', 'xxlarge_quantity', 'xxxlarge_quantity', 'description')->get();

        // Transform the data to include header values
        $transformedData = $data->map(function ($item) {
            return [
                'Product Name' => $item->product_name,
                'Price' => $item->price,
                'Size Type' => $item->size_type,
                'Small Quantity' =>(string)$item->small_quantity !== null ? (string)$item->small_quantity : 0,
                'Medium Quantity' => (string)$item->medium_quantity !== null ?(string) $item->medium_quantity : 0,
                'Large Quantity' =>(string) $item->large_quantity !== null ?(string) $item->large_quantity : 0,
                'XLarge Quantity' =>(string) $item->xlarge_quantity !== null ?(string) $item->xlarge_quantity : 0,
                'XXLarge Quantity' =>(string) $item->xxlarge_quantity !== null ?(string) $item->xxlarge_quantity : 0,
                'XXXLarge Quantity' => (string)$item->xxxlarge_quantity !== null ?(string) $item->xxxlarge_quantity : 0,
                'Description' => $item->description,
            ];
        });

        return $transformedData;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Define the headers (column names)
        return [
            'Product Name',
            'Price',
            'Size Type',
            'Small Quantity',
            'Medium Quantity',
            'Large Quantity',
            'XLarge Quantity',
            'XXLarge Quantity',
            'XXXLarge Quantity',
            'Description',
        ];
    }
}
