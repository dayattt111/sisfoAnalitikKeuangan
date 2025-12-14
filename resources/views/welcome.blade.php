<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Analitik Keuangan - Financial Health Monitoring</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        .delay-1 { animation-delay: 0.2s; opacity: 0; }
        .delay-2 { animation-delay: 0.4s; opacity: 0; }
        .delay-3 { animation-delay: 0.6s; opacity: 0; }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">FinanceAnalytics</h1>
                        <p class="text-xs text-gray-500">Financial Health Monitoring</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            @php
                                $user = Auth::user();
                                $dashboardRoute = match($user->role) {
                                    'admin' => route('admin.dashboard'),
                                    'manager' => route('manager.dashboard'),
                                    'staff' => route('staff.dashboard'),
                                    default => '#',
                                };
                            @endphp

                            <a href="{{ $dashboardRoute }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-th-large mr-2"></i>Dashboard
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="px-4 py-2 text-gray-700 hover:text-red-600 transition">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-blue-600 transition font-medium">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white py-20">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto text-center">
                <div class="fade-in-up">
                    <span class="inline-block px-4 py-1 bg-blue-500 bg-opacity-30 rounded-full text-sm font-semibold mb-6">
                        Powered by AI Analytics
                    </span>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight fade-in-up delay-1">
                    Monitor Kesehatan Keuangan<br>dengan <span class="text-yellow-300">Analitik Cerdas</span>
                </h1>
                <p class="text-xl text-blue-100 mb-8 leading-relaxed fade-in-up delay-2">
                    Sistem analitik keuangan berbasis Financial Health Scorecard dengan predictive insights engine. 
                    Pantau 4 KPI utama, dapatkan rekomendasi otomatis, dan prediksi tren masa depan.
                </p>
                <div class="flex gap-4 justify-center fade-in-up delay-3">
                    @guest
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-blue-700 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                            <i class="fas fa-rocket mr-2"></i>Mulai Sekarang
                        </a>
                        <a href="#features" class="px-8 py-4 bg-transparent border-2 border-white text-white rounded-lg font-semibold hover:bg-white hover:text-blue-700 transition">
                            <i class="fas fa-info-circle mr-2"></i>Pelajari Lebih Lanjut
                        </a>
                    @else
                        <a href="{{ $dashboardRoute }}" class="px-8 py-4 bg-white text-blue-700 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                            <i class="fas fa-th-large mr-2"></i>Buka Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">4</div>
                    <div class="text-gray-600 text-sm">KPI Metrics</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-emerald-600 mb-2">99%</div>
                    <div class="text-gray-600 text-sm">Accuracy</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-600 mb-2">Real-time</div>
                    <div class="text-gray-600 text-sm">Analytics</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-orange-600 mb-2">AI-Powered</div>
                    <div class="text-gray-600 text-sm">Insights</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Solusi lengkap untuk monitoring dan analisis kesehatan keuangan organisasi Anda
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Feature 1 -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-chart-pie text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">4 KPI Dashboard</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Profit Margin, Operating Efficiency, Liquidity Ratio, dan Growth Rate dalam satu dashboard interaktif.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-emerald-100 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-robot text-emerald-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">AI Recommendations</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sistem rekomendasi otomatis menganalisis kondisi dan memberikan saran spesifik untuk improvement.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-crystal-ball text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Predictive Forecasting</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Linear regression engine memprediksi tren masa depan untuk planning proaktif.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-orange-100 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Role-Based Access</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Admin, Manager, dan Staff memiliki akses dan fitur yang disesuaikan dengan peran masing-masing.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-file-export text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Export & Reporting</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Export laporan dalam format CSV atau PDF untuk presentasi dan dokumentasi.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition">
                    <div class="w-14 h-14 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-history text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Activity Monitoring</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Track semua aktivitas user untuk audit trail dan keamanan sistem yang maksimal.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Cara Kerja</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Proses analitik yang sederhana namun powerful
                </p>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="grid md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold">
                            1
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Input Data</h4>
                        <p class="text-gray-600 text-sm">Staff memasukkan transaksi pemasukan dan pengeluaran</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold">
                            2
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Validation</h4>
                        <p class="text-gray-600 text-sm">Manager review dan approve laporan keuangan</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold">
                            3
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Analytics</h4>
                        <p class="text-gray-600 text-sm">AI engine menghitung KPI dan generate insights</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-orange-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold">
                            4
                        </div>
                        <h4 class="font-bold text-gray-800 mb-2">Decision</h4>
                        <p class="text-gray-600 text-sm">Dapatkan rekomendasi untuk action plan strategis</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Siap Transformasi Manajemen Keuangan Anda?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan organisasi modern yang menggunakan data-driven decision making untuk kesuksesan finansial.
            </p>
            @guest
                <a href="{{ route('register') }}" class="inline-block px-10 py-4 bg-white text-blue-700 rounded-lg font-bold text-lg hover:bg-gray-100 transition shadow-xl">
                    <i class="fas fa-rocket mr-2"></i>Mulai Gratis Sekarang
                </a>
            @else
                <a href="{{ $dashboardRoute }}" class="inline-block px-10 py-4 bg-white text-blue-700 rounded-lg font-bold text-lg hover:bg-gray-100 transition shadow-xl">
                    <i class="fas fa-th-large mr-2"></i>Buka Dashboard Saya
                </a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-white"></i>
                        </div>
                        <h3 class="font-bold text-white text-lg">FinanceAnalytics</h3>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Sistem analitik keuangan profesional dengan AI-powered insights untuk decision making yang lebih baik.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-4">Features</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Dashboard Analytics</a></li>
                        <li><a href="#" class="hover:text-white transition">Financial Reports</a></li>
                        <li><a href="#" class="hover:text-white transition">Predictive Insights</a></li>
                        <li><a href="#" class="hover:text-white transition">Export & Reporting</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-4">Metodologi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Profit Margin Analysis</a></li>
                        <li><a href="#" class="hover:text-white transition">Operating Efficiency</a></li>
                        <li><a href="#" class="hover:text-white transition">Liquidity Ratio</a></li>
                        <li><a href="#" class="hover:text-white transition">Growth Rate Tracking</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Login</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="hover:text-white transition">Register</a></li>
                        @endif
                        <li><a href="#" class="hover:text-white transition">Documentation</a></li>
                        <li><a href="#" class="hover:text-white transition">Support</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-400">
                    &copy; {{ date('Y') }} FinanceAnalytics. All rights reserved.
                </p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
