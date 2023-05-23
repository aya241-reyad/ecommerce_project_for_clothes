<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;



class ProductSearch extends Component
{
        public $search = '';
            use WithPagination;

    protected $paginationTheme = 'bootstrap';


    public function render()
    {
                $products = Product::where('title', 'LIKE', '%' . $this->search . '%')->paginate(10);

        return view('livewire.products.product-search',['products'=>$products]);
    }
}
