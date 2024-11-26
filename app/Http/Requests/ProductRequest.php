<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        return [
            'advGroup' => ['required'],
            'title' => ['required',Rule::unique('products')->ignore($this->request->get('adv')), 'min:2', 'max:100'],
            'province' => ['required'],
            'city' => ['required'],
            'description' => ['nullable', 'min:2', 'string', 'max:5000'],
            'seo_desc' => ['nullable', 'min:2', 'string', 'max:150'],
            'keywords' => ['required'],
            'website' => ['url:https'],
            'owner' => ['required','min:6','max:128'],
            'advertiser_phone' => ['required','digits_between:2,20','numeric'],
            'email' => ['email']
        ];
    }
    //  'status' => ['required'],
    //|dimensions:min_width=300,min_height=300
    // 'thumbnail_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:1999',
    //'product_tags' => ['required','regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ی.,]+$/u'],

}
