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
                    <div class="flex flex-col justify-around text-center w-full mb-10">
                        <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">
                            {{Auth::user()->name}}さんの勤務一覧
                        </h1>
                        <form method="post" action="{{route('my-search')}}">
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
                        <table class="table-auto w-full text-left whitespace-no-wrap">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-center title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">名前</th>
                                    <th class="px-4 py-3 text-center title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">勤務開始</th>
                                    <th class="px-4 py-3 text-center title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">勤務終了</th>
                                    <th class="px-4 py-3 text-center title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">休憩時間</th>
                                    <th class="px-4 py-3 text-center title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">勤務時間</th>
                                    <th class="px-4 py-3 text-center title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">勤務日</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myStamps as $stamp)
                                <tr>
                                    {{-- {{dd($stamps)}} --}}
                                    <td class="px-4 py-3 text-center">{{Auth::user()->name}}</td>
                                    <td class="px-4 py-3 text-center">{{$stamp->start_work}}</td>
                                    <td class="px-4 py-3 text-center">{{$stamp->end_work}}</td>
                                    @if (!empty($stamp->stamp_id))
                                    {{-- {{var_dump(intval($stamp->sum_rest_time))}}
                                    {{var_dump((strtotime($date.$stamp->end_work)-strtotime($date.$stamp->start_work)))}} --}}
                                    <td class="px-4 py-3 text-center">{{gmdate("H:i:s",$stamp->sum_rest_time)}}</td>
                                    @else
                                    <td class="px-4 py-3 text-center">休憩なし</td>
                                    @endif
                                    <td class="px-4 py-3 text-center">{{gmdate("H:i:s",(strtotime($date.$stamp->end_work)-strtotime($date.$stamp->start_work)))}}</td>
                                    <td class="px-4 py-3 text-center">{{$stamp->stamp_date}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$myStamps->appends(Request::only('date'))->links()}}
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
