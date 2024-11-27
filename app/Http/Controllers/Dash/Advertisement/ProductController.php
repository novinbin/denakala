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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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


            // save images path in database
            $images_path = [];
            if ($request->has('images')) {
                foreach ($request->input('images', []) as $file) {
                    $images_path [] = '/uploads/' . $file;
                }
            }

            $this->productRepository->store($request, $images_path);
            session()->flash('success', __('messages.New_record_saved_successfully'));
            return redirect()->route('admin.adv.index');

        } catch (\Exception $ex) {
            return $ex->getMessage();
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
            $cities = City::where('province_id', $adv->province_id)->get();
            $advGroups = AdvCategory::find($adv->adv_category_id)->ancestorsAndSelf;

            $current_adv_group = [];
            foreach ($advGroups as $group) {
                $current_adv_group[] = $group->title;
            }
            $current_adv_group = implode(" > ", array_reverse($current_adv_group));

            return view('admin_end.advertisement.edit')
                ->with(['adv' => $adv, 'categories' => $categories, 'cities' => $cities,
                    'provinces' => $provinces, 'advGroups' => $current_adv_group]);

        } catch (\Exception $ex) {
            //return  $ex->getMessage();
            return view('errors_custom.model_not_found');
        }

    }

    public function update(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'advGroup' => ['required'],
            'title' => ['required', Rule::unique('products')->ignore($request->adv), 'min:2', 'max:100'],
            'province' => ['required'],
            'city' => ['required'],
            'description' => ['nullable', 'min:2', 'string', 'max:5000'],
            'seo_desc' => ['nullable', 'min:2', 'string', 'max:150'],
            'keywords' => ['required'],
            'website' => ['nullable','url:https'],
            'owner' => ['required', 'min:6', 'max:128'],
            'advertiser_phone' => ['required', 'digits_between:2,20', 'numeric'],
            'email' => ['nullable','email']
        ]);


        try {

            $adv = Advertisement::find($request->adv);




            $images_path = [];
            if($request->has('images')){

                // save images path in database
                if ($request->has('images')) {
                    foreach ($request->input('images', []) as $file) {
                        $images_path [] = '/uploads/' . $file;
                    }
                }
                // merge old images with new images in array
                // and save into database


                $old_photos = [];
                // convert json into collection
                $old_photos = collect(json_decode($request->old_photos,true));


                // delete old photo from database & file
                // if user deleted
                foreach ($adv->images as $key => $photo){
                    if(!$old_photos->has($key) || $old_photos[$key] === null ){
                        $path = env('app_url').$key;
                        Storage::disk('public')->delete($path);
                        // delete image from images collection
                        $adv->images->forget($key);
                    }
                }

            }




            ////
            $author = Auth::guard('admin')->id();
            $slug = str_replace('-', ' ', $request->title);
            ////
            $adv->status = $request->status;
            $adv->admin_id = $author;
            $adv->title = $request->title;
            $adv->province_id = $request->province;
            $adv->city_id = $request->city;
            $adv->keywords = $request->keywords;
            $adv->images = $images_path;
            $adv->description = $request->description;
            $adv->seo_desc = $request->seo_desc;
            $adv->adv_category_id = $request->advGroup;
            $adv->slug = $slug;
            $adv->video_link = $request->video_link;
            $adv->advertiser_phone = $request->advertiser_phone;
            $adv->owner = $request->owner;
            $adv->address = $request->address;
            $adv->website = $request->website;
            $adv->email = $request->email;
            $adv->eitaa = $request->eitaa;
            $adv->rubika = $request->rubika;
            $adv->instagram = $request->instagram;
            $adv->telegram = $request->telegram;
            $adv->save();


            session()->flash('success', __('messages.The_update_was_completed_successfully'));
            return redirect()->route('admin.adv.index');

        } catch (\Exception $ex) {
            // return $ex->getMessage();
            return view('errors_custom.model_store_error');
        }
    }


    public function storeAdvImages(Request $request)
    {


        $path = storage_path('app/public/uploads');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $file = $request->file('file');
        $ext = $file->clientExtension();
        $name = uniqid().'.'.$ext;
        $file->move($path, $name);
        return response()->json([
            'name' => $name,
            'original_name' => $name,
        ]);
    }


}
