<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="icon" href="{{ asset('assets/img/logos/main-logo.png') }}" type="image/png" /> --}}
    <title>@yield('title')</title>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    {{-- <link rel="stylesheet" href="assets/css/style.css"> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body>
    <div class="bg-gray-200 dark:bg-gray-500">
        
        @include('sweetalert::alert')
        @include('Layouts.Sidebar')
        <button x-data="{}" @click="window.scrollTo({ top: 0, behavior: 'smooth' })" id="scroll-to-top" class="fixed bottom-10 right-10 z-50 rounded-full dark:bg-gray-100 w-12 h-12 hidden justify-center items-center shadow-md">
            <i class="fas fa-arrow-up text-3xl"></i>
        </button>
        @yield('content')

        
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            // Initial theme check
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window
                    .matchMedia('(prefers-color-scheme: light)').matches)) {
                document.documentElement.classList.add('dark');
                if (themeToggleLightIcon) themeToggleLightIcon.classList.remove('hidden');
                if (themeToggleDarkIcon) themeToggleDarkIcon.classList.add('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                if (themeToggleLightIcon) themeToggleLightIcon.classList.add('hidden');
                if (themeToggleDarkIcon) themeToggleDarkIcon.classList.remove('hidden');
            }

            // Theme toggle button event listener
            var themeToggleBtn = document.getElementById('theme-toggle');
            themeToggleBtn.addEventListener('click', function() {
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    }
                }
            });
        });


    </script>
    <script>
        function confirmDelete(Id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "rgb(29 78 216)",
            cancelButtonColor: "rgb(185 28 28)",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
                });
                document.getElementById(`deleteForm-${Id}`).submit();
            }
            });
        }
    </script>

    @stack('scripts')
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>
