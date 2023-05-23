<?php

namespace App\Http\Controllers\api;

use App\Models\Card;
use App\Models\Offer;
use App\Models\Slider;
use App\Models\SubCat;
use App\helpers\helper;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CardsResource;
use App\Http\Resources\OfferResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SettingResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductsResource;
use App\Http\Resources\ProducCatResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AllProductResource;

class MainController extends Controller
{
    public function __construct()
    {
        $this->helper = new helper();
    }

    public function getCards(Request $request)
    {
        $cards = CardsResource::collection(Card::latest()->get());
        return $this->helper->ResponseJson(1, __('apis.success'), [
            'cards' => $cards,

        ]);
    }

    public function categories(Request $request)
    {
        $categories = Category::where(function ($q) use ($request) {
            if ($request->category_id) {
                $q->where('id', $request->category_id);
            }
        })->with(['subCat' => function ($qy) use ($request) {
            if ($request->sub_id) {
                $qy->where('id', $request->sub_id)->where('category_id', $request->category_id);

            }
        }])
            ->get();
        return $this->helper->ResponseJson(1, __('apis.success'), [
            'categories' => CategoryResource::collection($categories),

        ]);

    }

    public function productByCat(Request $request)
    {
        $fields = $request->validate([
            'sub_id' => 'nullable',
        ]);
        $category = ProducCatResource::collection(SubCat::where(function ($q) use ($request) {
            if ($request->sub_id) {
                $q->where('id', $request->sub_id);
            }

        })->with(['products' => function ($products) use ($request) {
            if ($request->filter == 'rate') {
                $products->where('sub_category_id', $request->sub_id)->orderBy('avg_rate', 'ASC')->get();

            }
            if ($request->filter == 'low') {
                $products->where('sub_category_id', $request->sub_id)->orderBy('price_after_tax', 'ASC')->get();

            }

            $products->where('sub_category_id', $request->sub_id)->orderBy('id', 'DESC')->get();

        }])
                ->latest()->get());

        return $this->helper->ResponseJson(1, __('apis.success'), [
            'categories' => $category,

        ]);

    }

    public function setting(Request $request)
    {

        $settings = SettingResource::collection(Setting::latest()->get());
        return $this->helper->ResponseJson(1, __('apis.success'), [
            'settings' => $settings,

        ]);
    }

    public function offers(Request $request)
    {

        $offers = OfferResource::collection(Offer::where('status', 1)->latest()->get());
        return $this->helper->ResponseJson(1, __('apis.success'), [
            'offers' => $offers,

        ]);

    }

    public function sliders()
    {
        $sliders = SliderResource::collection(Slider::where('status', 1)->latest()->get());
        return $this->helper->ResponseJson(1, __('apis.success'), [
            'sliders' => $sliders,

        ]);
    }

    public function getProduct(Request $request)
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
        ];
        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return $this->helper->responseJson(0, $validation->errors()->first());
        }

        $product = new ProductsResource(Product::findOrFail($request->product_id));
        return $this->helper->ResponseJson(1, __('apis.success'), [
            'poducts' => $product,

        ]);

    }

    public function AllProducts()
    {
        $products = AllProductResource::collection(Product::paginate(8));
        return $this->helper->ResponseJson(1, __('apis.success'), [
            'products' => $products->response()->getData(true),

        ]);

    }

    public function featured()
    {
        $products = AllProductResource::collection(Product::where('is_featured', 1)->paginate(8));
        return $this->helper->ResponseJson(1, __('apis.success'), [
            'products' => $products->response()->getData(true),

        ]);

    }

}