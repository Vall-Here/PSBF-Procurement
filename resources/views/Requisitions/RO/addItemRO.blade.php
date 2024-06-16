@extends('Layouts.Master')
@section('title', 'Tambah Item RKB')

@section('content')
<div class="min-h-screen p-4 sm:ml-64">
    <div class="mt-14 rounded-lg p-4">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-bold mb-4">Tambah Item</h1>
            <form id="add-item-form" action="{{ route('rush_orders.storeItem') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                    <input type="text"
                           class="mt-1 block w-full py-2 pl-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           id="nama_barang" name="nama_barang" required>
                </div>
                <div class="mb-4">
                    <label for="satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
                    <input type="text"
                           class="mt-1 block w-full py-2 pl-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           id="satuan" name="satuan" required>
                </div>
                <div class="mb-4">
                    <label for="rencana_pakai" class="block text-sm font-medium text-gray-700">Rencana Pakai</label>
                    <input type="number"
                           class="mt-1 block w-full py-2 pl-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           id="rencana_pakai" name="rencana_pakai" required>
                </div>
                <div class="mb-4">
                    <label for="rencana_beli" class="block text-sm font-medium text-gray-700">Rencana Beli</label>
                    <input type="number"
                           class="mt-1 block w-full py-2 pl-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           id="rencana_beli" name="rencana_beli" required>
                </div>
                <div class="mb-4">
                    <label for="mata_uang" class="block text-sm font-medium text-gray-700">Mata Uang</label>
                    <input type="text"
                           class="mt-1 block w-full py-2 pl-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           id="mata_uang" name="mata_uang" required>
                </div>
                <div class="mb-4">
                    <label for="harga_satuan" class="block text-sm font-medium text-gray-700">Harga Satuan</label>
                    <input type="number" step="0.01"
                           class="mt-1 block w-full py-2 pl-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                           id="harga_satuan" name="harga_satuan" required>
                </div>
                <div class="mb-4">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea
                            class="mt-1 block w-full py-2 pl-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="keterangan" name="keterangan"></textarea>
                </div>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Tambah
                    Item
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
