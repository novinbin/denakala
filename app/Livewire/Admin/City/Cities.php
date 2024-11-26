<?php

namespace App\Livewire\Admin\City;

use App\Models\City;
use Livewire\Component;
use Livewire\WithPagination;

class Cities extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $province_id;

    public function mount($province){

        $this->province_id  = $province;
    }
    public function paginationView(): string
    {
        return 'vendor.livewire.custom-pagination-links-view';
    }
    public function render()
    {
        return view('livewire.admin.city.cities')
            ->with(['cities'=> City::where('province_id',$this->province_id)
                ->where('deleted_at','=',null)
                ->paginate(5)]);
    }
}
