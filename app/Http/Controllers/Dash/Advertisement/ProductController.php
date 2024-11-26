<?php

namespace App\Http\Controllers\Dash\Advertisement;

use App\Http\Controllers\Controller;
use App\Models\AdvCategory;
use App\Models\Advertisement;
use App\Models\City;
use App\Models\Province;
use App\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


class ProductController extends Controller
{
    public ProductRepository $productRepository;

    public function __construct(ProductRepository $basicRepository)
    {
        $this->productRepository = $basicRepository;
    }

    public function create()
    {
        $categories = AdvCategory::tree()->get()->toTree();
        $provinces = Province::all();
        $cities = City::all();
        return view('admin_end.advertisement.create')
            ->with(['provinces' => $provinces, 'categories' => $categories, 'cities' => $cities]);
    }


    public function store(ProductRequest $request)
    {
        try {


            // return $request;


            // save images path in database
            $images_path = [];
            if ($request->has('images')) {
                foreach ($request->input('images', []) as $file) {
                    $images_path [] = 'app/public/uploads/' . $file;
                }
            } else {
                $images_path = [];
            }


            $this->productRepository->store($request, $images_path);
            session()->flash('success', __('messages.New_record_saved_successfully'));
            return redirect()->route('admin.adv.index');

        } catch (\Exception $ex) {
            return  $ex->getMessage();
            return view('errors_custom.model_store_error');
        }
    }

    public function edit(Request $request)
    {





        try {

            // $category_ids[] = '';
            // foreach ($product->categories as $cat)
            // {
            //    $category_ids[] = $cat->id;
            // }
            // $categories =  '';


            $adv = Advertisement::findOrFail($request->adv);
            $categories = AdvCategory::tree()->get()->toTree();
            $provinces = Province::all();
            $cities = City::where('province_id',$adv->province_id)->get();
            $advGroups = AdvCategory::find($adv->adv_category_id)->ancestorsAndSelf;

            $current_adv_group = [];
            foreach ($advGroups as $group){
                $current_adv_group[] = $group->title;
            }
            $current_adv_group = implode(" > ",array_reverse($current_adv_group)) ;

            return view('admin_end.advertisement.edit')
                ->with(['adv' => $adv, 'categories' => $categories , 'cities' => $cities,
                        'provinces' => $provinces,'advGroups' => $current_adv_group]);

        } catch (\Exception $ex) {
            //return  $ex->getMessage();
            return view('errors_custom.model_not_found');
        }

    }

    public function update(Request $request)
    {

        $request->validate([
            'advGroup' => ['required'],
            'title' => ['required',Rule::unique('products')->ignore($request->adv),'min:2','max:100'],
            'province' => ['required'],
            'city' => ['required'],
            'description' => ['nullable', 'min:2', 'string', 'max:5000'],
            'seo_desc' => ['nullable', 'min:2', 'string', 'max:150'],
            'keywords' => ['required'],
            'website' => ['url:https'],
            'owner' => ['required','min:6','max:128'],
            'advertiser_phone' => ['required','digits_between:2,20','numeric'],
            'email' => ['email']
        ]);



        try {

            // save images path in database
            //            $images_path = [];
            //            if ($request->has('images')) {
            //                foreach ($request->input('images', []) as $file) {
            //                    $images_path [] = 'app/public/uploads/' . $file;
            //                }
            //            } else {
            //                $images_path = [];
            //            }

            $this->productRepository->update($request);
            session()->flash('success', __('messages.The_update_was_completed_successfully'));
            return redirect()->route('admin.adv.index');

        } catch (\Exception $ex) {
            // return $ex->getMessage();
            return view('errors_custom.model_store_error');
        }
    }


    public function storeAdvImages(Request $request)
    {

        // return $request->all();

        $path = storage_path('app/public/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }


}
