<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrasi Pasien') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 mb-6 max-h-screen">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h2 class="text-base/7 font-semibold text-gray-900">Biodata Pasien</h2>
                            <p class="text-sm/6 text-gray-600">Pastikan data diri pasien benar dan valid.</p>
                        </div>

                        <a href="{{ route('patient') }}" class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Pasien Lama
                        </a>
                    </div>

                    <form method="POST" action="{{ isset($selectedPatient) ? route('store_patient_exist_registration', Illuminate\Support\Facades\Crypt::encrypt($selectedPatient->id)) : route('store_registration') }}">
                        @csrf
                        @if(isset($selectedPatient))
                            @method('PUT')
                        @endif

                        <div class="mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <x-input-label for="name" :value="__('Nama Pasien')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $selectedPatient->name ?? '')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="birth_date" :value="__('Tanggal Lahir')" />
                                <input class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', isset($selectedPatient) ? \Carbon\Carbon::parse($selectedPatient->birth_date)->format('Y-m-d') : '') }}" required>
                                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="gender" :value="__('Jenis Kelamin')" />

                                <div class="grid grid-cols-1">
                                    <select id="gender" name="gender" autocomplete="gender" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                                        <option value="L" {{ old('gender', isset($selectedPatient) ? $selectedPatient->gender : '') === 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="P" {{ old('gender', isset($selectedPatient) ? $selectedPatient->gender : '') === 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <x-input-label for="phone_number" :value="__('No Handphone')" />
                                <x-text-input id="phone_number" class="block mt-1 w-full" type="number" name="phone_number" :value="old('phone_number', isset($selectedPatient) ? $selectedPatient->phone_number : '')" required autofocus autocomplete="phone_number" />
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-3">
                                {{ __('Registrasi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>