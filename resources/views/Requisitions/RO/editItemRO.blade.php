@extends('layouts.master')

@section('title', 'Edit Item')

@section('content')
<div class="min-h-screen p-4 sm:ml-64">
    <div class="mt-14 rounded-lg p-4">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-bold mb-4">Edit Item</h1>
            <form action="{{ route('rush_orders.items.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" value="{{ $item->nama_barang }}" required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
                    <input type="text" name="satuan" id="satuan" value="{{ $item->satuan }}" required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="rencana_pakai" class="block text-sm font-medium text-gray-700">Rencana Pakai</label>
                    <input type="number" name="rencana_pakai" id="rencana_pakai" value="{{ $item->rencana_pakai }}" required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="rencana_beli" class="block text-sm font-medium text-gray-700">Rencana Beli</label>
                    <input type="number" name="rencana_beli" id="rencana_beli" value="{{ $item->rencana_beli }}" required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="mata_uang" class="block text-sm font-medium text-gray-700">Mata Uang</label>
                    <input type="text" name="mata_uang" id="mata_uang" value="{{ $item->mata_uang }}" required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="harga_satuan" class="block text-sm font-medium text-gray-700">Harga Satuan</label>
                    <input type="number" name="harga_satuan" id="harga_satuan" value="{{ $item->harga_satuan }}" required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3" class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ $item->keterangan }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Update Item</button>
                </div>
            </form>
            <form id="deleteForm-{{ $item->id }}" action="{{ route('rush_orders.items.delete', $item->id) }}" method="POST" class="inline-block">
                @method('delete')
                @csrf
                <button type="button" onclick="return confirmDelete({{ $item->id }})" class="mt-4 bg-red-500 text-white px-2 py-2 rounded-md">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
