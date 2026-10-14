<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Konser / Event</h2>
    </x-slot>
    
    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-sm border">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Konser / Event</label>
                <input type="text" name="title" value="{{ $event->title }}" class="w-full border rounded p-2" required placeholder="Contoh: Konser Musik Nusantara Fest">
            </div>
            
            <div class="mb-4">
                <label class="block font-medium mb-1">Kategori</label>
                <select name="category" class="w-full border rounded p-2" required>
                    <option value="Musik" {{ $event->category === 'Musik' ? 'selected' : '' }}>Musik</option>
                    <option value="Festival" {{ $event->category === 'Festival' ? 'selected' : '' }}>Festival</option>
                    <option value="Seminar" {{ $event->category === 'Seminar' ? 'selected' : '' }}>Seminar</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block font-medium mb-1">Harga Tiket (Rp)</label>
                <input type="number" name="ticket_price" class="w-full border rounded p-2" required placeholder="Contoh: 150000">
            </div>
            
            <div class="mb-4">
                <label class="block font-medium mb-1">Deskripsi Event</label>
                <textarea name="description" class="w-full border rounded p-2" rows="3" required placeholder="Tuliskan detail deskripsi event..."></textarea>
            </div>
            
            <div class="mb-4">
                <label class="block font-medium mb-1">Poster Event (Opsional)</label>
                <input type="file" name="image" class="w-full border rounded p-2">
            </div>
            
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded font-semibold">Simpan Data</button>
        </form>
    </div>
</x-app-layout>