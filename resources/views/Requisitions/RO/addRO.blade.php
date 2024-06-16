@extends('Layouts.Master')
@section('title', 'Daftar rush orders')

@section('content')
<div class="min-h-screen p-4 sm:ml-64">
    <div class="mt-14 rounded-lg p-4">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-bold mb-4">Buat Rush Order Baru</h1>
            <form id="rush_orders-form" action="{{ route('rush_orders.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="tahun_anggaran" class="block text-sm font-medium text-gray-700">Tahun Anggaran</label>
                    <input type="number"
                        class="mt-1 block w-full pl-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2"
                        id="tahun_anggaran" name="tahun_anggaran" required>
                </div>
                <div class="mb-4">
                    <label for="jumlah_anggaran" class="block text-sm font-medium text-gray-700">Jumlah Anggaran</label>
                    <input type="number" step="1"
                        class="mt-1 block w-full pl-2 rounded-md border-gray-300 shadow-sm py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        id="jumlah_anggaran" name="jumlah_anggaran" required readonly>
                </div>
                
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Simpan</button>
            </form>

            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-2">Daftar Item</h2>
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200" id="items-table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rencana Pakai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rencana Beli</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mata Uang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach(session('rush_order_items', []) as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['nama_barang'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['satuan'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['rencana_pakai'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['rencana_beli'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['mata_uang'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['harga_satuan'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['keterangan'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <form action="{{ route('rush_orders.deleteItemOnAdd', $loop->index) }}" method="POST" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <a href="{{ route('rush_orders.addItem') }}"
            class="inline-flex mt-3 items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Tambah Item
            </a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let totalAnggaran = 0;

        // Function to calculate the total budget
        function calculateTotalBudget() {
            let totalBudget = 0;
            $('#items-table tbody tr').each(function() {
                let hargaSatuan = parseFloat($(this).find('td').eq(5).text()) || 0;
                let rencanaBeli = parseFloat($(this).find('td').eq(3).text()) || 0;
                totalBudget += hargaSatuan * rencanaBeli;
            });
            $('#jumlah_anggaran').val(totalBudget);
        }

        // Initial calculation
        calculateTotalBudget();

        // Listen for changes in the items and recalculate
        $(document).on('input', '#items-table tbody tr td', function() {
            calculateTotalBudget();
        });
    });
</script>
@endsection
