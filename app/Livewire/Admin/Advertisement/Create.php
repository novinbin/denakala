<?php

namespace App\Livewire\Admin\Advertisement;

use App\Models\AdvCategory;
use App\Models\City;
use App\Models\Province;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component
{

    public $provinces;
    public $cities;
    public $categories;

    public $province_id;
    public $city_id;
    public $product_tags = [];
    public $loadCities;



    public function mount()
    {
        $this->categories = AdvCategory::all();
        $this->provinces = Province::all();
        $this->loadCities = collect();
    }


    //    public function updatedProvinceId()
    //    {
    //        dd($this->province_id);
    //        $this->loadCity = '';
    //    }

    //        protected $listeners = [
    //            'listenerGetId'
    //        ];

    #[On('listenerGetId')]
    public function listenerCity($value)
    {
        dd($value);
        $this->loadCities =
            City::where('province_id',$id)->get();
    }
//    public function getCity(): void
//    {
//        $this->loadCities =
//            City::where('province_id',$this->province_id)->get();
//
//    }
    public function store()
    {
        dd($this->product_tags,$this->province_id,$this->city_id);


    }

    public function render()
    {

        return view('livewire.admin.advertisement.create');
    }
}
