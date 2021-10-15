<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{Auth::user()->name}}さんお疲れ様です。
            </h2>
            <div>
                <p>現在の日時</p>
                <div>{{$nowTime}}</div>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font">
                        <x-flash-message status="session('status')" />
                        <div class="container px-5 py-24 mx-auto">
                            <div class="flex flex-wrap -m-4 text-center">
                                <div class="p-4 sm:w-1/4 w-1/2">
                                    <form method="post" action="{{route('start-work')}}">
                                        @csrf
                                        @method('post')
                                        <button class="flex mx-auto w-40 h-40 object-cover rounded-full text-white bg-blue-500 border-0 py-16 px-16 focus:outline-none hover:bg-blue-600 rounded">出勤</button>
                                        <input type="hidden" name="start_work">
                                    </form>
                                </div>
                                <div class="p-4 sm:w-1/4 w-1/2">
                                    <form method="post" action="{{route('end-work')}}">
                                        @csrf
                                        @method('post')
                                        <button class="flex mx-auto w-40 h-40 object-cover rounded-full text-white bg-blue-500 border-0 py-16 px-16 focus:outline-none hover:bg-blue-600 rounded">退勤</button>
                                        <input type="hidden" name="end_work">
                                    </form>
                                </div>
                                <div class="p-4 sm:w-1/4 w-1/2">
                                    <form method="post" action="{{route('break-start')}}">
                                        @csrf
                                        @method('post')
                                        <button class="flex mx-auto w-40 h-40 object-cover rounded-full text-white bg-blue-500 border-0 py-16 px-12 focus:outline-none hover:bg-blue-600 rounded">休憩開始</button>
                                        <input type="hidden" name="break_start">
                                    </form>
                                </div>
                                <div class="p-4 sm:w-1/4 w-1/2">
                                    <form method="post" action="{{route('break-end')}}">
                                        @csrf
                                        @method('post')
                                        <button class="flex mx-auto w-40 h-40 object-cover rounded-full text-white bg-blue-500 border-0 py-16 px-12 focus:outline-none hover:bg-blue-600 rounded">休憩終了</button>
                                        <input type="hidden" name="break_end">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
