<x-app-layout>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project Members') }}
        </h2>
    </x-slot:header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- สมาชิกคนที่ 1 --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    {{-- 1. รูปภาพ (แก้ URL ตรง src) --}}
                    <img class="w-32 h-32 rounded-full mx-auto mb-4 bg-gray-200" 
                         src="{{ asset('storage/profile/pro2.jpg') }}" 
                         alt="Member 1 Photo">
                    
                    {{-- 2. ชื่อ-สกุล --}}
                    <h3 class="text-xl font-bold text-gray-900">
                        ธนรัตน์ ม่อนคำดี 
                    </h3>
                    
                    {{-- 3. รหัสนักศึกษา --}}
                    <p class="text-md text-gray-600">
                        640612090
                    </p>
                </div>
                {{-- จบการ์ดคนที่ 1 --}}


                {{-- การ์ดคนที่ 2 --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <img class="w-32 h-32 rounded-full mx-auto mb-4 bg-gray-200" 
                         src="{{ asset('storage/profile/pro3.jpg') }}" 
                         alt="Member 2 Photo">
                    
                    <h3 class="text-xl font-bold text-gray-900">
                        ณัฐศุพัฒน์ เทียมปาน
                    </h3>
                    
                    <p class="text-md text-gray-600">
                        640612184
                    </p>
                </div>
                {{-- จบการ์ดคนที่ 2 --}}


                {{-- การ์ดสมาชิกคนที่ --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <img class="w-32 h-32 rounded-full mx-auto mb-4 bg-gray-200" 
                         src="{{ asset('storage/profile/pro1.jpg') }}" 
                         alt="Member 3 Photo">
                    
                    <h3 class="text-xl font-bold text-gray-900">
                        ชนัญชิดา ถาวรวงค์
                    </h3>
                    
                    <p class="text-md text-gray-600">
                        650612080
                    </p>
                </div>
                {{-- จบการ์ดคนที่ 3 --}}

            </div>
        </div>
    </div>
</x-app-layout>

