<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\Registration;
use Carbon\Carbon;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($registration)
    {
        $registration_number = Crypt::decrypt($registration);
        $registration = Registration::where('registration_number', $registration_number)->first();
        $product = Product::get();

        $orderProduct = OrderProduct::with('product')
        ->where('registration_number', $registration_number)
        ->get();

        $registration->orders = $orderProduct;
        $registration->totalbiaya = $orderProduct->sum(fn($item) => $item->product->price * $item->qty);

        return view('order', compact('registration', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $registration)
    {
        $validated = $request->validate([
            'product' => 'required|numeric',
            'qty' => 'required|numeric'
        ]);

        $registration_number = Crypt::decrypt($registration);

        $orderProduct = new OrderProduct();
        $orderProduct->registration_number = $registration_number;
        $orderProduct->product_id = $validated['product'];
        $orderProduct->qty = $validated['qty'];
        $orderProduct->save();

        $registration_number = Crypt::encrypt($registration_number);

        return redirect()->route('order', $registration_number)->with('success', 'Produk berhasil diorder.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function vital_sign($registration)
    {
        $registration_number = Crypt::decrypt($registration);
        $registration = Registration::where('registration_number', $registration_number)->first();

        return view('vital-sign', compact('registration'));
    }

    public function store_vital_sign(Request $request, $registration)
    {
        $validated = $request->validate([
            'patient_blood_pressure' => 'required|string|max:255',
            'patient_weight' => 'required|numeric',
        ]);

        $registration_number = Crypt::decrypt($registration);
        $registration_data = Registration::where('registration_number', $registration_number)->first();
        $registration_data->update($validated);

        return redirect()->route('vital_sign', $registration)->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function diagnose($registration)
    {
        $registration_number = Crypt::decrypt($registration);
        $registration = Registration::where('registration_number', $registration_number)->first();

        return view('diagnose', compact('registration'));
    }

    public function store_diagnose(Request $request, $registration)
    {
        $validated = $request->validate([
            'patient_complaint' => 'nullable|string',
            'diagnostic_result' => 'nullable|string',
        ]);

        $registration_number = Crypt::decrypt($registration);
        $registration_data = Registration::where('registration_number', $registration_number)->first();
        $registration_data->update($validated);

        return redirect()->route('diagnose', $registration)->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function product()
    {
        $product = Product::get();

        return view('product', compact('product'));
    }

    public function create_product($product = null)
    {
        $selectedProduct = null;

        if ($product) {
            $id = Crypt::decrypt($product);
            $selectedProduct = Product::findOrFail($id);
        }

        return view('create-product', compact('selectedProduct'));
    }

    public function store_product(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        $product = Product::create($validated);

        return redirect()->route('product')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update_product(Request $request, $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        $id = Crypt::decrypt($product);
        $productData = Product::findOrFail($id);
        $productData->update($validated);

        return redirect()->route('product', $product)->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy_product($product)
    {
        $id = Crypt::decrypt($product);
        Product::where('id', $id)->delete();

        return redirect()->route('product', $product)->with('success', 'Data produk berhasil dihapus.');
    }

    public function destroy_order($order)
    {
        $id = Crypt::decrypt($order);
        $orderProduct = OrderProduct::where('id', $id)->first();
        $registration_number = Crypt::encrypt($orderProduct->registration_number);
        $orderProduct->delete();

        return redirect()->route('order', $registration_number)->with('success', 'Order produk berhasil dihapus.');
    }
}