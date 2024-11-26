<?php

namespace App\Http\Livewire\Front\Layout;

use App\Models\AdvCategory;
use Livewire\Component;

class FrontCategory extends Component
{
    public function render()
    {
        return view('livewire.front.layout.front-category')
            ->with(['categories' => AdvCategory::select('image_path','title_persian','slug')
            ->where(['parent_id' => null,'status'=>1])->get()]);
    }
}
