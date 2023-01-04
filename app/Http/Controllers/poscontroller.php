<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;

class poscontroller extends Controller
{
    //
    public function store(Request $request)
{
    $itemIds = $request->item_ids;
    $quantities = $request->quantities;
    $totalPrice = 0;

    $items = [];
    for ($i = 0; $i < count($itemIds); $i++) {
        $item = Item::find($itemIds[$i]);
        $totalPrice += $item->price * $quantities[$i];
        $items[] = [
            'name' => $item->name,
            'quantity' => $quantities[$i],
            'price' => $item->price,
        ];
    }

    if ($request->customer_id) {
        $customer = Customer::find($request->customer_id);
    } else {
        $customer = Customer::create([
            'name' => $request->new_customer_name,
            'email' => 'mofa@gmail.com',
            'address' => 'dhaka',

        ]);
    }

    // Save the order to the database
    $order = Order::create([
        'customer_id' => $customer->id,
        'total_price' => $totalPrice,
        'items' => $items,
        // other order details
    ]);

    // Display the invoice
    return view('show', [
        'order' => $order,
        'customer' => $customer,
        'items' => $items,
    ]);
}

}
