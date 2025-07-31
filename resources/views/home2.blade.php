<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trang chủ') }}
        </h2>
    </x-slot>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Chào mừng đến với
                    <span class="text-yellow-300">Laravel E-Commerce</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    Khám phá bộ sưu tập thời trang độc đáo và chất lượng cao
                </p>
                <div class="space-x-4">
                    <a href="{{ route('products') }}" 
                       class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold text-lg hover:bg-gray-100 transition duration-300 inline-block">
                        Khám phá sản phẩm
                    </a>
                    <a href="{{ route('about') }}" 
                       class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-white hover:text-blue-600 transition duration-300 inline-block">
                        Tìm hiểu thêm
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Tại sao chọn chúng tôi?</h2>
                <p class="text-lg text-gray-600">Những điều làm nên sự khác biệt của chúng tôi</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-lg shadow-sm p-8 text-center hover:shadow-md transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Chất lượng đảm bảo</h3>
                    <p class="text-gray-600">Tất cả sản phẩm đều được kiểm tra kỹ lưỡng trước khi đến tay khách hàng</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-lg shadow-sm p-8 text-center hover:shadow-md transition duration-300">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Giao hàng nhanh chóng</h3>
                    <p class="text-gray-600">Giao hàng miễn phí trong 24h tại Hà Nội và 2-3 ngày toàn quốc</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-lg shadow-sm p-8 text-center hover:shadow-md transition duration-300">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Đổi trả dễ dàng</h3>
                    <p class="text-gray-600">Chính sách đổi trả trong 30 ngày, hoàn tiền 100% nếu không hài lòng</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-blue-600 mb-2">1000+</div>
                    <div class="text-gray-600">Khách hàng hài lòng</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-green-600 mb-2">500+</div>
                    <div class="text-gray-600">Sản phẩm chất lượng</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-purple-600 mb-2">24/7</div>
                    <div class="text-gray-600">Hỗ trợ khách hàng</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-orange-600 mb-2">99%</div>
                    <div class="text-gray-600">Đánh giá tích cực</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Categories Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                <!-- Categories Sidebar -->
                <div class="lg:col-span-1 mb-8 lg:mb-0">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Danh mục sản phẩm
                        </h3>
                        
                        <div class="space-y-2">
                            <!-- All Products -->
                            <a href="{{ route('products') }}" 
                               class="group flex items-center p-3 rounded-lg hover:bg-blue-50 transition duration-200">
                                <div class="w-10 h-10 bg-gradient-to-br from-gray-400 to-gray-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 group-hover:text-blue-600">Tất cả sản phẩm</div>
                                    <div class="text-sm text-gray-500">Xem toàn bộ</div>
                                </div>
                            </a>

                            <!-- Category 1: Áo thun -->
                            <a href="{{ route('products', ['categoryId' => 1]) }}" 
                               class="group flex items-center p-3 rounded-lg hover:bg-blue-50 transition duration-200">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 group-hover:text-blue-600">Áo thun</div>
                                    <div class="text-sm text-gray-500">Thoải mái & thời trang</div>
                                </div>
                            </a>

                            <!-- Category 2: Áo sơ mi -->
                            <a href="{{ route('products', ['categoryId' => 2]) }}" 
                               class="group flex items-center p-3 rounded-lg hover:bg-green-50 transition duration-200">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 group-hover:text-green-600">Áo sơ mi</div>
                                    <div class="text-sm text-gray-500">Lịch sự & chuyên nghiệp</div>
                                </div>
                            </a>

                            <!-- Category 3: Quần jeans -->
                            <a href="{{ route('products', ['categoryId' => 3]) }}" 
                               class="group flex items-center p-3 rounded-lg hover:bg-purple-50 transition duration-200">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 group-hover:text-purple-600">Quần jeans</div>
                                    <div class="text-sm text-gray-500">Bền bỉ & phong cách</div>
                                </div>
                            </a>

                            <!-- Category 4: Đầm váy -->
                            <a href="{{ route('products', ['categoryId' => 5]) }}" 
                               class="group flex items-center p-3 rounded-lg hover:bg-pink-50 transition duration-200">
                                <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 group-hover:text-pink-600">Đầm váy</div>
                                    <div class="text-sm text-gray-500">Nữ tính & quyến rũ</div>
                                </div>
                            </a>
                        </div>

                        <!-- Special Offer Banner -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="bg-gradient-to-r from-orange-400 to-red-500 rounded-lg p-4 text-white text-center">
                                <div class="text-sm font-semibold mb-1">🔥 Ưu đãi đặc biệt</div>
                                <div class="text-lg font-bold">Giảm 30%</div>
                                <div class="text-xs">Cho đơn hàng đầu tiên</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hero Content -->
                <div class="lg:col-span-3">
                    <!-- Main Hero Banner -->
                    <div class="relative bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-2xl overflow-hidden mb-8">
                        <div class="absolute inset-0 bg-black opacity-20"></div>
                        <div class="relative px-8 py-16 md:px-12 md:py-20">
                            <div class="max-w-2xl">
                                <h2 class="text-3xl md:text-5xl font-bold text-white mb-4">
                                    Bộ sưu tập
                                    <span class="text-yellow-300">Thu Đông 2025</span>
                                </h2>
                                <p class="text-lg md:text-xl text-indigo-100 mb-8">
                                    Khám phá những thiết kế mới nhất với phong cách hiện đại và chất lượng cao nhất. 
                                    Từ áo thun basic đến quần jeans premium.
                                </p>
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <a href="{{ route('products') }}" 
                                       class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold text-lg hover:bg-gray-100 transition duration-300 text-center">
                                        Mua sắm ngay
                                    </a>
                                    <a href="{{ route('products', ['order' => 'newest']) }}" 
                                       class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-white hover:text-purple-600 transition duration-300 text-center">
                                        Sản phẩm mới
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Decorative Elements -->
                        <div class="absolute top-4 right-4 w-32 h-32 bg-white opacity-10 rounded-full"></div>
                        <div class="absolute bottom-4 right-8 w-24 h-24 bg-yellow-300 opacity-20 rounded-full"></div>
                    </div>

                    <!-- Featured Products Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Featured Category 1 -->
                        <a href="{{ route('products', ['categoryId' => 1]) }}" 
                           class="group relative bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition duration-300">
                            <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                <svg class="w-20 h-20 text-white group-hover:scale-110 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition">
                                    Áo Thun Premium
                                </h3>
                                <p class="text-gray-600 mb-4">Cotton 100% cao cấp, form dáng hiện đại</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-blue-600">150.000đ</span>
                                    <span class="text-sm text-gray-500">20+ sản phẩm</span>
                                </div>
                            </div>
                        </a>

                        <!-- Featured Category 2 -->
                        <a href="{{ route('products', ['categoryId' => 3]) }}" 
                           class="group relative bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition duration-300">
                            <div class="h-48 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                                <svg class="w-20 h-20 text-white group-hover:scale-110 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-purple-600 transition">
                                    Quần Jeans Trendy
                                </h3>
                                <p class="text-gray-600 mb-4">Denim cao cấp, thiết kế slim fit hiện đại</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-bold text-purple-600">350.000đ</span>
                                    <span class="text-sm text-gray-500">15+ sản phẩm</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="py-16 bg-blue-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">
                Sẵn sàng khám phá?
            </h2>
            <p class="text-xl text-blue-100 mb-8">
                Hãy bắt đầu hành trình mua sắm của bạn cùng chúng tôi
            </p>
            <div class="space-x-4">
                <a href="{{ route('products') }}" 
                   class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold text-lg hover:bg-gray-100 transition duration-300 inline-block">
                    Mua sắm ngay
                </a>
                <a href="{{ route('contact') }}" 
                   class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold text-lg hover:bg-white hover:text-blue-600 transition duration-300 inline-block">
                    Liên hệ hỗ trợ
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
