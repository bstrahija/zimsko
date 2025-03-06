<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\Validator;
use Livewire\Attributes\Validate;
use Livewire\Component;

class OrderOverview extends Component
{
    public $order;

    public $confirmed = false;

    public function confirm()
    {
        $this->order->update([
            'status' => 'confirmed',
        ]);

        $this->confirmed = true;
    }
}
