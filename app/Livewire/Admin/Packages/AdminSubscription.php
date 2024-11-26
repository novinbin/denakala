<?php

namespace App\Livewire\Admin\Packages;

use App\Models\AdvCategory;
use App\Models\Subscription;
use Livewire\Component;

class AdminSubscription extends Component
{


    public $edit_id;
    public $title;
    public $description;

    //    public function mount()
    //    {
    //
    //    }
    protected function rules()
    {
        return [
            'title' => ['required', 'min:3', 'max:30'],
            'description' => ['required', 'min:3', 'max:128'],
        ];
    }

    protected $messages = [
        'title.required' => 'عنوان  را وارد کنید.',
        'title.min' => 'حداقل 3 کارکتر.',
        'title.max' => 'حداکثر 128 کاراکتر.',

        'description.required' => 'عنوان  را وارد کنید.',
        'description.min' => 'حداقل 3 کارکتر.',
        'description.max' => 'حداکثر 128 کاراکتر.',
    ];

    public function store()
    {

        try {
            Subscription::where('id', $this->edit_id)->update([
                'title' => $this->title,
                'description' => $this->description,
            ]);

            $this->title = null;
            $this->description = null;

            $this->dispatch('show-result', type: 'success', message: __('messages.The_update_was_completed_successfully'));
        } catch (\Exception $ex) {
            $this->dispatch('show-result', type: 'warning', message: __('messages.An_error_occurred'));
        }

    }

    public function edit($id)
    {
        $this->edit_id = $id;
        $sub = Subscription::find($id);
        $this->title = $sub->title;
        $this->description = $sub->description;
    }

    public function render()
    {
        return view('livewire.admin.packages.admin-packages')
            ->extends('admin_end.include.master_dash')
            ->section('dash_main_content')
            ->with(['subscriptions' => Subscription::all()]);
    }
}
