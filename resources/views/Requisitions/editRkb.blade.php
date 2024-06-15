@extends('layouts.master')

@section('title', 'Edit RKB')

@section('content')
<div class="min-h-screen p-4 sm:ml-64">
    <div class="mt-14 rounded-lg p-4">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-bold mb-4">Edit RKB</h1>
            <form id="updateForm" action="{{ route('rkbs.update', $rkb->id_rkb) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="tahun_anggaran" class="block text-sm font-medium text-gray-700">Tahun Anggaran</label>
                    <input type="number" name="tahun_anggaran" id="tahun_anggaran" value="{{ $rkb->tahun_anggaran }}" required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="jumlah_anggaran" class="block text-sm font-medium text-gray-700">Jumlah Anggaran</label>
                    <input type="number" name="jumlah_anggaran" id="jumlah_anggaran" value="{{ $rkb->jumlah_anggaran }}" required readonly class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <h2 class="text-xl font-bold mb-4">Items</h2>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2">Nama Barang</th>
                            <th class="py-2">Satuan</th>
                            <th class="py-2">Rencana Pakai</th>
                            <th class="py-2">Rencana Beli</th>
                            <th class="py-2">Mata Uang</th>
                            <th class="py-2">Harga Satuan</th>
                            <th class="py-2">Keterangan</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rkb->items as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->nama_barang }}</td>
                            <td class="border px-4 py-2">{{ $item->satuan }}</td>
                            <td class="border px-4 py-2">{{ $item->rencana_pakai }}</td>
                            <td class="border px-4 py-2">{{ $item->rencana_beli }}</td>
                            <td class="border px-4 py-2">{{ $item->mata_uang }}</td>
                            <td class="border px-4 py-2">{{ $item->harga_satuan }}</td>
                            <td class="border px-4 py-2">{{ $item->keterangan }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('rkbs.items.edit', $item->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                
                <button type="submit"    class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Update RKB</button>
               
            </form>
            <div class="flex justify-end mt-4">
                <form action="{{ route('rkbs.create.purchase-request', $rkb->id_rkb) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Forward to Purchase Request</button>
                </form>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modalButtons = document.querySelectorAll('[data-modal-toggle]');
    modalButtons.forEach(button => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-modal-target');
            const modal = document.getElementById(target);
            modal.classList.toggle('hidden');
        });
    });
    
    const closeButtons = document.querySelectorAll('[data-modal-hide]');
    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modal = button.closest('.h-modal');
            modal.classList.toggle('hidden');
        });
    });
});
</script>
@endsection
