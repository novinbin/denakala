<?php

namespace App\Livewire\Admin\Category;

use App\Models\AdvCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminCategoryEdit extends Component
{
    use WithFileUploads;

    public $title;
    public $parent;
    public $show_in_menu;
    public $status;
    public $category;
    public $category_title;
    public $edit_id;


    public function mount($id)
    {
        $this->edit_id = $id;

        $this->category = AdvCategory::findOrFail($id);
        $this->category_title = $this->category->title;
        $this->title = $this->category->title;
        $this->status = $this->category->status;
        $this->show_in_menu = $this->category->show_in_menu;

        if ($this->category->parent_id == null) {
            $this->parent = null;
        } else {
            $this->parent = $this->category->parent_id;
        }
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', Rule::unique('categories')->ignore($this->edit_id), 'min:2', 'max:30'],
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


    public function update()
    {
        $this->validate();

        try {
            $category = AdvCategory::find($this->edit_id);
            $category->title = $this->title;
            $category->status = $this->status;
            $category->show_in_menu = $this->show_in_menu;
            $category->parent_id = $this->parent == "null" ? null : $this->parent;
            $category->save();
            session()->flash('success', __('messages.The_update_was_completed_successfully'));
            return redirect()->to('/admin/category/create');
        } catch (\Exception $ex) {
            return view('errors_custom.model_store_error');
        }

        // this way save null ok
        // $category->parent_id = null;
    }

    public function render()
    {
        return view('livewire.admin.category.admin-category-edit')
            ->extends('admin_end.include.master_dash')
            ->section('dash_main_content')
            ->with(['categories' => AdvCategory::all(),
                'category' => $this->category,
                'category_title' => $this->category_title]);
    }


}
