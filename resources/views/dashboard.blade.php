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
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="hidden mt-4 mb-4 sm:flex sm:justify-center">
                    <div class="relative rounded-full px-3 py-1 text-sm/6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                        Selamat Datang <span class="font-semibold text-blue-600"><span class="font-semibold text-blue-600 absolute inset-0" aria-hidden="true"></span>{{ Auth::user()->name }} <span aria-hidden="true">👋</span></span>
                    </div>
                </div>

                <div class="px-6 mb-6 max-h-screen">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-base/7 font-semibold text-gray-900">Daftar Registrasi Pasien Hari Ini</h3>

                        @if (Auth::user()->can('registration'))
                            <a href="{{ route('registration') }}" class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Registrasi
                            </a>
                        @endif
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

                                                @if (Auth::user()->can('vital_sign'))
                                                    <a href="{{ route('vital_sign', ['registration' => Illuminate\Support\Facades\Crypt::encrypt($item->registration_number)]) }}" class="text-sm text-green-500 font-semibold ml-2">
                                                        Vital Sign
                                                    </a>
                                                @endif

                                                @if (Auth::user()->can('diagnose'))
                                                    <a href="{{ route('diagnose', ['registration' => Illuminate\Support\Facades\Crypt::encrypt($item->registration_number)]) }}" class="text-sm text-green-500 font-semibold ml-2">
                                                        Diagnosa
                                                    </a>
                                                @endif

                                                @if (Auth::user()->can('order'))
                                                    <a href="{{ route('order', ['registration' => Illuminate\Support\Facades\Crypt::encrypt($item->registration_number)]) }}" class="text-sm text-green-500 font-semibold ml-2">
                                                        Order Obat
                                                    </a>
                                                @endif

                                                @if (Auth::user()->can('registration'))
                                                    <form method="post" action="{{ route('destroy_registration', ['patient' => Illuminate\Support\Facades\Crypt::encrypt($item->id)]) }}">
                                                        @csrf
                                                        @method('delete')

                                                        <button type="submit" class="text-sm text-red-500 font-semibold ml-2">Hapus</button>
                                                    </form>
                                                @endif
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
