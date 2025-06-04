<div class="min-w-md mx-auto p-4 bg-white rounded-xl shadow-lg">
    <p class="text-center text-blue-600 font-semibold mb-4">Check Your APD!</p>

    @if ($sudahChecklist)
        <div class="flex flex-col items-center justify-center mt-10 p-10">
            <img src="https://img.icons8.com/fluency/96/checked.png" alt="Checklist" class="w-32 h-32 bg-gray-100 p-4 rounded-xl shadow" />
            @if (!session()->has('success'))
                <p class="text-green-600 mt-4 font-semibold">Checklist hari ini sudah diisi</p>
            @endif
        </div>
    @else
        {{-- Jika belum ambil foto, tampilkan checklist --}}
        @if (!$photoPreviewUrl)
            <ul class="space-y-3" x-data="{ showCamera: false }">
                @foreach($items as $index => $item)
                    <li class="flex items-center mb-3 ms-3">
                        <input 
                            type="checkbox"
                            wire:model="checked"
                            wire:change="proses()"
                            value="{{ $item }}"
                            id="item-{{ $index }}"
                            class="form-checkbox h-5 w-5 text-blue-600 me-3"
                        />
                        <label for="item-{{ $index }}" class="text-gray-800">{{ $item }}</label>
                    </li>
                @endforeach
            </ul>

            <div class="text-center mt-3">
                <button x-on:click="
                showCamera = true;
                $nextTick(() => { $refs.cameraInput.click() })
                " class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Lanjut Ambil Foto
                </button>
            </div>

            <div class="mt-6" x-show="showCamera">
                <input x-ref="cameraInput" type="file" accept="image/*" capture="environment" wire:model="photo" class="hidden">
                @error('photo') <p class="text-center text-red-500">{{ $message }}</p> @enderror
            </div>
        @else
            {{-- Tampilkan foto preview setelah diambil --}}
            <div class="mt-4">
                <p class="mb-2 font-medium">Foto diambil:</p>
                <img src="{{ $photoPreviewUrl }}" alt="Preview" class="rounded shadow w-64">
            </div>

            <div class="mt-4 flex justify-between">
                {{-- Tombol simpan --}}
                <button wire:click="save" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Simpan Checklist
                </button>
                <button wire:click="backChecklist" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Kembali
                </button>
            </div>
        @endif
    @endif

    @if (session()->has('success'))
        <div class="mt-4 text-center text-green-600">{{ session('success') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="mt-4 text-center text-red-600">{{ session('error') }}</div>
    @endif
    {{-- <div class="mt-6 text-center" x-data="{ show: false }">
        <button @click="show = !show" class="text-sm text-blue-600 hover:underline">
            Lihat hasil checklist
        </button>
        <div x-show="show" x-transition class="mt-2 text-sm text-gray-700">
            @if(count($checked))
                <ul class="mt-2 list-disc list-inside text-left">
                    @foreach($checked as $check)
                        <li>{{ $check }}</li>
                    @endforeach
                </ul>
            @else
                <p class="italic">Belum ada yang dicentang.</p>
            @endif
        </div>
    </div> --}}
    {{-- @php
        dd(auth()->user()->id);
    @endphp --}}
</div>
