<?php

namespace App\Livewire\Admin\Category;

use App\Models\AdvCategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class AdminSubCategory extends Component
{
    use WithPagination;
    use WithoutUrlPagination;

    protected $paginationTheme = 'bootstrap';
    ///
    public $delete_id;
    public $title;
    public $parent;
    public $show_in_menu;
    public $status;

    public $edit_id;
    public $edit_status = false;
    public $parent_cat_id;
    //
    public $category;

    public function mount($sub_cat_id)
    {
        $this->parent_cat_id = $sub_cat_id;
        $this->category = AdvCategory::find($sub_cat_id);

    }

    protected function rules()
    {
        return [
            'title' => ['required', 'min:2', 'max:30'],
            'show_in_menu' => ['required'],
            'status' => ['required'],
        ];
    }

    protected $messages = [
        'title.required' => 'عنوان دسته بندی را وارد کنید.',
        'title.min' => 'حداقل ۲ کارکتر.',
        'title.max' => 'حداکثر ۵۰ کاراکتر.',
        'title.unique' => 'عنوان وارد شده تکراری است.',
        'show_in_menu.required' => 'نمایش در منو را انتخاب کنید.',
    ];

    public function store()
    {
        $this->validate();
        try {
            if (!$this->edit_status) {
                AdvCategory::create([
                    'title' => $this->title,
                    'status' => $this->status,
                    'show_in_menu' => $this->show_in_menu,
                    'parent_id' => $this->parent_cat_id,
                ]);
                session()->flash('success', __('messages.New_record_saved_successfully'));
                return redirect()->to('/admin/sub-category/create/' . $this->parent_cat_id);
            } elseif ($this->edit_status = true) {
                AdvCategory::where('id',$this->edit_id)->update([
                    'title' => $this->title,
                    'status' => $this->status,
                    'show_in_menu' => $this->show_in_menu,
                ]);
                $this->edit_id = null;
                $this->edit_status = false;
                $this->status = null;
                $this->show_in_menu = null;
                $this->title = null;
                $this->dispatch('show-result', type: 'success', message: __('messages.The_update_was_completed_successfully'));
                // return redirect()->to('/admin/sub-category/create/' . $this->parent_cat_id);
            }


        } catch (\Exception $ex) {
            return view('errors_custom.model_store_error');
        }

        //            $this->dispatchBrowserEvent('show-result',
        //                ['type' => 'success',
        //                    'message' => __('messages.The_changes_were_made_successfully')]);
        // session()->flash('success', __('messages.The_update_was_completed_successfully'));
    }


    public function edit($id)
    {
        $this->edit_status = true;
        $this->edit_id = $id;
        $edit_cat = AdvCategory::find($id);
        $this->title = $edit_cat->title;
        $this->status = $edit_cat->status;
        $this->show_in_menu = $edit_cat->show_in_menu;
    }


    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;
        $this->dispatch('show-delete-confirmation');
        // $this->dispatchBrowserEvent('show-delete-confirmation');
    }


    #[on('deleteConfirmed')]
    public function deleteCategory()
    {

        $category = AdvCategory::findOrFail($this->delete_id);

        try {
            if ($category->parent_id == null) {
                $this->dispatch('show-result', type: 'warning', message: __('messages.It_is_not_possible_to_delete'));
            } else {
                if ($category->image_path != null) {
                    Storage::disk('public')->delete('/images/category/' . $category->image_path);
                }
                $category->delete();
                $this->dispatch('show-result', type: 'success', message: __('messages.The_deletion_was_successful'));
            }
        } catch (\Exception $ex) {
            session()->flash('error', __('messages.The_desired_record_does_not_exist'));
        }
        return null;

    }

    public function render()
    {
        return view('livewire.admin.category.admin-sub-category')
            ->extends('admin_end.include.master_dash')
            ->section('dash_main_content')
            ->with(['subCategories' =>
                AdvCategory::where('parent_id', $this->parent_cat_id)->paginate(10)]);
    }
}
