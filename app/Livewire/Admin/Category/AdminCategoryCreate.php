<?php

namespace App\Livewire\Admin\Category;

use App\Models\AdvCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

use Livewire\WithPagination;

class AdminCategoryCreate extends Component
{
    use WithPagination;


    protected $paginationTheme = 'bootstrap';
    public $search = '';
    public $delete_id;
    public $title;
    public $parent;
    public $show_in_menu;
    public $status;
    public $category_id;
    // public $category;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    // create category
    protected function rules()
    {
        return [
            'title' => ['required', 'min:2', 'max:30'],
            'show_in_menu' => ['required'],
            'status' => ['required'],
        ];
    }

    protected $messages = [
        'title.required' => 'عنوان دسته بندی را به فارسی وارد کنید.',
        'title.min' => 'حداقل ۲ کارکتر.',
        'title.max' => 'حداکثر ۵۰ کاراکتر.',
        'title.unique' => 'عنوان وارد شده تکراری است.',
        'show_in_menu.required' => 'نمایش در منو را انتخاب کنید.',
    ];

    public function store()
    {
        try {

            $this->validate();
            AdvCategory::create([
                'title' => $this->title,
                'status' => $this->status,
                'show_in_menu' => $this->show_in_menu,
                'parent_id' => $this->parent ?? null,
            ]);

            //            $this->dispatchBrowserEvent('show-result',
            //                ['type' => 'success',
            //                    'message' => __('messages.The_changes_were_made_successfully')]);

            session()->flash('success', __('messages.New_record_saved_successfully'));
            return redirect()->to('/admin/category/create');

        } catch (\Exception $ex) {
            return view('errors_custom.model_store_error');
        }
    }


    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;
        $this->dispatch('show-delete-confirmation');
        // $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    //    protected $listeners = [
    //        'deleteConfirmed' => 'deleteCategory',
    //    ];

    #[on('deleteConfirmed')]
    public function deleteCategory()
    {

        $category = AdvCategory::findOrFail($this->delete_id);

        try {
            if ($category->parent_id == null) {
                $this->dispatch('show-result',type:'warning',message:__('messages.It_is_not_possible_to_delete'));
            } else {
                if ($category->image_path != null) {
                    Storage::disk('public')->delete('/images/category/' . $category->image_path);
                }
                $category->delete();
                $this->dispatch('show-result',type:'success',message:__('messages.The_deletion_was_successful'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', __('messages.The_desired_record_does_not_exist'));
        }
        return null;

    }

    //    public function detachCategory($id)
    //    {
    //        try {
    //            $category = Category::find($id);
    //            if ($category->parent_id != null) {
    //                $category->parent_id = null;
    //                $category->save();
    //                session()->flash('success', __('messages.The_category_was_removed_from_its_parent'));
    //                return redirect()->to('/admin/category/index');
    //            }
    //        } catch (\Exception $ex) {
    //            session()->flash('error', __('messages.The_desired_record_does_not_exist'));
    //
    //        }
    //    }

    public function changeState($id)
    {
        try {
            $category = AdvCategory::findOrFail($id);
            if ($category->status == 0) {
                $category->status = 1;
                $this->is_active = 1;
            } else {
                $category->status = 0;
                $this->is_active = 0;
            }
            $category->save();
            $this->dispatch('show-result', type: 'success', message: __('messages.The_changes_were_made_successfully'));


        } catch (\Exception $ex) {

            $this->dispatch('show-result',
                ['type' => 'error',
                    'message' => $ex->getMessage()]);

            //            $this->dispatchBrowserEvent('show-result',
            //                ['type' => 'success',
            //                    'message' => __('messages.The_changes_were_made_successfully')]);
            //            $this->dispatchBrowserEvent('show-result',
            //                ['type' => 'error',
            //                    'message' => $ex->getMessage()]);
        }
    }

    public function paginationView(): string
    {
        return 'vendor.livewire.custom-pagination-links-view';
    }

    public function render()
    {
        return view('livewire.admin.category.admin-category-create')
            ->extends('admin_end.include.master_dash')
            ->section('dash_main_content')
            ->with(['categories' => AdvCategory::where('title', 'like', '%' . $this->search . '%')
                ->orderBy('id','asc')->where('parent_id',null)->paginate(10),'listCategories' => AdvCategory::all()]);

    }
}
