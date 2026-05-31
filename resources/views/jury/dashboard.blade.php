<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Juri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 p-10">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-8">
        <h1 class="text-2xl font-bold text-[#00288E]">Dashboard Juri</h1>
        <p class="mt-2 text-slate-600">Anda berhasil login sebagai Juri.</p>

        <button onclick="logout()" class="mt-6 rounded-lg bg-red-600 px-5 py-3 text-white font-bold">
            Logout
        </button>
    </div>

    <script>
        function logout() {
            localStorage.removeItem('duta_kampus_token');
            localStorage.removeItem('duta_kampus_user');
            window.location.href = "{{ url('/login') }}";
        }
    </script>
</body>
</html>
