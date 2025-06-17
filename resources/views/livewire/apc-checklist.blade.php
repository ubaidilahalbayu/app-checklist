<div class="min-w-md mx-auto p-4 bg-white rounded-xl shadow-lg" x-data="cameraHandler()">
    <p class="text-center text-blue-600 font-semibold mb-4">Check APD</p>

    @if ($sudahChecklist)
        <div class="flex flex-col items-center justify-center mt-10 p-10">
            <img src="https://img.icons8.com/fluency/96/checked.png" alt="Checklist" class="w-32 h-32 bg-gray-100 p-4 rounded-xl shadow" />
            @if (!session()->has('success'))
                <p class="text-green-600 mt-4 font-semibold">Checklist Sesi-{{$sesi}} hari ini sudah diisi</p>
            @endif
        </div>
    @else
        {{-- Jika belum ambil foto, tampilkan checklist --}}
        {{-- @if (!$photoPreviewUrl) --}}
        <div x-show="previewPhoto">
            <ul class="space-y-3">
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
                <div class="text-center mt-3">
                    <button @click="startCamera"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Lanjut Ambil Foto
                    </button>
                </div>
            </ul>
        </div>
        {{-- <template x-if="previewPhoto"> --}}
            {{-- <div class="mt-6" x-show="showCamera">
                <input x-ref="cameraInput" type="file" accept="image/*" capture="environment" wire:model="photo" class="hidden">
                @error('photo') <p class="text-center text-red-500">{{ $message }}</p> @enderror
            </div> --}}
            <!-- Video Preview -->
            <div x-show="showVideo">
                <video x-ref="video" autoplay class="border rounded w-full max-w-md"></video>
                <p class="text-center text-blue-600 font-semibold mt-4">Foto Seluruh Badan!</p>
                <div class="mt-4 flex justify-between">
                    <button
                        @click="takePhoto"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Ambil Foto
                    </button>
                    <button
                        @click="switchCamera"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Switch
                    </button>
                    <button
                        @click="backChecklist"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        Kembali
                    </button>
                </div>
            </div>
            <div x-show="photoDataUrl">
                <p class="mt-4 font-bold">Hasil Foto:</p>
                <canvas x-ref="canvas" class="border mt-2 flex justify-center"></canvas>
                <div class="mt-4 flex justify-between">
                    {{-- Tombol simpan --}}
                    <button @click="sendToLivewire"
                    {{-- wire:click="save" --}}
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Simpan Checklist
                    </button>
                    <button @click="backChecklist" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Kembali
                    </button>
                </div>
            </div>
        {{-- </template> --}}
        {{-- @else --}}
            {{-- Tampilkan foto preview setelah diambil --}}
            {{-- <div x-show="photoDataUrl">
                <p class="mt-4 font-bold">Hasil Foto:</p>
                <canvas x-ref="canvas" class="border mt-2"></canvas>
            </div> --}}
            {{-- <div class="mt-4">
                <p class="mb-2 font-medium">Foto diambil:</p>
                <img src="{{ $photoPreviewUrl }}" alt="Preview" class="rounded shadow w-64">
            </div> --}}

            {{-- <div class="mt-4 flex justify-between"> --}}
                {{-- Tombol simpan --}}
                {{-- <button @click="sendToLivewire" --}}
                {{-- wire:click="save" --}}
                {{-- class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Simpan Checklist
                </button>
                <button wire:click="backChecklist" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Kembali
                </button>
            </div>
        @endif --}}
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
<script>
    function cameraHandler() {
        return {
            showVideo: false,
            previewPhoto: true,
            photoDataUrl: '',
            devices: [],
            currentDeviceIndex: 0,
            stream: null,

            async startCamera() {
                this.showVideo = true;
                this.previewPhoto = false;

                // Ambil daftar kamera jika belum ada
                if (this.devices.length === 0) {
                    const allDevices = await navigator.mediaDevices.enumerateDevices();
                    this.devices = allDevices.filter(device => device.kind === 'videoinput');
                }

                // Stop stream sebelumnya jika ada
                if (this.stream) {
                    this.stream.getTracks().forEach(track => track.stop());
                }

                const deviceId = this.devices[this.currentDeviceIndex]?.deviceId || null;

                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: deviceId ? { deviceId: { exact: deviceId } } : true
                    });

                    this.stream = stream;
                    this.$refs.video.srcObject = stream;
                } catch (err) {
                    alert("Tidak bisa mengakses kamera: " + err);
                }
            },

            switchCamera() {
                if (this.devices.length < 2) {
                    alert("Tidak ada kamera lain yang tersedia.");
                    return;
                }

                this.currentDeviceIndex = (this.currentDeviceIndex + 1) % this.devices.length;
                this.startCamera();
            },

            takePhoto() {
                this.showVideo = false;
                this.previewPhoto = false;
                const video = this.$refs.video;
                const canvas = this.$refs.canvas;
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0);
                this.photoDataUrl = canvas.toDataURL('image/png');
            },

            backChecklist() {
                if (this.stream) {
                    this.stream.getTracks().forEach(track => track.stop());
                    this.stream = null;
                }
                this.showVideo = false;
                this.previewPhoto = true;
                this.photoDataUrl = '';
            },

            sendToLivewire() {
                @this.call('save', this.photoDataUrl);
            }
        };
    }
</script>