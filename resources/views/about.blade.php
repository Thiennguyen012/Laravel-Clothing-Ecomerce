<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Về Chúng Tôi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">Laravel Clothing Store</h1>
                        <p class="text-xl text-gray-600">Thời trang hiện đại, chất lượng cao cho mọi phong cách</p>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Cửa hàng thời trang" 
                                 class="rounded-lg shadow-lg w-full h-64 object-cover">
                        </div>
                        <div>
                            <h3 class="text-2xl font-semibold text-gray-900 mb-4">Câu Chuyện Của Chúng Tôi</h3>
                            <p class="text-gray-600 mb-4">
                                Laravel Clothing Store được thành lập vào năm 2020 với sứ mệnh mang đến những sản phẩm thời trang 
                                chất lượng cao, thiết kế hiện đại và phù hợp với xu hướng thời trang thế giới.
                            </p>
                            <p class="text-gray-600">
                                Chúng tôi tin rằng thời trang không chỉ là trang phục, mà còn là cách thể hiện cá tính và 
                                phong cách sống của mỗi người.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mission & Vision -->
            <div class="grid md:grid-cols-2 gap-8 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Sứ Mệnh</h3>
                        </div>
                        <p class="text-gray-600">
                            Cung cấp các sản phẩm thời trang chất lượng cao với giá cả hợp lý, giúp khách hàng 
                            thể hiện phong cách cá nhân và tăng cường sự tự tin trong cuộc sống hàng ngày.
                        </p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900">Tầm Nhìn</h3>
                        </div>
                        <p class="text-gray-600">
                            Trở thành thương hiệu thời trang hàng đầu tại Việt Nam, được khách hàng tin tưởng 
                            và lựa chọn cho phong cách sống hiện đại và năng động.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Core Values -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-8">
                    <h3 class="text-2xl font-semibold text-gray-900 text-center mb-8">Giá Trị Cốt Lõi</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Chất Lượng</h4>
                            <p class="text-gray-600">Cam kết cung cấp sản phẩm chất lượng cao với chất liệu tốt nhất</p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Xu Hướng</h4>
                            <p class="text-gray-600">Luôn cập nhật những xu hướng thời trang mới nhất trên thế giới</p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Tận Tâm</h4>
                            <p class="text-gray-600">Phục vụ khách hàng với sự tận tâm và chuyên nghiệp cao nhất</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Team Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-8">
                    <h3 class="text-2xl font-semibold text-gray-900 text-center mb-8">Đội Ngũ Của Chúng Tôi</h3>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" 
                                 alt="CEO" 
                                 class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                            <h4 class="text-lg font-semibold text-gray-900">Nguyễn Văn A</h4>
                            <p class="text-gray-600">CEO & Founder</p>
                            <p class="text-sm text-gray-500 mt-2">10+ năm kinh nghiệm trong ngành thời trang</p>
                        </div>

                        <div class="text-center">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" 
                                 alt="Design Director" 
                                 class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                            <h4 class="text-lg font-semibold text-gray-900">Trần Thị B</h4>
                            <p class="text-gray-600">Design Director</p>
                            <p class="text-sm text-gray-500 mt-2">Chuyên gia thiết kế thời trang quốc tế</p>
                        </div>

                        <div class="text-center">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" 
                                 alt="Marketing Manager" 
                                 class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                            <h4 class="text-lg font-semibold text-gray-900">Lê Văn C</h4>
                            <p class="text-gray-600">Marketing Manager</p>
                            <p class="text-sm text-gray-500 mt-2">Chuyên gia marketing và truyền thông</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg">
                <div class="p-8 text-white">
                    <h3 class="text-2xl font-semibold text-center mb-8">Thành Tựu Của Chúng Tôi</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                        <div>
                            <div class="text-3xl font-bold mb-2">10,000+</div>
                            <div class="text-blue-100">Khách hàng hài lòng</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold mb-2">5,000+</div>
                            <div class="text-blue-100">Sản phẩm</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold mb-2">50+</div>
                            <div class="text-blue-100">Thương hiệu</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold mb-2">4.8/5</div>
                            <div class="text-blue-100">Đánh giá khách hàng</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
