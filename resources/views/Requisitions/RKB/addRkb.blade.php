@extends('Layouts.Master')
@section('title', 'Daftar RKB')

@section('content')
    <div class="min-h-screen p-4 sm:ml-64">
        <div class="mt-14 rounded-lg p-4">
            <div class="container mx-auto px-4">
                <h1 class="text-2xl font-bold mb-4">Buat RKB Baru</h1>
                <form id="rkb-form" action="{{ route('rkbs.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="tahun_anggaran" class="block text-sm font-medium text-gray-700">Tahun Anggaran</label>
                        <input type="number"
                            class="mt-1 block w-full pl-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2"
                            id="tahun_anggaran" name="tahun_anggaran" required>
                    </div>
                    <div class="mb-4">
                        <label for="jumlah_anggaran" class="block text-sm font-medium text-gray-700">Jumlah Anggaran</label>
                        <input type="number" step="0.01"
                            class="mt-1 block w-full pl-2 rounded-md border-gray-300 shadow-sm py-2 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="jumlah_anggaran" name="jumlah_anggaran" required readonly>
                    </div>
                    
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Simpan</button>
                </form>

                <a href="{{ route('rkbs.addItem') }}">Tambah Item</a>
          
                <!-- Items Table -->
                <div class="mt-6">
                    <h2 class="text-lg font-semibold mb-2">Daftar Item</h2>
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200" id="items-table">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Barang</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Satuan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rencana Pakai</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rencana Beli</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Mata Uang</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga Satuan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach(session('rkb_items', []) as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['nama_barang'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['satuan'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['rencana_pakai'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['rencana_beli'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['mata_uang'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['harga_satuan'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['keterangan'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

    

        </div>
        
    </div>
    



    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('add-item-button').addEventListener('click', function () {
                const nama_barang = document.getElementById('nama_barang').value;
                const satuan = document.getElementById('satuan').value;
                const rencana_pakai = document.getElementById('rencana_pakai').value;
                const rencana_beli = document.getElementById('rencana_beli').value;
                const mata_uang = document.getElementById('mata_uang').value;
                const harga_satuan = document.getElementById('harga_satuan').value;
                const keterangan = document.getElementById('keterangan').value;

                const tbody = document.getElementById('items-table').querySelector('tbody');
                const tr = document.createElement('tr');

                tr.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap"><input type="hidden" name="items[nama_barang][]" value="${nama_barang}">${nama_barang}</td>
                <td class="px-6 py-4 whitespace-nowrap"><input type="hidden" name="items[satuan][]" value="${satuan}">${satuan}</td>
                <td class="px-6 py-4 whitespace-nowrap"><input type="hidden" name="items[rencana_pakai][]" value="${rencana_pakai}">${rencana_pakai}</td>
                <td class="px-6 py-4 whitespace-nowrap"><input type="hidden" name="items[rencana_beli][]" value="${rencana_beli}">${rencana_beli}</td>
                <td class="px-6 py-4 whitespace-nowrap"><input type="hidden" name="items[mata_uang][]" value="${mata_uang}">${mata_uang}</td>
                <td class="px-6 py-4 whitespace-nowrap"><input type="hidden" name="items[harga_satuan][]" value="${harga_satuan}">${harga_satuan}</td>
                <td class="px-6 py-4 whitespace-nowrap"><input type="hidden" name="items[keterangan][]" value="${keterangan}">${keterangan}</td>
                <td class="px-6 py-4 whitespace-nowrap"><button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 remove-item-button">Hapus</button></td>
            `;

                tbody.appendChild(tr);

                // Add event listener to remove buttons
                tr.querySelector('.remove-item-button').addEventListener('click', function () {
                    tr.remove();
                    updateJumlahAnggaran();
                });

                // Update total anggaran
                updateJumlahAnggaran();

                // Clear the form
                document.getElementById('add-item-form').reset();

                // Close the modal
                document.querySelector('#addItemModal').classList.add('hidden');
            });

            document.querySelectorAll('[data-modal-target]').forEach(element => {
                element.addEventListener('click', function () {
                    const target = document.querySelector(this.getAttribute('data-modal-target'));
                    if (target.classList.contains('hidden')) {
                        target.classList.remove('hidden');
                    } else {
                        target.classList.add('hidden');
                    }
                });
            });

            function updateJumlahAnggaran() {
                const tbody = document.getElementById('items-table').querySelector('tbody');
                let totalAnggaran = 0;

                tbody.querySelectorAll('tr').forEach(tr => {
                    const rencanaBeli = parseFloat(tr.querySelector('input[name="items[rencana_beli][]"]').value);
                    const hargaSatuan = parseFloat(tr.querySelector('input[name="items[harga_satuan][]"]').value);
                    totalAnggaran += rencanaBeli * hargaSatuan;
                });

                document.getElementById('jumlah_anggaran').value = totalAnggaran.toFixed(2);
            }
        });
    </script> --}}
@endsection
