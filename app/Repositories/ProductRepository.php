<?php


namespace App\Repositories;


use App\Models\Advertisement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// use App\Services\ImageService\ImageUploader;
// use Illuminate\Support\Facades\Storage;


class ProductRepository
{


    public function store($request, $images)
    {

        $thumbImagePatch = '';
        $createdProduct = null;
        $author = Auth::guard('admin')->id();


        $realTimestamp = substr($request->published_at, 0, 10);
        $published_at = date("Y-m-d H:i:s", (int)$realTimestamp);

        // dd($request->all());
        // for save product public info
        DB::transaction(function () use ($author, $images, $published_at, $request) {

            $createdProduct = Advertisement::create([
                'status' => $request->status,
                'admin_id' => $author,
                'user_id' => Auth::id(),
                'title' => $request->title,
                'keywords' => $request->keywords,
                'images' => $images,
                'province_id' => $request->province,
                'city_id' => $request->city,
                'description' => $request->description,
                'seo_desc' => $request->seo_desc,
                'adv_category_id' => $request->advGroup,
                'slug' => $request->slug,
                'video_link' => $request->video_link,
                'advertiser_phone' => $request->advertiser_phone,
                'owner' => $request->owner,
                'address' => $request->address,
                'email' => $request->email,
                'webite' => $request->website,
                'eitaa' => $request->eitaa,
                'rubika' => $request->rubika,
                'instagram' => $request->instagram,
                'telegram' => $request->telegram,
            ]);


            // for save product thumbnail image
            //            if ($request->hasFile('thumbnail_image')) {
            //
            //                if (!$this->uploadImages($createdProduct, $request)) {
            //                    session()->flash('warning', __('messages.An_error_occurred_while_updated'));
            //                    return redirect()->back();
            //                }
            //            }
            return $createdProduct;
        });
    }

    public function update($request, $images)
    {

        $author = Auth::guard('admin')->id();
        $adv = Advertisement::findOrFail($request->adv);


        $adv = DB::transaction(function () use ($author, $adv, $request, $images) {

            // 'user_id' = Auth::id();
            $adv->status = $request->status;
            $adv->admin_id = $author;
            $adv->title = $request->title;
            $adv->province_id = $request->province;
            $adv->city_id = $request->city;
            $adv->keywords = $request->keywords;
            $adv->images = $images;
            $adv->description = $request->description;
            $adv->seo_desc = $request->seo_desc;
            $adv->adv_category_id = $request->advGroup;
            $adv->slug = $request->slug;
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

            // $adv->published_at = $published_at;
            // $current_product->categories()->sync($request->categories);

        });

        return $adv;


        // $realTimestamp = substr($request->published_at, 0, 10);
        // $published_at = date("Y-m-d H:i:s", (int)$realTimestamp);

        // only update image
        //        if ($request->only_image_update) {
        //            if ($request->hasFile('thumbnail_image')) {
        //                if ($current_product->thumbnail_image != null && Storage::disk('public')->exists($current_product->thumbnail_image)) {
        //                    Storage::disk('public')->delete($current_product->thumbnail_image);
        //                    $result = $this->uploadImages($current_product, $request);
        //                    if ($result = false) {
        //                        session()->flash('warning', __('messages.An_error_occurred_while_updated'));
        //                        return redirect()->back();
        //                    }
        //                } else {
        //                    $result = $this->uploadImages($current_product, $request);
        //                    if ($result = false) {
        //                        session()->flash('warning', __('messages.An_error_occurred_while_updated'));
        //                        return redirect()->back();
        //                    }
        //                }
        //            }
        //        }


    }

    //    private function uploadImages($createdProduct, $request): bool|\Illuminate\Http\RedirectResponse
    //    {
    //        $sourceImagePath = null;
    //        $data = [];
    //        $basPath = 'products/' . $createdProduct->id . '/';
    //        try {
    //            if (isset($request->thumbnail_image)) {
    //                $full_path = $basPath . 'thumbnail_image' . '_' . $request->thumbnail_image->getClientOriginalName();
    //
    //                ImageUploader::upload($request->thumbnail_image, $full_path, 'public');
    //                $data = ['thumbnail_image' => $full_path];
    //            }
    //            $updated = $createdProduct->update($data);
    //            if (!$updated) {
    //                session()->flash('warning', __('messages.An_error_occurred_while_uploading_images'));
    //                return redirect()->back();
    //            }
    //            return true;
    //        } catch (\Exception $ex) {
    //            return false;
    //        }
    //    }


    //    public function delete($request)
    //    {
    //        $product = Advertisement::findOrfail($request->id);;
    //        $images = ProductImage::where('product_id', $request->id)->get();
    //        if (Storage::disk('public')->exists($product->thumbnail_image)) {
    //            Storage::disk('public')->delete($product->thumbnail_image);
    //        }
    //        if (count($images) > 0) {
    //            foreach ($images as $image) {
    //                if (Storage::disk('public')->exists('/images/product/thumbnail/' . $image->thumbnail_path)) {
    //                    Storage::disk('public')->delete(['/images/product/thumbnail/' . $image->image_path]);
    //                }
    //                $images->each->delete();
    //            }
    //        }
    //        if ($product->delete()) {
    //            return 'true';
    //        } else {
    //            return 'false';
    //        }
    //
    //        if (count($images) > 0) {
    //            foreach ($images as $image) {
    //                if (Storage::disk('public')->exists($image->thumbnail_path) && Storage::disk('public')->exists($image->image_path)) {
    //                    Storage::disk('public')->delete([$image->thumbnail_path, $image->image_path]);
    //                }
    //                $images->each->delete();
    //            }
    //        }
    //    }
}
