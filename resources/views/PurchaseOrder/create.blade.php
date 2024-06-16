@extends('layouts.master')

@section('title', 'Create Purchase Order')

@section('content')
<div class="min-h-screen p-4 sm:ml-64">
    <div class="mt-14 rounded-lg p-4">
        <div class="container mx-auto px-4">
            <h1 class="text-2xl font-bold mb-4">Create Purchase Order</h1>
            <form id="purchaseOrderForm" action="{{ route('purchase_orders.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="source" class="block text-sm font-medium text-gray-700">Source</label>
                    <select name="source" id="source" required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="purchase_request">Purchase Request</option>
                        <option value="rush_order">Rush Order</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="methode" class="block text-sm font-medium text-gray-700">Methode</label>
                    <select name="methode" id="methode" required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="Pembelian Langsung">Pembelian Langsung</option>
                        <option value="Public Tender">Public Tender</option>
                        <option value="Penunjukan langsung">Penunjukan langsung</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                    <select name="state" id="state" required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="Local">Local</option>
                        <option value="Impor">Impor</option>
                        <option value="Internal">Internal</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" name="date" id="date" required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="vendor_id" class="block text-sm font-medium text-gray-700">Vendor</label>
                    <select name="vendor_id" id="vendor_id" required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="items" class="block text-sm font-medium text-gray-700">Items</label>
                    <select name="items[]" id="items" multiple required class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <!-- Items akan dimuat secara dinamis melalui JavaScript -->
                    </select>
                </div>
                <div class="mb-4">
                    <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Amount</label>
                    <input type="text" name="total_amount" id="total_amount" readonly class="mt-1 p-2 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Create Purchase Order</button>
            </form>
        </div>
    </div>
</div>



<script>
      document.addEventListener('DOMContentLoaded', function () {
    const sourceSelect = document.getElementById('source');
    const methodeSelect = document.getElementById('methode');
    const stateSelect = document.getElementById('state');
    const itemsSelect = document.getElementById('items');
    const totalAmountInput = document.getElementById('total_amount');

    function loadItems() {
        const source = sourceSelect.value;
        const methode = methodeSelect.value;
        const state = stateSelect.value;

        fetch(`/purchase-orders/items?source=${source}&methode=${methode}&state=${state}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                itemsSelect.innerHTML = '';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = `${item.nama_barang} - ${item.satuan} - ${item.harga_satuan}`;
                    itemsSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching items:', error);
            });
    }

    sourceSelect.addEventListener('change', loadItems);
    methodeSelect.addEventListener('change', loadItems);
    stateSelect.addEventListener('change', loadItems);

    itemsSelect.addEventListener('change', function () {
        let totalAmount = 0;
        const selectedOptions = Array.from(itemsSelect.selectedOptions);

        selectedOptions.forEach(option => {
            const [nama_barang, satuan, harga_satuan] = option.textContent.split(' - ');
            const hargaSatuan = parseFloat(harga_satuan);
            totalAmount += hargaSatuan;
        });

        totalAmountInput.value = totalAmount.toFixed(2);
    });

    // Initial load of items
    loadItems();
});

</script>
@endsection




