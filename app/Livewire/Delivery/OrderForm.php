<?php

namespace App\Livewire\Delivery;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Mary\Traits\Toast;

#[Layout('layouts.frontend')]
class OrderForm extends Component
{
    use Toast;

    // ... (Public properties for form fields would go here: $name, $address, etc.)

    public function placeOrder()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            $this->error('El carrito está vacío.');
            return;
        }

        // Validate form fields here...

        DB::transaction(function () use ($cart) {
            // 1. Create Order
            // $order = Order::create([...]); 
            // For demo purposes, let's assume $order is created. 
            // You will need to wire this to your actual form properties.
            
            // Placeholder for order creation to demonstrate item saving:
            /*
            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']),
                'status' => 'pending',
                // ... other fields
            ]);
            */

            // 2. Create Order Items with Options
            foreach ($cart as $item) {
                // Prepare options payload
                $options = [];
                
                // Save flavors if present
                if (!empty($item['flavors'])) {
                    $options['flavors'] = $item['flavors']; // IDs
                    $options['flavor_names'] = $item['flavor_names'] ?? ''; // Names snapshot
                }

                // Create the item
                // OrderItem::create([
                //     'order_id' => $order->id,
                //     'product_id' => $item['id'],
                //     'name' => $item['name'],
                //     'quantity' => $item['quantity'],
                //     'price' => $item['price'],
                //     'options' => $options, // <--- This will be automatically cast to JSON
                // ]);
            }

            // session()->forget('cart');
        });

        // return redirect()->route('checkout.success');
    }

    public function render()
    {
        return view('livewire.delivery.order-form');
    }
}
