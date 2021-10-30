<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                勤務一覧
            </h2>
            <div class="text-xl">
                <p>本日の日付</p>
                <div>{{date('Y-m-d')}}</div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="text-gray-600 body-font">
                <div class="container px-5 mx-auto">
                    <div class="flex flex-col justify-around text-center w-full mb-20">
                        <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">
                            {{$date}}の勤務一覧
                        </h1>
                        <form method="post" action="{{route('search')}}">
                            @csrf
                            @method('post')
                            <div>
                                <label for="date" class="mr-2">日付を選択して下さい</label>
                                <input type="date" name="date" value="date" id="date" class="mr-2">
                                <button class="text-white bg-blue-500 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 rounded">検索</button>
                            </div>
                        </form>
                    </div>
                    <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                        <div class="text-xl text-blue-600 ml-4">{{$date}}勤務一覧を表示中</div>

                        <table class="table-auto w-full text-left whitespace-no-wrap">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">名前</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">勤務開始</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">勤務終了</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">休憩時間</th>
                                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">勤務時間</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($stamps as $stamp)
                                    <td class="px-4 py-3">{{$stamp->name}}</td>
                                    <td class="px-4 py-3">{{$stamp->start_work}}</td>
                                    <td class="px-4 py-3">{{$stamp->end_work}}</td>
                                    <td class="px-4 py-3">{{$stamp->total_rest}}</td>
                                    <td class="px-4 py-3">{{gmdate("H:i:s",(strtotime($date.$stamp->end_work)-strtotime($date.$stamp->start_work)))}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$stamps->links()}}
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
