<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stamp;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowTableController extends Controller
{
    public function showTable()
    {
        $user = Auth::user();
        $date = date("Y-m-d");
        $stampDate = Stamp::select('stamp_date')->get();
        if (!$stampDate) {
            return redirect()->back()->with(['message' => '勤務履歴がありません', 'status' => 'alert']);
        }

        //サブクエリ stamp_idごとの合計休憩時間を取得するサブクエリ
        $rests=Rest::select('stamp_id',DB::raw('SUM(rest_time) as sum_rest_time'))->groupBy('stamp_id');

        $stamps = Stamp::join('users', 'users.id', 'user_id')
            //クエリに対してleftJoinSubでサブクエリをjoin
            //必ずしも休憩時間があるわけではないないのでleftJoinSubを採用
            ->leftJoinSub($rests,'rests',function ($join){
                $join->on('stamps.id','=','rests.stamp_id');
            })
            ->where('stamp_date', $date)
            ->orderBy('stamps.updated_at', 'asc')
            ->paginate(5);

        return view('showTable', compact('stamps', 'date'));
    }

    public function search(Request $request)
    {
        $date = $request->date;

        //サブクエリ stamp_idごとの合計休憩時間を取得するサブクエリ
        $rests = Rest::select('stamp_id', DB::raw('SUM(rest_time) as sum_rest_time'))->groupBy('stamp_id');

        $stamps = Stamp::join('users', 'users.id', 'user_id')
        //クエリに対してleftJoinSubでサブクエリをjoin
        //必ずしも休憩時間があるわけではないないのでleftJoinSubを採用
            ->leftJoinSub($rests, 'rests', function ($join) {
                $join->on('stamps.id', '=', 'rests.stamp_id');
            })
            ->where('stamp_date', $date)
            ->orderBy('stamps.updated_at', 'asc')
            ->paginate(5);


        return view('showTable', compact('stamps', 'date'));
    }

    public function myShowTable()
    {
        $user = Auth::user();
        $date = date("Y-m-d");
        $stampDate = Stamp::select('stamp_date')->get();
        if (!$stampDate) {
            return redirect()->back()->with(['message' => '勤務履歴がありません', 'status' => 'alert']);
        }

        $rests = Rest::select('stamp_id', DB::raw('SUM(rest_time) as sum_rest_time'))->groupBy('stamp_id');

        $myStamps = Stamp::join('users', 'users.id', 'user_id')
            ->leftJoinSub($rests, 'rests', function ($join) {
                $join->on('stamps.id', '=', 'rests.stamp_id');
            })
            ->where('user_id', $user->id)
            ->orderBy('stamps.updated_at', 'asc')
            ->paginate(5);

        return view('myShowTable', compact('myStamps', 'date'));
    }

    public function mySearch(Request $request)
    {
        $user = Auth::user();
        $date = $request->date;
        $rests = Rest::select('stamp_id', DB::raw('SUM(rest_time) as sum_rest_time'))->groupBy('stamp_id');

        $myStamps = Stamp::leftJoinSub($rests, 'rests', function ($join) {
                $join->on('stamps.id', '=', 'rests.stamp_id');
            })
            ->where('user_id', '=', $user->id)
            ->where('stamp_date', $date)
            ->orderBy('stamps.updated_at', 'asc')
            ->paginate(5);

        return view('myShowTable', compact('myStamps', 'date'));
    }


}
