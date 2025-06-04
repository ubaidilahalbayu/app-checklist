<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-2">
                    <div class="flex justify-center items-center max-h-screen bg-gray-100">
                        <div class="w-max rounded-3xl bg-white p-4 shadow-lg relative">
                            <!-- Tanggal dan waktu -->
                            <div class="text-center mt-2 text-2xl font-bold text-gray-800">
                                <div x-data="{ 
                                    hari: new Date().toLocaleDateString('id-ID', { weekday: 'long' }), 
                                    tanggal: new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) 
                                }">
                                    <div class="text-center text-2xl text-gray-800" style="font-family: 'Oswald', sans-serif;" x-text="`${hari}, ${tanggal}`"></div>
                                </div>                                
                            </div>
                            <div class="text-center text-black">
                                <div x-data="{ time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) }"
                                    x-init="setInterval(() => time = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}), 1000)">
                                    <div class="text-center font-extrabold text-black" style="font-family: 'Oswald', sans-serif; font-style: normal; font-size: 50px;" x-text="time"></div>
                                </div>
                            </div>
                    
                            <!-- Logo atau Gambar -->
                            <div class="flex justify-center mt-6">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="h-50">
                            </div>
                    
                            <!-- Nama Aplikasi -->
                            <div class="w-full text-center text-xl mt-6" style="font-family: 'Playfair Display', sans-serif;">
                                CAPEDE <br> Checklist Alat Pelindung Diri
                            </div>
                        </div>
                    </div>
    </div>
</x-app-layout>
