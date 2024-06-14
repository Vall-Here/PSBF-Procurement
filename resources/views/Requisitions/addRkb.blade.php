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
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="tahun_anggaran" name="tahun_anggaran" required>
                    </div>
                    <div class="mb-4">
                        <label for="jumlah_anggaran" class="block text-sm font-medium text-gray-700">Jumlah Anggaran</label>
                        <input type="number" step="0.01"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            id="jumlah_anggaran" name="jumlah_anggaran" required>
                    </div>
                    <button type="button"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        data-modal-toggle="addItemModal">
                        Tambah Item
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Simpan</button>
                </form>

                <!-- Modal -->
                <div class="modal hidden fixed z-10 inset-0 overflow-y-auto" id="addItemModal" aria-labelledby="modal-title"
                    role="dialog" aria-modal="true">
                    <div class="modal-dialog relative p-4 w-full max-w-md h-full md:h-auto">
                        <div class="modal-content relative bg-white rounded-lg shadow">
                            <div class="modal-header flex justify-between items-center p-4 border-b rounded-t">
                                <h5 class="modal-title text-xl font-semibold" id="modal-title">Tambah Item</h5>
                                <button type="button" class="text-gray-400 hover:text-gray-600"
                                    data-modal-toggle="addItemModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body p-4">
                                <form id="add-item-form">
                                    <div class="mb-4">
                                        <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama
                                            Barang</label>
                                        <input type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            id="nama_barang" name="nama_barang" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
                                        <input type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            id="satuan" name="satuan" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="rencana_pakai" class="block text-sm font-medium text-gray-700">Rencana
                                            Pakai</label>
                                        <input type="number"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            id="rencana_pakai" name="rencana_pakai" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="rencana_beli" class="block text-sm font-medium text-gray-700">Rencana
                                            Beli</label>
                                        <input type="number"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            id="rencana_beli" name="rencana_beli" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="mata_uang" class="block text-sm font-medium text-gray-700">Mata
                                            Uang</label>
                                        <input type="text"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            id="mata_uang" name="mata_uang" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="harga_satuan" class="block text-sm font-medium text-gray-700">Harga
                                            Satuan</label>
                                        <input type="number" step="0.01"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            id="harga_satuan" name="harga_satuan" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="keterangan"
                                            class="block text-sm font-medium text-gray-700">Keterangan</label>
                                        <textarea
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            id="keterangan" name="keterangan"></textarea>
                                    </div>
                                    <button type="button" id="add-item-button"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Tambah
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

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
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('add-item-button').addEventListener('click', function() {
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

                    // Clear the form
                    document.getElementById('add-item-form').reset();

                    // Close the modal
                    document.querySelector('#addItemModal').classList.add('hidden');

                    // Add event listener to remove buttons
                    tr.querySelector('.remove-item-button').addEventListener('click', function() {
                        tr.remove();
                    });
                });

                document.querySelectorAll('[data-modal-toggle]').forEach(element => {
                    element.addEventListener('click', function() {
                        const target = document.querySelector(this.getAttribute('data-modal-toggle'));
                        if (target.classList.contains('hidden')) {
                            target.classList.remove('hidden');
                        } else {
                            target.classList.add('hidden');
                        }
                    });
                });
            });
        </script>
    </div>
@endsection
