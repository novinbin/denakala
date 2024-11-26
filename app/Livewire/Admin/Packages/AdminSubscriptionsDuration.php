<?php

namespace App\Livewire\Admin\Packages;

use App\Models\Subscription;
use App\Models\SubscriptionDuration;
use Livewire\Component;

class AdminSubscriptionsDuration extends Component
{

    public $subs_id;
    public $sub_duration_id;

    public $price;
    public $discount;
    public $duration;

    public function mount($id)
    {
        $this->subs_id = $id;
    }

    public function store()
    {
        try {
            SubscriptionDuration::where('id', $this->sub_duration_id)->update([
                'price' => $this->price,
                'discount' => $this->discount,
                'duration' => $this->duration,
            ]);
            $this->price = null;
            $this->duration = null;
            $this->discount = null;
            $this->dispatch('show-result', type: 'success', message: __('messages.The_update_was_completed_successfully'));
        } catch (\Exception $ex) {
            $this->dispatch('show-result', type: 'warning', message: __('messages.An_error_occurred'));
        }
    }

    public function edit($id)
    {
        $this->sub_duration_id = $id;
        $subs = SubscriptionDuration::find($id);
        $this->price = $subs->price;
        $this->duration = $subs->duration;
        $this->discount = $subs->discount;
    }

    public function render()
    {
        return view('livewire.admin.packages.admin-subscriptions-duration')
            ->extends('admin_end.include.master_dash')
            ->section('dash_main_content')
            ->with(['subscription' => Subscription::find($this->subs_id),
                'subs_duration' => SubscriptionDuration::where('subscription_id', $this->subs_id)->get()]);;
    }
}
