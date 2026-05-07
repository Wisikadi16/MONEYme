<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MONEYme - Dashboard Keuangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-indigo-600">MONEYme</span>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md font-medium">Dashboard</a>
                        <a href="{{ route('transactions.create') }}" class="ml-4 px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 transition">
                            + Transaksi
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto py-6">
            <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} MONEYme. Sistem Kesadaran Finansial.
            </div>
        </footer>
    </div>

</body>
</html>
