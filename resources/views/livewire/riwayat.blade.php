<div x-data="{ tab: 'berlangsung' , linkNext: '{{ $dataBerlangsung->nextPageUrl() }}' , hasMoreNext: {{ $dataBerlangsung->hasMorePages() ? 'true' : 'false' }} , linkBefore: '{{ $dataBerlangsung->previousPageUrl() }}' , hasMoreBefore: {{ $dataBerlangsung->onFirstPage() ? 'false' : 'true' }} }" class="min-w-md mx-auto p-4 bg-white rounded-xl shadow-lg">
    <!-- Tabs -->
    <div class="mb-4">
        <div class="flex gap-2">
            <button @click="tab = 'berlangsung'; linkNext= '{{ $dataBerlangsung->nextPageUrl() }}'; hasMoreNext= {{ $dataBerlangsung->hasMorePages() ? 'true' : 'false' }}; linkBefore= '{{ $dataBerlangsung->previousPageUrl() }}'; hasMoreBefore= {{ $dataBerlangsung->onFirstPage() ? 'false' : 'true' }};" 
                :class="tab === 'berlangsung' ? 'bg-gray-500 text-white' : 'bg-gray-100'" 
                class="px-3 py-1 rounded-full text-sm font-semibold">
                Berlangsung
            </button>
            <button @click="tab = 'selesai'; linkNext= '{{ $dataSelesai->nextPageUrl() }}'; hasMoreNext= {{ $dataSelesai->hasMorePages() ? 'true' : 'false' }}; linkBefore= '{{ $dataSelesai->previousPageUrl() }}'; hasMoreBefore= {{ $dataSelesai->onFirstPage() ? 'false' : 'true' }};" 
                :class="tab === 'selesai' ? 'bg-gray-500 text-white' : 'bg-gray-100'" 
                class="px-3 py-1 rounded-full text-sm font-semibold">
                Selesai
            </button>
        </div>

        <!-- Isi Riwayat -->
        <div class="mt-4 space-y-2 overflow-y-auto h-80">
            <template x-if="tab === 'berlangsung'">
                <div class="mt-4 space-y-2 overflow-y-auto h-80" x-data="{ 
                    hari: new Date().toLocaleDateString('id-ID', { weekday: 'long' }), 
                    tanggal: new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) 
                }">
                    <div class="px-4 py-3" x-text="`${hari}, ${tanggal}`"></div>
                    @foreach ($dataBerlangsung as $index => $data)
                        <div x-data="{ open: false }" class="bg-gray-100 rounded-xl px-4 py-3">
                            <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
                                <div>
                                    <span class="font-semibold">{{ $data->name }}</span>
                                    @if ($data->sudah)
                                        <span class="text-sm text-green-600 ml-1">Sudah Checklist</span>
                                    @else
                                        <span class="text-sm text-red-600 ml-1">Belum Checklist</span>
                                    @endif
                                </div>
                                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            </div>
                            <!-- Dropdown detail -->
                            <div x-show="open" x-transition class="mt-2 text-sm text-gray-700">
                                @if ($data->sudah)
                                <div class="px-3 py-3 flex justify-between">
                                    <p><b>Jam:</b> {{ $data->jam }} WIB</p>
                                <button 
                                    class="text-blue-600 underline cursor-pointer"
                                    x-data 
                                    @click="$dispatch('open-modal', '{{ 'lihat-foto-' . $data->id }}')"
                                >
                                    Lihat Foto
                                </button>
                                </div>
                                
                                    <ul class="space-y-3">
                                        @foreach (json_decode($data->checklist) as $key => $item)
                                            <li class="flex items-center mb-3 ms-3">
                                                <input type="checkbox" value="{{ $item }}" id="item-{{ $index }}"class="form-checkbox h-5 w-5 text-blue-600 me-3" disabled checked/>
                                                <label for="item-{{ $index }}" class="text-gray-800">{{ $item }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <!-- Komponen Modal -->
                                    <x-modal name="lihat-foto-{{ $data->id }}" :show="false" maxWidth="2xl">
                                        <div class="p-4 text-center">
                                            <h2 class="text-lg font-bold mb-4">Foto: {{ $data->name }}</h2>
                                            <img src="{{ $data->photo_url }}" alt="Foto {{ $data->name }}" class="mx-auto max-h-[80vh] object-contain rounded">
                                            <button 
                                                class="mt-6 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition"
                                                @click="$dispatch('close-modal', '{{ 'lihat-foto-' . $data->id }}')"
                                            >
                                                Tutup
                                            </button>
                                        </div>
                                    </x-modal>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </template>

            <template x-if="tab === 'selesai'">
                <div class="mt-4 space-y-2 overflow-y-auto h-80">
                    @if ($isAdmin === 1)
                        <div class="flex space-x-4">
                            <div class="ml-2">
                                <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" wire:model="start"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                            </div>
                            <div class="ml-2">
                                <label class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" wire:model="end"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                            </div>
                        </div>
                        <button
                            wire:click="export"
                            class="ml-2 bg-gray-500 text-white px-4 py-2 rounded"
                        >
                            Download
                        </button>
                    @endif
                @forelse ($dataSelesai as $index => $data)
                    <div x-data="{ open: false }" class="bg-gray-100 rounded-xl px-4 py-3">
                        <div class="flex justify-between items-center cursor-pointer" @click="open = !open">
                            <div>
                                <span class="font-semibold">{{ $data->name }}</span>
                                <span class="font-bold text-blue-600">--</span>
                                <span class="text-sm">{{ $data->tanggal_indo }}</span>
                            </div>
                            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                        </div>
                        <!-- Dropdown detail -->
                        <div x-show="open" x-transition class="mt-2 text-sm text-gray-700">
                            <div class="px-3 py-3 flex justify-between">
                                <p><b>Jam:</b> {{ $data->jam }} WIB</p>
                            <button 
                                class="text-blue-600 underline cursor-pointer"
                                x-data 
                                @click="$dispatch('open-modal', '{{ 'lihat-foto-' . $data->id . $data->tanggal_indo }}')"
                            >
                                Lihat Foto
                            </button>
                            </div>
                            
                            <ul class="space-y-3">
                                @foreach ($data->checklist_array as $key => $item)
                                    <li class="flex items-center mb-3 ms-3">
                                        <input type="checkbox" value="{{ $item }}" id="item-{{ $index }}"class="form-checkbox h-5 w-5 text-blue-600 me-3" disabled checked/>
                                        <label for="item-{{ $index }}" class="text-gray-800">{{ $item }}</label>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- Komponen Modal -->
                            <x-modal name="lihat-foto-{{ $data->id . $data->tanggal_indo }}" :show="false" maxWidth="2xl">
                                <div class="p-4 text-center">
                                    <h2 class="text-lg font-bold mb-4">Foto: {{ $data->name }}</h2>
                                    <img src="{{ $data->photo_url }}" alt="Foto {{ $data->name }}" class="mx-auto max-h-[80vh] object-contain rounded">
                                    <button 
                                        class="mt-6 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition"
                                        @click="$dispatch('close-modal', '{{ 'lihat-foto-' . $data->id . $data->tanggal_indo }}')"
                                    >
                                        Tutup
                                    </button>
                                </div>
                            </x-modal>
                        </div>
                    </div>                    
                @empty
                    <div class="text-gray-500 text-center mt-20">Belum ada data selesai.</div>
                @endforelse
                </div>         
            </template>
        </div>
    </div>
    {{-- <div x-show="hasMoreNext"> --}}
        <div class="mt-4 flex justify-end">
            <a :href="linkBefore" x-show="hasMoreBefore"
            class="text-blue-600 underline px-4 py-2">
                {{'<<<prev'}}
            </a>
            <a :href="linkNext" x-show="hasMoreNext"
            class="text-blue-600 underline px-4 py-2">
                next>>>
            </a>
        </div>
    {{-- </div> --}}
</div>