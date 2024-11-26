<?php

namespace App\Livewire\Admin\Advertisement;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Advertisement;

class Advertisements extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $delete_id;

    // filter & search parameter
    public $search = '';
    public $paginate = 10;
    public $orderBy = 'id';
    public $orderAsc = true;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function changeState($id)
    {
        $product = Advertisement::findOrFail($id);
        if ($product->status == 0) {
            $product->status = 1;
        } else {
            $product->status = 0;
        }
        $product->save();

        $this->dispatch('show-result',type : 'success', message : __('messages.The_changes_were_made_successfully'));

    }

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;
        $this->dispatch('show-delete-confirmation');
        // $this->dispatchBrowserEvent('show-delete-confirmation');
    }



    #[on('deleteConfirmed')]
    public function deleteProduct()
    {
        try {

            $product = Advertisement::findOrFail($this->delete_id);
            if($product->thumbnail_image != null){
                Storage::disk('public')->delete('/images/products/'.$product->thumbnail_image);
            }
            $product->delete();
            $this->dispatch('show-result',type:'success',message:__('messages.The_deletion_was_successful'));
        } catch (\Exception $ex) {
            return view('errors_custom.model_not_found');
        }
        return null;
    }

    //    protected $listeners = [
    //        'deleteConfirmed' => 'deleteProduct',
    //    ];

    //  session()->flash('success', __('messages.The_deletion_was_successful'));
    //  return redirect()->to('admin/product/index');

    public function render()
    {
        return view('livewire.admin.advertisement.index')
            ->extends('admin_end.include.master_dash')
            ->section('dash_main_content')
            ->with(['categories'=> DB::table('categories')->select('id','title')->get(),
                'adverts' => Advertisement::search($this->search)
                    ->orderBy($this->orderBy ,$this->orderAsc ? 'asc' : 'desc')->paginate($this->paginate)]);

    }
}
