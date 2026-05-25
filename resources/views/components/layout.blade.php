<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'ERP Sederhana' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside id="sidebar"
            class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between h-screen sticky top-0 transition-all duration-300">

            <div class="p-6">

                <!-- LOGO -->
                <div class="flex items-center justify-between mb-8">

                    <div class="flex items-center gap-3 overflow-hidden">

                        <div class="w-8 h-8 bg-slate-800 rounded flex items-center justify-center text-white font-bold text-lg shrink-0">
                            E
                        </div>

                        <span id="sidebarLogoText"
                            class="text-xl font-bold text-slate-800 tracking-wide whitespace-nowrap">
                            ERP
                        </span>

                    </div>

                    <!-- TOGGLE BUTTON -->
                    <button onclick="toggleSidebar()"
                        class="text-gray-400 hover:text-gray-600 transition cursor-pointer">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="w-5 h-5">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>

                <!-- MENU -->
                <nav class="space-y-1">

                    <!-- CUSTOMERS -->
                    <a href="{{ route('customers.page') }}"
                        class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('customers.page') ? 'bg-gray-50 text-slate-900 font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium' }} rounded-lg text-sm transition-colors">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="w-5 h-5 shrink-0">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>

                        <span class="sidebar-text whitespace-nowrap">
                            Customers
                        </span>
                    </a>

                    <!-- SERVICES -->
                    <a href="{{ route('services.page') }}"
                        class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('services.page') ? 'bg-gray-50 text-slate-900 font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium' }} rounded-lg text-sm transition-colors">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="w-5 h-5 shrink-0">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>

                        <span class="sidebar-text whitespace-nowrap">
                            Services
                        </span>
                    </a>

                    <!-- SUBSCRIPTIONS -->
                    <a href="{{ route('subscriptions.page') }}"
                        class="flex items-center gap-3 px-3 py-2.5 {{ request()->routeIs('subscriptions.page') ? 'bg-gray-50 text-slate-900 font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium' }} rounded-lg text-sm transition-colors">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                            stroke="currentColor"
                            class="w-5 h-5 shrink-0">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>

                        <span class="sidebar-text whitespace-nowrap">
                            Subscription
                        </span>
                    </a>

                </nav>
            </div>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-8 bg-gray-50 overflow-y-auto">
            {{ $slot }}
        </main>

    </div>

    <!-- SIDEBAR SCRIPT -->
    <script>
        function toggleSidebar() {

            const sidebar = document.getElementById('sidebar');
            const texts = document.querySelectorAll('.sidebar-text');
            const logoText = document.getElementById('sidebarLogoText');

            sidebar.classList.toggle('w-64');
            sidebar.classList.toggle('w-20');

            texts.forEach(text => {
                text.classList.toggle('hidden');
            });

            logoText.classList.toggle('hidden');
        }
    </script>

</body>
</html>