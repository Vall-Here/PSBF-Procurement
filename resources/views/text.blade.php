<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('sweetalert::alert')

    <script>
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "rgb(29 78 216)",
            cancelButtonColor: "rgb(185 28 28)",
            confirmButtonText: "Yes, delete it!"
            });
        
    </script>
</body>
</html>