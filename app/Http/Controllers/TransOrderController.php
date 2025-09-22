<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\TransLaundryPickup;
use App\Models\TransOrderDetails;
use App\Models\TransOrders;
use App\Models\TypeOfServices;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class TransOrderController extends Controller
{
    public function index()
    {
        $title = "Transaction Order";
        $orders = TransOrders::orderBy('id', 'desc')->get();
        confirmDelete('title', 'text');
        return view('order.index', compact('title', 'orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $today = Carbon::now()->format('dmY');
        $countDay = TransOrders::whereDate('created_at', now())->count() + 1;
        $runningNumber = str_pad($countDay, 3, '0', STR_PAD_LEFT);
        $code = 'TRLV-' . $today . '-' . $runningNumber;
        $title = "Transaction Order";
        $customers = Customers::orderBy('id', 'desc')->get();
        $services = TypeOfServices::orderBy('id', 'desc')->get();
        $orders = TransOrders::with(['customer', 'details.service'])->orderBy('id', 'desc')->get();
        return view('order.transaction', compact('title', 'code', 'customers', 'services', 'orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataValidated = $request->validate([
            'id_customer' => 'required|numeric|exists:customers,id',
            'order_date' => 'required|date',
            'order_end_date' => 'nullable|date',
            'order_status' => 'required|numeric',
            'order_pay' => 'required|numeric',
            'order_change' => 'required|numeric',
            'total' => 'required|numeric',
            'details' => 'required|array|min:1',
            'details.*.id_service' => 'required|numeric|exists:type_of_services,id',
            'details.*.qty' => 'required|numeric|min:1',
            'details.*.subtotal' => 'required|numeric|min:0',
        ]);

        // Generate order_code
        $today = \Carbon\Carbon::parse($request->order_date)->format('dmY');
        $countDay = \App\Models\TransOrders::whereDate('created_at', $request->order_date)->count() + 1;
        $runningNumber = str_pad($countDay, 3, '0', STR_PAD_LEFT);
        $order_code = 'TRLV-' . $today . '-' . $runningNumber;

        $order = TransOrders::create([
            'id_customer' => $request->id_customer,
            'order_code' => $order_code,
            'order_date' => $request->order_date,
            'order_end_date' => $request->order_end_date ?? \Carbon\Carbon::parse($request->order_date)->addDays(2),
            'order_status' => $request->order_status,
            'order_pay' => $request->order_pay,
            'order_change' => $request->order_change,
            'total' => $request->total,
        ]);

        foreach ($request->details as $detail) {
            TransOrderDetails::create([
                'id_order' => $order->id,
                'id_service' => $detail['id_service'],
                'qty' => $detail['qty'] * 1000, // if you want to store as grams
                'subtotal' => $detail['subtotal'],
            ]);
        }

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'order_code' => $order->order_code,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = "Transaction Order";
        $order = TransOrders::with(['customer', 'details.service'])->findOrFail($id);
        // dd($order->details);
        return view('order.show', compact('title', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Transaction Order";
        $order = TransOrders::findOrFail($id);
        return view('order.edit', compact('title', 'order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataValidated = $request->validate([
            'order_pay' => 'required|numeric',
            'order_change' => 'required|numeric'
        ]);

        $order = Transorders::findOrFail($id);
        $order->update($dataValidated);
        $order->order_status = 1;
        $order->save();

        // $order = Transorders::findOrFail($id);
        TransLaundryPickup::create([
            'id_order' => $order->id,
            'id_customer' => $order->customer->id,
            'pickup_date' => date('Y-m-d H:i:s')
        ]);
        Alert::success('Excellent', 'Update data order successfully');
        return redirect()->route('order.index')->with('success', 'Update data order successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = TransOrders::findOrFail($id);
        $order->delete();
        toast('Delete data order successfully', 'success');
        return redirect()->route('order.index')->with('success', 'Delete data order successfully');
    }

    public function printStruk(string $id)
    {
        $details = TransOrders::with(['customer', 'details.service'])->where('id', $id)->first();
        // debuging
        // return $details;
        // dd($details);
        return view('order.print', compact('details'));
    }

    // public function getLayanan()
    // {
    //     $layanan = TypeOfServiceController::all();
    //     $prices = $layanan->pluck('price', 'service_name');
    //     return response()->json($prices);
    // }
}
