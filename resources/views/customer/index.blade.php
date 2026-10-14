<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tiket Konser & Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6 font-sans">
    <div class="max-w-5xl mx-auto">

        <!-- HEADER -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Katalog Konser & Event Musik
            </h1>
            <p class="text-gray-500 text-sm mt-1">
                Pilih event yang kau mau, masukkan data diri, dan pesan tiketnya sekarang!
            </p>
        </div>

        <!-- NOTIFIKASI SUCCESS -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 text-center font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- NOTIFIKASI ERROR -->
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 text-center font-semibold">
                {{ session('error') }}
            </div>
        @endif

        <!-- NOTIFIKASI VALIDASI -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 font-semibold">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FILTER KATEGORI -->
        <div class="flex flex-wrap justify-center gap-3 mb-8">
            <button
                type="button"
                onclick="filterCategory('all', this)"
                class="btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-blue-600 text-white shadow-md">
                Semua Event
            </button>

            <button
                type="button"
                onclick="filterCategory('Musik', this)"
                class="btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-white text-gray-600 hover:bg-gray-200 border">
                Musik
            </button>

            <button
                type="button"
                onclick="filterCategory('Festival', this)"
                class="btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-white text-gray-600 hover:bg-gray-200 border">
                Festival
            </button>

            <button
                type="button"
                onclick="filterCategory('Seminar', this)"
                class="btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-white text-gray-600 hover:bg-gray-200 border">
                Seminar
            </button>
        </div>

        <!-- FORM PEMESANAN -->
        <form
            id="orderForm"
            action="{{ route('customer.checkout') }}"
            method="POST">

            @csrf

            <!-- 1. INFORMASI PEMESAN -->
            <div class="bg-white p-6 rounded-xl shadow-sm border mb-6">
                <h2 class="text-lg font-bold text-gray-700 mb-4 pb-2 border-b">
                    1. Informasi Data Diri Pemesan
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label
                            for="customer_name"
                            class="block text-sm font-semibold text-gray-600 mb-1">
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            id="customer_name"
                            name="customer_name"
                            value="{{ old('customer_name') }}"
                            required
                            placeholder="Masukkan nama lengkap pemesan"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label
                            for="customer_email"
                            class="block text-sm font-semibold text-gray-600 mb-1">
                            Alamat Email
                        </label>

                        <input
                            type="email"
                            id="customer_email"
                            name="customer_email"
                            value="{{ old('customer_email') }}"
                            required
                            placeholder="contoh@email.com"
                            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                </div>
            </div>

            <!-- 2. PILIH EVENT -->
            <h2 class="text-lg font-bold text-gray-700 mb-4">
                2. Pilih Tiket Konser & Event
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                @foreach($events as $event)
                    <div
                        class="event-card bg-white rounded-xl shadow-sm border overflow-hidden flex flex-col justify-between"
                        data-category="{{ $event->category }}">

                        <div>
                            <!-- POSTER EVENT -->
                            @if($event->image)
                                <img
                                    src="{{ asset('storage/' . $event->image) }}"
                                    alt="{{ $event->title }}"
                                    class="w-full h-40 object-cover">
                            @else
                                <div class="bg-gray-200 h-40 flex items-center justify-center text-gray-400 font-medium">
                                    Tanpa Poster
                                </div>
                            @endif

                            <!-- INFORMASI EVENT -->
                            <div class="p-4">
                                <div class="flex justify-between items-center mb-2 gap-2">

                                    <span class="text-xs bg-blue-100 text-blue-700 font-semibold px-2.5 py-0.5 rounded">
                                        {{ $event->category }}
                                    </span>

                                    <span class="font-bold text-green-600 text-sm">
                                        Rp {{ number_format($event->ticket_price, 0, ',', '.') }}
                                    </span>

                                </div>

                                <h3 class="font-bold text-gray-800 text-lg">
                                    {{ $event->title }}
                                </h3>

                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                    {{ $event->description }}
                                </p>
                            </div>
                        </div>

                        <!-- JUMLAH TIKET -->
                        <div class="p-4 bg-gray-50 border-t">
                            <label
                                for="event_{{ $event->id }}"
                                class="block text-xs font-semibold text-gray-500 mb-1">
                                Jumlah Tiket
                            </label>

                            <input
                                type="number"
                                id="event_{{ $event->id }}"
                                name="items[{{ $event->id }}]"
                                min="0"
                                step="1"
                                value="{{ old('items.' . $event->id, 0) }}"
                                data-name="{{ $event->title }}"
                                data-price="{{ $event->ticket_price }}"
                                class="item-qty w-full border rounded-lg px-3 py-1.5 text-center font-bold text-gray-700 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>

                    </div>
                @endforeach

            </div>

            <!-- TOMBOL PEMESANAN LANGSUNG -->
            <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4">

                <p class="text-sm text-gray-500">
                    Pastikan data diri dan jumlah tiket sudah benar.
                </p>

                <button
                    type="submit"
                    class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-xl shadow-md transition">
                    Pesan Tiket Sekarang
                </button>

            </div>

        </form>

    </div>

    <!-- JAVASCRIPT -->
    <script>
        // FILTER KATEGORI EVENT
        function filterCategory(category, element) {
            document.querySelectorAll('.btn-category').forEach(btn => {
                btn.className =
                    'btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-white text-gray-600 hover:bg-gray-200 border';
            });

            element.className =
                'btn-category px-5 py-2 rounded-full font-semibold text-sm transition bg-blue-600 text-white shadow-md';

            document.querySelectorAll('.event-card').forEach(card => {
                const cardCategory = card.getAttribute('data-category');

                card.style.display =
                    (category === 'all' || cardCategory === category)
                        ? 'flex'
                        : 'none';
            });
        }

        // VALIDASI SEBELUM FORM DIKIRIM
        document.getElementById('orderForm').addEventListener('submit', function(event) {
            const name = document.getElementById('customer_name').value.trim();
            const email = document.getElementById('customer_email').value.trim();

            if (!name || !email) {
                event.preventDefault();
                alert('Silakan isi nama lengkap dan alamat email terlebih dahulu!');
                return;
            }

            const items = document.querySelectorAll('.item-qty');
            let hasOrder = false;

            items.forEach(input => {
                const qty = input.value.trim();

                if (qty !== '' && Number(qty) > 0) {
                    hasOrder = true;
                }
            });

            if (!hasOrder) {
                event.preventDefault();
                alert('Pilih minimal 1 tiket event dengan jumlah lebih dari 0!');
            }
        });
    </script>

</body>
</html>