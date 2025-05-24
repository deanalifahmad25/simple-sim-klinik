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
            {{ __('Diagnosa') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 mb-6 max-h-screen">
                    <div>
                        <h2 class="text-base/7 font-semibold text-gray-900">Diagnosa Pasien</h2>
                    </div>

                    <form method="POST" action="{{ route('store_diagnose', Illuminate\Support\Facades\Crypt::encrypt($registration->registration_number)) }}">
                        @csrf
                        @method('PUT')

                        <div class="mt-2">
                            <x-input-label for="patient_complaint" :value="__('Keluhan Pasien')" />
                            <x-text-input id="patient_complaint" class="block mt-1 w-full" type="text" name="patient_complaint" :value="old('patient_complaint', $registration->patient_complaint)" required autofocus autocomplete="patient_complaint" />
                            <x-input-error :messages="$errors->get('patient_complaint')" class="mt-2" />
                        </div>

                        <div class="mt-2">
                            <x-input-label for="diagnostic_result" :value="__('Hasil Diagnosa')" />
                            <x-text-input id="diagnostic_result" class="block mt-1 w-full" type="text" name="diagnostic_result" :value="old('diagnostic_result', $registration->diagnostic_result)" required autofocus autocomplete="diagnostic_result" />
                            <x-input-error :messages="$errors->get('diagnostic_result')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-3">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>