<div class="container-xxl flex-grow-1 container-p-y bg-[#25293c] min-h-screen text-gray-200 px-2 md:px-6">
    <div class="max-w-xl mx-auto mt-12 bg-[#2f3247] rounded-2xl shadow-md p-6">
        <h2 class="text-2xl font-semibold mb-6 text-center">تنظیمات حساب کاربری ⚙️</h2>

        @if ($successMessage)
            <div class="alert alert-success text-center mb-4">
                {{ $successMessage }}
            </div>
        @endif

        <form wire:submit.prevent="update">
            <div class="mb-4">
                <label for="name" class="form-label">نام و نام خانوادگی</label>
                <input wire:model="name" type="text" id="name" class="form-control bg-[#1e2235] border-0 text-gray-200"
                       placeholder="مثلاً علی رضایی">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-3">
                <label class="form-label">آدرس</label>
                <small class="text-warning">فقط انتخاب آدرس در محدوده شهر سبزوار مجاز است.</small>
                <textarea wire:model="address" id="address" rows="3" class="form-control" placeholder="آدرس انتخاب‌شده از نقشه"></textarea>
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <div id="map" wire:ignore class="w-full h-96 rounded-xl mt-4"></div>

            <div class="d-grid mt-4">
                <button type="submit"
                        wire:loading.attr="disabled"
                        class="btn btn-primary w-100 waves-effect waves-light">
                    <span wire:loading.remove>ذخیره تغییرات</span>
                    <span wire:loading>در حال ذخیره...</span>
                </button>
            </div>
        </form>
    </div>
</div>


@script
<script>
    document.addEventListener('livewire:navigated', () => {
        const mapContainer = document.getElementById('map');
        if (!mapContainer) return;

        // اگر نقشه قبلی وجود داره، حذفش کن تا دوباره ساخته بشه
        if (mapContainer._leaflet_id) {
            mapContainer._leaflet_id = null;
            mapContainer.innerHTML = "";
        }

        const webMapKey = "web.5459fd3d93fb49eaace1fc0eec28633c";
        const serviceKey = "service.f0b7f9c744614956824d26d5b0d03ed6";

        // مختصات سبزوار
        const sabzevar = [36.213, 57.681];
        const map = L.map('map').setView(sabzevar, 14);

        // لایه نقشه
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let marker;

        // محدود کردن محدوده به سبزوار
        const bounds = L.latLngBounds(
            [36.15, 57.55],
            [36.28, 57.78]
        );
        map.setMaxBounds(bounds);
        map.on('drag', () => map.panInsideBounds(bounds, { animate: true }));

        // کلیک روی نقشه
        map.on('click', (e) => {
            const lat = e.latlng.lat.toFixed(6);
            const lng = e.latlng.lng.toFixed(6);

            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                const icon = L.icon({
                    iconUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-icon.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png',
                    shadowSize: [41, 41]
                });
                marker = L.marker(e.latlng, { icon }).addTo(map);
            }

            fetch(`https://api.neshan.org/v5/reverse?lat=${lat}&lng=${lng}`, {
                headers: { 'Api-Key': serviceKey }
            })
                .then(res => res.json())
                .then(data => {
                    console.log("✅ داده بازگشتی از نشان:", data);
                    let address = data.formatted_address || `${lat}, ${lng}`;
                    address = address
                        .replace(/, ایران/g, '')
                        .replace(/استان [^,]+, /g, '');

                    const addressEl = document.getElementById('address');
                    if (addressEl) addressEl.value = address;

                    Livewire.dispatch('locationSelected', { lat, lng, address });
                })
                .catch(err => console.error("❌ خطا در Neshan Reverse:", err));
        });
    });
</script>
@endscript

