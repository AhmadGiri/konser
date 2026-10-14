<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //Menampilkan halaman utama untuk pelanggan
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('customer.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    //Memproses pesanan tiket yang dikirimkan oleh pelanggan
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'items' => 'required|array',
            'items.*' => 'nullable|integer|min:0',
        ]);

        $orderedItems = array_filter($request->items, fn ($quantity) => $quantity > 0);

        if (empty($orderedItems)) {
            return redirect()->back()->with('error', 'Pilih minimal satu tiket untuk dipesan.');
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'total_price' => 0,
                'status' => 'Pending',
            ]);
            $totalPrice = 0;

            foreach ($orderedItems as $eventId => $quantity) {
                $event = Event::findOrFail($eventId);
                $subtotal = $event->ticket_price * $quantity;
                $totalPrice += $subtotal;
                OrderDetail::create([
                    'order_id' => $order->id,
                    'event_id' => $event->id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);
            }

            $order->update(['total_price' => $totalPrice]);
            DB::commit();

            return redirect()->route('customer.index')->with('success', 'Pesanan tiket berhasil dibuat! Silakan pantau status pesanan Anda.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memproses pesanan.' . $e->getMessage());
        }


    }

    //Menampilkan halaman dashboard untuk admin
    public function adminDashboard()
    {
        $orders = Order::with('orderDetails.event')->latest()->get();
        return view('dashboard', compact('orders'));
    }

    //Memperbarui status pesanan melalui dashboard admin
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan #' . $order->id . ' berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
