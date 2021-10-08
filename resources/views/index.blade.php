<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{Auth::user()->name}}さんお疲れ様です。
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                            <div class="flex flex-wrap -m-4 text-center">
                                <div class="p-4 sm:w-1/4 w-1/2">
                                    <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">2.7K</h2>
                                    <p class="leading-relaxed">Users</p>
                                </div>
                                <div class="p-4 sm:w-1/4 w-1/2">
                                    <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">1.8K</h2>
                                    <p class="leading-relaxed">Subscribes</p>
                                </div>
                                <div class="p-4 sm:w-1/4 w-1/2">
                                    <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">35</h2>
                                    <p class="leading-relaxed">Downloads</p>
                                </div>
                                <div class="p-4 sm:w-1/4 w-1/2">
                                    <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">4</h2>
                                    <p class="leading-relaxed">Products</p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>