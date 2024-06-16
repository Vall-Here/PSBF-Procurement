@extends('Layouts.Master')
@section('title', 'Daftar PP')
@section('content')
    <div class="min-h-screen p-4 sm:ml-64">
        <div class="mt-14 rounded-lg p-4">
            <nav class="mb-4 flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 rtl:space-x-reverse md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="#"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <ion-icon name="home" class="me-2.5 h-4 w-4"></ion-icon>
                            Dashboard
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="mx-1 w-3 text-gray-400 rtl:rotate-180">|</i>
                            <span class="ms-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ms-2">Daftar 
                                PP</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 dark:text-white md:text-4xl">
                Daftar Permintaan Pembelian</h2>
     

            <div class="px-2 mx-auto max-w-screen-2xl lg:px-2">
                <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                    <div
                        class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                        <div class="flex items-center flex-1 space-x-4">
                            <h5>
                                <span class="text-gray-500">All PPs:</span>
                                <span class="dark:text-white">{{ $totalPPs }}</span>
                            </h5>
                            <form action="" method="GET" class="w-full mx-auto">
                                <label for="default-search"
                                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input type="search" id="default-search" name="search"
                                        class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Search . . ." value="{{ request('search') }}" />
                                </div>
                            </form>
                        </div>
                       
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppsercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                           
                                    <th scope="col" class="px-4 py-3">Tahun Anggaran</th>
                                    <th scope="col" class="px-4 py-3">Jumlah Anggaran</th>
                                    <th scope="col" class="px-4 py-3">User</th>
                                    <th scope="col" class="px-4 py-3">Status</th>
       
                                    <th scope="col" class="px-4 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($PPs as $PP)
                                    <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                       
                                        <th scope="row"
                                            class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $PP->tahun_anggaran }}
                                        </th>
                                        <td class="px-4 py-2">Rp {{ number_format($PP->jumlah_anggaran, 0, ',', '.') }}</td>

                                        <td class="px-4 py-2">
                                            <span
                                                class="bg-primary-100 text-primary-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-primary-900 dark:text-primary-300 line-clamp-2 hover:line-clamp-none">{{ $PP->user->name }}</span>
                                        </td>
                            
                                        <td class="px-4 py-2">
                                            <span
                                                class="bg-primary-100 text-primary-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-primary-900 dark:text-primary-300 line-clamp-2 hover:line-clamp-none">{{ $PP->status }}</span>
                                        </td>
                            
                                    
                                        <td class=" py-3 flex items-start justify-start ps-3">
                                            <button id="{{ $PP->id }}-dropdown-button"
                                                data-dropdown-toggle="{{ $PP->id }}-dropdown"
                                                class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                                type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                            <div id="{{ $PP->id}}-dropdown"
                                                class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                    aria-labelledby="{{ $PP->id }}-dropdown-button">
                                                    <li>
                                                        <a href="{{ route('PP.edit', $PP->id) }}"
                                                            class=" block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                                    </li>

                                                </ul>
                                                <div class="py-1" x-data>
                                                    <form id="deleteForm-{{ $PP->id }}" action="{{ route('PP.destroy', $PP->id) }}" method="POST" class="inline-block">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="button" onclick="return confirmDelete({{ $PP->id }})" class="w-full text-center mx-auto py-2 ps-4 pe-28 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                                
                                            </div>
                                        </td>
                                    </tr>
                             @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="w-full p-8">
                        {{ $PPs->links('Layouts.Pagination') }}
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

