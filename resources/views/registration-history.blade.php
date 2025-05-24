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
            {{ __('History Registrasi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 mb-6 max-h-screen">
                    <div class="flex items-center justify-between my-2">
                        <h3 class="text-base/7 font-semibold text-gray-900">Daftar Registrasi Pasien</h3>

                        <form method="POST" action="{{ route('search_registration_history') }}" class="flex items-center justify-between my-2 gap-2">
                            @csrf

                            <div>
                                <x-input-label for="patient" :value="__('Pasien')" />

                                <div class="grid grid-cols-1">
                                    <select id="patient" name="patient" autocomplete="patient" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                        <option disaled value="">-- Pilih Pasien --</option>
                                        @forelse ($patient as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @empty
                                            <option disabled>Belum Ada Pasien</option>
                                        @endforelse
                                    </select>
                                </div>

                                <x-input-error :messages="$errors->get('patient')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="registration_date" :value="__('Tanggal Registrasi')" />
                                <input class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" type="date" id="registration_date" name="registration_date">
                                <x-input-error :messages="$errors->get('registration_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-primary-button class="mt-6">
                                    {{ __('Cari') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <div class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                        <div class="overflow-auto max-h-[400px]">
                            <table class="w-full text-left table-auto min-w-max text-slate-800">
                                <thead>
                                    <tr class="text-slate-500 border-b border-slate-300 bg-slate-50">
                                        <th class="p-4">
                                            <p class="text-sm leading-none font-bold">
                                                Nama Pasien
                                            </p>
                                        </th>
                                        <th class="p-4">
                                            <p class="text-sm leading-none font-bold">
                                                Jenis Kelamin
                                            </p>
                                        </th>
                                        <th class="p-4">
                                            <p class="text-sm leading-none font-bold">
                                                No Registrasi
                                            </p>
                                        </th>
                                        <th class="p-4">
                                            <p class="text-sm leading-none font-bold">
                                                Tanggal Registrasi
                                            </p>
                                        </th>
                                        <th class="p-4">
                                            <p class="text-sm leading-none font-bold">
                                                Keluhan
                                            </p>
                                        </th>
                                        <th class="p-4">
                                            <p class="text-sm leading-none font-bold">
                                                Hasil Diagnosa
                                            </p>
                                        </th>
                                        <th class="p-4">
                                            <p class="text-sm leading-none font-bold">
                                                Total Biaya
                                            </p>
                                        </th>
                                        <th class="p-4">
                                            <p>
                                            Aksi
                                            </p>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($registration as $item)
                                        <tr class="hover:bg-slate-50">
                                            <td class="p-4">
                                                <p class="text-sm font-bold">
                                                    {{ $item->patient->name }}
                                                </p>
                                            </td>
                                            <td class="p-4">
                                                <p class="text-sm">
                                                    {{ $item->patient->gender == 'L' ? 'Laki-Laki' : 'Perempuan' }}
                                                </p>
                                            </td>
                                            <td class="p-4">
                                                <p class="text-sm">
                                                    {{ $item->registration_number }}
                                                </p>
                                            </td>
                                            <td class="p-4">
                                                <p class="text-sm">
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}
                                                </p>
                                            </td>
                                            <td class="p-4">
                                                <p class="text-sm">
                                                    {{ $item->patient_complaint ? $item->patient_complaint : '-' }}
                                                </p>
                                            </td>
                                            <td class="p-4">
                                                <p class="text-sm">
                                                    {{ $item->diagnostic_result ? $item->diagnostic_result : '-' }}
                                                </p>
                                            </td>
                                            <td class="p-4">
                                                <p class="text-sm">
                                                    Rp {{ number_format($item->totalbiaya, 0, ',', '.') }}
                                                </p>
                                            </td>
                                            <td class="p-4">
                                                <a href="{{ route('registration_history_detail', ['registration' => Illuminate\Support\Facades\Crypt::encrypt($item->registration_number)]) }}" class="text-sm text-blue-500 font-semibold ml-2">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="hover:bg-slate-50">
                                            <th class="p-4" colspan="6">
                                                <p class="text-sm text-center font-bold">
                                                    Belum Ada Data
                                                </p>
                                            </th>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
