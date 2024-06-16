@extends('layouts.master')

@section('title', 'Klasifikasi Items')

@section('content')

    <div class="min-h-screen p-4 sm:ml-64">
        <div class="mt-14 rounded-lg p-4">
            <div class="container mx-auto px-4">
                <h1 class="text-2xl font-bold mb-4">Klasifikasi Items</h1>

                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4">Purchase Request Items</h2>
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
                                <th class="py-2">Methode</th>
                                <th class="py-2">State</th>
                                <th class="py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchaseRequestItems as $item)
                                <tr>
                                    <td class="border px-4 py-2">{{ $item->nama_barang }}</td>
                                    <td class="border px-4 py-2">{{ $item->satuan }}</td>
                                    <td class="border px-4 py-2">{{ $item->rencana_pakai }}</td>
                                    <td class="border px-4 py-2">{{ $item->rencana_beli }}</td>
                                    <td class="border px-4 py-2">{{ $item->mata_uang }}</td>
                                    <td class="border px-4 py-2">{{ $item->harga_satuan }}</td>
                                    <td class="border px-4 py-2">{{ $item->keterangan }}</td>
                                    <td class="border px-4 py-2">
                                        <form
                                            action="{{ route('klasifikasi.update', ['id' => $item->id, 'type' => 'purchase_request']) }}"
                                            method="POST">
                                            @csrf
                                            <select name="methode"
                                                class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <option value="">Select Methode</option>
                                                <option value="Pembelian Langsung"
                                                    {{ $item->methode == 'Pembelian Langsung' ? 'selected' : '' }}>Pembelian
                                                    Langsung</option>
                                                <option value="Public Tender"
                                                    {{ $item->methode == 'Public Tender' ? 'selected' : '' }}>Public Tender
                                                </option>
                                                <option value="Penunjukan langsung"
                                                    {{ $item->methode == 'Penunjukan langsung' ? 'selected' : '' }}>
                                                    Penunjukan langsung</option>
                                            </select>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <select name="state"
                                            class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Select State</option>
                                            <option value="Local" {{ $item->state == 'Local' ? 'selected' : '' }}>Local
                                            </option>
                                            <option value="Impor" {{ $item->state == 'Impor' ? 'selected' : '' }}>Impor
                                            </option>
                                            <option value="Internal" {{ $item->state == 'Internal' ? 'selected' : '' }}>
                                                Internal</option>
                                        </select>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <button type="submit"
                                            class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4">Rush Order Items</h2>
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
                                <th class="py-2">Methode</th>
                                <th class="py-2">State</th>
                                <th class="py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rushOrderItems as $item)
                                <tr>
                                    <td class="border px-4 py-2">{{ $item->nama_barang }}</td>
                                    <td class="border px-4 py-2">{{ $item->satuan }}</td>
                                    <td class="border px-4 py-2">{{ $item->rencana_pakai }}</td>
                                    <td class="border px-4 py-2">{{ $item->rencana_beli }}</td>
                                    <td class="border px-4 py-2">{{ $item->mata_uang }}</td>
                                    <td class="border px-4 py-2">{{ $item->harga_satuan }}</td>
                                    <td class="border px-4 py-2">{{ $item->keterangan }}</td>
                                    <td class="border px-4 py-2">
                                        <form
                                            action="{{ route('klasifikasi.update', ['id' => $item->id, 'type' => 'rush_order']) }}"
                                            method="POST">
                                            @csrf
                                            <select name="methode"
                                                class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <option value="">Select Methode</option>
                                                <option value="Pembelian Langsung"
                                                    {{ $item->methode == 'Pembelian Langsung' ? 'selected' : '' }}>
                                                    Pembelian Langsung</option>
                                                <option value="Public Tender"
                                                    {{ $item->methode == 'Public Tender' ? 'selected' : '' }}>Public Tender
                                                </option>
                                                <option value="Penunjukan langsung"
                                                    {{ $item->methode == 'Penunjukan langsung' ? 'selected' : '' }}>
                                                    Penunjukan langsung</option>
                                            </select>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <select name="state"
                                            class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Select State</option>
                                            <option value="Local" {{ $item->state == 'Local' ? 'selected' : '' }}>Local
                                            </option>
                                            <option value="Impor" {{ $item->state == 'Impor' ? 'selected' : '' }}>Impor
                                            </option>
                                            <option value="Internal" {{ $item->state == 'Internal' ? 'selected' : '' }}>
                                                Internal</option>
                                        </select>
                                    </td>
                                    <td class="border px-4 py-2">
                                        <button type="submit"
                                            class="bg-blue-500 text-white px-4 py-2 rounded-md">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
