<?php

namespace App\Http\Livewire\Front\Layout;


use App\Models\Advertisement;
use Livewire\Component;


class FrontBestSellers extends Component
{
    public $readyToLoad = false;

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.front.layout.front-best-sellers')
            ->with(['products' =>
            Advertisement::select('id', 'title_persian', 'origin_price', 'slug', 'thumbnail_image')
                ->where('number_sold', '<>', null)
                ->orderByDesc('number_sold')
                ->take(6)
                ->get()]);
    }
}
