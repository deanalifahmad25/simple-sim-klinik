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
            {{ __('Vital Sign') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 mb-6 max-h-screen">
                    <div>
                        <h2 class="text-base/7 font-semibold text-gray-900">Vital Sign</h2>
                    </div>

                    <form method="POST" action="{{ route('store_vital_sign', Illuminate\Support\Facades\Crypt::encrypt($registration->registration_number)) }}">
                        @csrf
                        @method('PUT')

                        <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <x-input-label for="patient_weight" :value="__('Berat Badan')" />
                                <x-text-input id="patient_weight" class="block mt-1 w-full" type="number" name="patient_weight" :value="old('patient_weight', $registration->patient_weight)" required autofocus autocomplete="patient_weight" />
                                <x-input-error :messages="$errors->get('patient_weight')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="patient_blood_pressure" :value="__('Tekanan Darah')" />
                                <x-text-input id="patient_blood_pressure" class="block mt-1 w-full" type="text" name="patient_blood_pressure" :value="old('patient_blood_pressure', $registration->patient_blood_pressure)" required autofocus autocomplete="patient_blood_pressure" />
                                <x-input-error :messages="$errors->get('patient_blood_pressure')" class="mt-2" />
                            </div>
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