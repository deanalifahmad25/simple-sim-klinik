<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Patient;
use App\Models\Registration;
use App\Models\OrderProduct;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registration = Registration::whereDate('created_at', Carbon::today())->get();

        $arrRegNum = [];
        foreach ($registration as $reg) {
            $arrRegNum[] = $reg->registration_number;
        }

        $orderProducts = OrderProduct::with('product')
                ->whereIn('registration_number', $registration->pluck('registration_number'))
                ->get();

        foreach ($registration as $reg) {
            $reg->totalbiaya = $orderProducts
                    ->where('registration_number', $reg->registration_number)
                    ->sum(fn($item) => $item->product->price * $item->qty);
        }

        return view('dashboard', compact('registration'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($patient = null)
    {
        $selectedPatient = null;

        if ($patient) {
            $id = Crypt::decrypt($patient);
            $selectedPatient = Patient::findOrFail($id);

            $checkRegistrationExist = Registration::where('patient_id', $id)
                    ->whereDate('created_at', Carbon::today())
                    ->first();

            if (!empty($checkRegistrationExist)) {
                return redirect()->route('patient')->with('failed', 'Pasien ' . $selectedPatient->name . ' (' . $checkRegistrationExist->registration_number . ') ' . 'sudah registrasi hari ini.');
            }
        }

        return view('registration', compact('selectedPatient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'phone_number' => 'required|numeric|digits_between:10,13',
        ]);

        $patient = Patient::create($validated);
        Registration::create([
            'patient_id' => $patient->id
        ]);

        return redirect()->route('dashboard')->with('success', 'Pasien berhasil didaftarkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $registration = Registration::get();
        $patient = Patient::all();

        $arrRegNum = [];
        foreach ($registration as $reg) {
            $arrRegNum[] = $reg->registration_number;
        }

        $orderProducts = OrderProduct::with('product')
                ->whereIn('registration_number', $registration->pluck('registration_number'))
                ->get();

        foreach ($registration as $reg) {
            $reg->totalbiaya = $orderProducts
                    ->where('registration_number', $reg->registration_number)
                    ->sum(fn($item) => $item->product->price * $item->qty);
        }

        return view('registration-history', compact('registration', 'patient'));
    }

    public function search(Request $request)
    {
        $registration = Registration::query();

        if (isset($request->patient) && $request->patient) {
            $registration = $registration->where('id', $request->patient);
        }

        if (isset($request->registration_date) && $request->registration_date) {
            $date = Carbon::parse($request->registration_date);

            $registration->whereBetween('created_at', [
                $date->startOfDay()->format('Y-m-d H:i:s'),
                $date->endOfDay()->format('Y-m-d H:i:s'),
            ]);
        }

        $registration = $registration->get();
        $patient = Patient::all();

        $arrRegNum = [];
        foreach ($registration as $reg) {
            $arrRegNum[] = $reg->registration_number;
        }

        $orderProducts = OrderProduct::with('product')
                ->whereIn('registration_number', $registration->pluck('registration_number'))
                ->get();

        foreach ($registration as $reg) {
            $reg->totalbiaya = $orderProducts
                    ->where('registration_number', $reg->registration_number)
                    ->sum(fn($item) => $item->product->price * $item->qty);
        }

        return view('registration-history', compact('registration', 'patient'));
    }

    public function detail($registration)
    {
        $registration_number = Crypt::decrypt($registration);
        $registration = Registration::where('registration_number', $registration_number)->first();

        $orderProducts = OrderProduct::with('product')
                ->where('registration_number', $registration_number)
                ->get();

        $registration->orders = $orderProducts;
        $registration->totalbiaya = $orderProducts
                ->where('registration_number', $registration->registration_number)
                ->sum(fn($item) => $item->product->price * $item->qty);

        return view('registration-history-detail', compact('registration'));
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
    public function update(Request $request, $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'phone_number' => 'required|numeric|digits_between:10,13',
        ]);

        $id = Crypt::decrypt($patient);
        $patientData = Patient::findOrFail($id);
        $patientData->update($validated);

        Registration::create([
            'patient_id' => $patientData->id
        ]);

        return redirect()->route('dashboard', $patient)->with('success', 'Pasien berhasil didaftarkan & Data pasien berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($patient)
    {
        $id = Crypt::decrypt($patient);
        $patientData = Patient::findOrFail($id);

        Registration::where('id', $patientData->id)->delete();

        return redirect()->route('dashboard', $patient)->with('success', 'Registrasi Pasien berhasil dihapus.');
    }

    public function patient(Request $request)
    {
        $patient = Patient::all();

        return view('patient', compact('patient'));
    }
}
