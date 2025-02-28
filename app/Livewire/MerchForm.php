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

class MerchForm extends Component
{
    public $products;

    #[Validate]
    public $firstName;

    #[Validate]
    public $lastName;

    #[Validate]
    public $email;

    #[Validate]
    public $teamId = '-';

    public $phone;

    #[Validate]
    public $order = [
        'items' => [],
    ];

    #[Validate]
    public $quantities = [0, 0];

    #[Validate]
    public $sizes = ['l', 'l'];

    #[Validate]
    public $productIds = [];

    protected $rules = [
        'firstName' => 'required',
        'lastName'  => 'required',
        'email'     => 'required|email',
        'teamId'    => 'required',
    ];

    protected $messages = [
        'firstName.required' => 'Ime je obavezno',
        'lastName.required'  => 'Prezime je obavezno',
        'email.required'     => 'Email je obavezan',
        'email.email'        => 'Email mora biti validan',
        'teamId.required'    => 'Ekipa je obavezna',
    ];

    public function mount()
    {
        // Also add product IDs
        $this->productIds = $this->products->pluck('id')->toArray();

        // Here we can fetch data from the session to fill the form
        $this->firstName = session('merch.firstName');
        $this->lastName  = session('merch.lastName');
        $this->email     = session('merch.email');
        $this->phone     = session('merch.phone');
        $this->teamId    = session('merch.teamId');
    }

    public function submit()
    {
        $this->validate();

        Log::info('Creating order...');

        // Save the form input to the session
        session()->put('merch', [
            'firstName' => $this->firstName,
            'lastName'  => $this->lastName,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'teamId'    => $this->teamId,
        ]);

        // First we need to check if we have the proper quantities and add the items
        $totalQuantities = 0;
        foreach ($this->quantities as $quantity) {
            $totalQuantities += $quantity;
        }

        // If the quantities are not ok, redirect back with the input data
        if (! $totalQuantities) {
            $this->withValidator(function (Validator $validator) {
                $validator->after(function ($validator) {
                    $validator->errors()->add('quantity.0', 'Niste unijeli kolicinu!');
                });
            })->validate();
            return back()->withInput();
        }

        // If all validation passes, first create the order
        $order = Order::create([
            'first_name' => $this->firstName,
            'last_name'  => $this->lastName,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'team_id'    => $this->teamId,
        ]);

        // The the order items
        if ($order) {
            $price = 0;

            foreach ($this->quantities as $index => $quantity) {
                if ($quantity > 0) {
                    $product = $this->products->where('id', $this->productIds[$index])->first();

                    if ($product) {
                        $price += $product->price * $quantity;
                        $item = OrderItem::create([
                            'order_id'   => $order->id,
                            'product_id' => $this->productIds[$index],
                            'price'      => $product->price * $quantity,
                            'quantity'   => $quantity,
                            'variation'  => $this->sizes[$index],
                        ]);
                    }
                }
            }

            $order->update(['price' => $price]);
        }

        // And redirect to confirmation page
        return redirect()->route('products.order', $order->id);
    }
}
