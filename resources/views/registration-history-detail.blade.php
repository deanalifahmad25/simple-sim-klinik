<x-app-layout>
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('failed'))
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            {{ session('failed') }}
        </div>
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Registrasi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 mb-6 max-h-screen overflow-auto">
                    <div>
                        <h2 class="text-base/7 font-semibold text-gray-900">Detail Registrasi {{ $registration->registration_number }}</h2>
                    </div>

                    <div class="space-y-2">
                        <div class="border-t mt-4 pt-4 border-gray-900/10">
                            <h2 class="text-base/7 font-semibold text-gray-900">Pasien</h2>
                            <p class="text-sm/6 text-gray-600">Informasi biodata pasien.</p>
                        </div>

                        <div class="pb-5 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <x-input-label for="name" :value="__('Nama Pasien')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $registration->patient->name)" required autofocus autocomplete="name" disabled />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="gender" :value="__('Jenis Kelamin')" />
                                <x-text-input id="gender" class="block mt-1 w-full" type="text" name="gender" :value="old('gender', $registration->patient->gender == 'L' ? 'Laki-Laki' : 'Perempuan')" required autofocus autocomplete="gender" disabled />
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="birth_date" :value="__('Tanggal Lahir')" />
                                <x-text-input id="birth_date" class="block mt-1 w-full" type="text" name="birth_date" :value="old('birth_date', $registration->patient->birth_date)" required autofocus autocomplete="birth_date" disabled />
                                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="phone_number" :value="__('No Handphone')" />
                                <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number', $registration->patient->phone_number)" required autofocus autocomplete="phone_number" disabled />
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                            </div>
                        </div>

                        <div class="border-t mt-8 pt-4 border-gray-900/10">
                            <h2 class="text-base/7 font-semibold text-gray-900">Registrasi</h2>
                            <p class="mt-1 text-sm/6 text-gray-600">Informasi registrasi pasien.</p>
                        </div>

                        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <x-input-label for="registration_number" :value="__('No Registrasi')" />
                                <x-text-input id="registration_number" class="block mt-1 w-full" type="text" name="registration_number" :value="old('registration_number', $registration->registration_number)" required autofocus autocomplete="registration_number" disabled />
                                <x-input-error :messages="$errors->get('registration_number')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="created_at" :value="__('Tanggal Registrasi')" />
                                <x-text-input id="created_at" class="block mt-1 w-full" type="text" name="created_at" :value="old('created_at', \Carbon\Carbon::parse($registration->created_at)->format('d M Y, H:i'))" required autofocus autocomplete="created_at" disabled />
                                <x-input-error :messages="$errors->get('created_at')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="patient_weight" :value="__('Berat Badan')" />
                                <x-text-input id="patient_weight" class="block mt-1 w-full" type="text" name="patient_weight" :value="old('patient_weight', $registration->patient_weight)" required autofocus autocomplete="patient_weight" disabled />
                                <x-input-error :messages="$errors->get('patient_weight')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="patient_blood_pressure" :value="__('Tekanan Darah')" />
                                <x-text-input id="patient_blood_pressure" class="block mt-1 w-full" type="text" name="patient_blood_pressure" :value="old('patient_blood_pressure', $registration->patient_blood_pressure)" required autofocus autocomplete="patient_blood_pressure" disabled />
                                <x-input-error :messages="$errors->get('patient_blood_pressure')" class="mt-2" />
                            </div>
                        </div>

                        <div class="pt-4">
                            <x-input-label for="patient_complaint" :value="__('Keluhan')" />
                            <x-text-input id="patient_complaint" class="block mt-1 w-full" type="text" name="patient_complaint" :value="old('patient_complaint', $registration->patient_complaint)" required autofocus autocomplete="patient_complaint" disabled />
                            <x-input-error :messages="$errors->get('patient_complaint')" class="mt-2" />
                        </div>

                        <div class="pt-4 pb-5">
                            <x-input-label for="diagnostic_result" :value="__('Hasil Diagnosa')" />
                            <x-text-input id="diagnostic_result" class="block mt-1 w-full" type="text" name="diagnostic_result" :value="old('diagnostic_result', $registration->diagnostic_result)" required autofocus autocomplete="diagnostic_result" disabled />
                            <x-input-error :messages="$errors->get('diagnostic_result')" class="mt-2" />
                        </div>

                        <div class="border-t mt-8 pt-4 border-gray-900/10">
                            <h2 class="text-base/7 font-semibold text-gray-900">Order</h2>
                            <p class="mt-1 text-sm/6 text-gray-600">Informasi order pasien.</p>
                        </div>

                        <div class="mt-4">
                            <div class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                                <div class="overflow-auto max-h-[400px]">
                                    <table class="w-full text-left table-auto min-w-max text-slate-800">
                                        <thead>
                                            <tr class="text-slate-500 border-b border-slate-300 bg-slate-50">
                                                <th class="p-4">
                                                    <p class="text-sm leading-none font-bold">
                                                        Nama Produk
                                                    </p>
                                                </th>
                                                <th class="p-4">
                                                    <p class="text-sm leading-none font-bold">
                                                        Jumlah
                                                    </p>
                                                </th>
                                                <th class="p-4">
                                                    <p class="text-sm leading-none font-bold">
                                                        Harga
                                                    </p>
                                                </th>
                                                <th class="p-4">
                                                    <p class="text-sm leading-none font-bold">
                                                        Tanggal Order
                                                    </p>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($registration->orders as $item)
                                                <tr class="hover:bg-slate-50">
                                                    <td class="p-4">
                                                        <p class="text-sm font-bold">
                                                            {{ $item->product->name }}
                                                        </p>
                                                    </td>
                                                    <td class="p-4">
                                                        <p class="text-sm font-bold">
                                                            {{ $item->qty }}
                                                        </p>
                                                    </td>
                                                    <td class="p-4">
                                                        <p class="text-sm">
                                                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                        </p>
                                                    </td>
                                                    <td class="p-4">
                                                        <p class="text-sm font-bold">
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="hover:bg-slate-50">
                                                    <th class="p-4" colspan="4">
                                                        <p class="text-sm text-center font-bold">
                                                            Belum Ada Data
                                                        </p>
                                                    </th>
                                                </tr>
                                            @endforelse
                                            <tr class="hover:bg-slate-50">
                                                <th class="p-4" colspan="2">
                                                    <p class="text-sm font-bold">
                                                        Total
                                                    </p>
                                                </th>
                                                <td class="p-4">
                                                    <p class="text-sm font-bold">
                                                        Rp {{ number_format($registration->totalbiaya, 0, ',', '.') }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>