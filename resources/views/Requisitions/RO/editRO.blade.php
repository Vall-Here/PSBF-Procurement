@extends('layouts.master')

@section('title', 'Edit rush_orders')

@section('content')
<div class="min-h-screen p-4 sm:ml-64">
    <div class="mt-14 rounded-lg p-4">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-bold mb-4">Edit Rush Orders</h1>
            <form id="updateForm" action="{{ route('rush_orders.update', $rush_orders->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="tahun_anggaran" class="block text-sm font-medium text-gray-700">Tahun Anggaran</label>
                    <input type="number" name="tahun_anggaran" id="tahun_anggaran" value="{{ $rush_orders->tahun_anggaran }}" required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="jumlah_anggaran" class="block text-sm font-medium text-gray-700">Jumlah Anggaran</label>
                    <input type="number" name="jumlah_anggaran" id="jumlah_anggaran" value="{{ $rush_orders->jumlah_anggaran }}" required readonly class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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
                        @foreach($rush_orders->items as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->nama_barang }}</td>
                            <td class="border px-4 py-2">{{ $item->satuan }}</td>
                            <td class="border px-4 py-2">{{ $item->rencana_pakai }}</td>
                            <td class="border px-4 py-2">{{ $item->rencana_beli }}</td>
                            <td class="border px-4 py-2">{{ $item->mata_uang }}</td>
                            <td class="border px-4 py-2">{{ $item->harga_satuan }}</td>
                            <td class="border px-4 py-2">{{ $item->keterangan }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('rush_orders.items.edit', $item->id) }}" class="bg-yellow-500 text-white px-2 py-2 rounded">Edit</a>
                                <!-- Form untuk menghapus item -->
                           
                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" onclick="document.getElementById('updateForm').submit();" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Update rush_orders</button>
            </form>

            <form action="{{ route('rush_orders.submitReview', $rush_orders->id) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Ajukan Review</button>
            </form>

            <h2 class="text-xl font-bold mt-6">Review Status</h2>
            <ul>
                <li>Gudang: {{ $rush_orders->review_status['gudang'] }}</li>
                <li>Financial: {{ $rush_orders->review_status['financial'] }}</li>
                <li>Procurement: {{ $rush_orders->review_status['procurement'] }}</li>
            </ul>

            {{-- @if (auth()->user()->role === 'gudang' || auth()->user()->role === 'financial' || auth()->user()->role === 'procurement') --}}
            <form action="{{ route('rush_orders.review', $rush_orders->id) }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Review Status</label>
                    <select name="status" id="status" class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="approved">approved</option>
                        <option value="rejected">Reject</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit Review</button>
            </form>
            {{-- @endif --}}

        </div>
    </div>
</div>
@endsection
