<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stamp;
use App\Models\Rest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class StampController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');
    }

    public function index()
    {
        $nowTime = Carbon::now();
        return view('index', compact('nowTime'));
    }

    public function startWork()
    {
        $user = Auth::user();

        $oldTimestamp = Stamp::where('user_id', $user->id)->latest()->first();
        if ($oldTimestamp) {
            $oldTimestampStart = new Carbon($oldTimestamp->stamp_date);
            $oldTimestampDay = $oldTimestampStart->startOfDay();
        } else {
            Stamp::create([
                'user_id' => $user->id,
                'start_work' => Carbon::now(),
                'stamp_date' => Carbon::now()->toDateString()
            ]);

            return redirect()->back()->with(['message' => '出勤打刻が完了しました。', 'status' => 'info']);
        }

        $newTimestamp = Carbon::today();
        if (($oldTimestampDay == $newTimestamp) && (empty($oldTimestamp->end_work))) {
            return redirect()->back()->with(['message' => '既に出勤打刻がされています。', 'status' => 'alert']);
        }
        if ($oldTimestamp) {
            $oldTimestampEnd = new Carbon($oldTimestamp->stamp_date);
            $oldDay = $oldTimestampEnd->startOfDay();
        }

        if (($oldDay == $newTimestamp)) {
            return redirect()->back()->with(['message' => '退勤打刻済みです。', 'status' => 'alert']);
        }
        Stamp::create([
            'user_id' => $user->id,
            'start_work' => Carbon::now(),
            'stamp_date' => Carbon::now()->toDateString(),
        ]);

        return redirect()->back()->with(['message' => '出勤打刻が完了しました。', 'status' => 'info']);
    }

    public function endWork()
    {
        $user = Auth::user();
        $timestamp = Stamp::where('user_id', $user->id)->latest()->first();
        if (!$timestamp) {
            return redirect()->back()->with(['message' => '出勤打刻されていません。', 'status' => 'alert']);
        }
        if (!$timestamp->end_work) {
            $restStamp = Rest::where('stamp_id', $timestamp->id)->latest()->first();
                if (!empty($restStamp->rest_start) && empty($restStamp->rest_end)) {
                    return redirect()->back()->with(['message' => '休憩終了が打刻されていません。', 'status' => 'alert']);
                    }
                    $timestamp->update([
                        'end_work' => Carbon::now()
                    ]);
                    $startWork=new Carbon($timestamp->start_work);
                    $endWork=new Carbon($timestamp->end_work);
                    $workTime=$startWork->diffInSeconds($endWork);
                    $workTimeGet=gmdate("H:i:s",$workTime);
                    $totalRest = Rest::where('stamp_id', $timestamp->id)->sum('rest_time');
                    $timestamp->update([
                        'total_work' => $workTimeGet,
                        'total_rest' => $totalRest
                    ]);
                    return redirect()->back()->with(['message' => '退勤打刻が完了しました。お疲れ様でした。', 'status' => 'info']);
                }
                $today = new Carbon();
                $day = $today->day;
                $oldEndWork = new Carbon($timestamp->stamp_date);
                $oldEndWorkDay = $oldEndWork->day;
                if ($day == $oldEndWorkDay) {
                    return redirect()->back()->with(['message' => '退勤済みです。', 'status' => 'alert']);
                } else {
                    return redirect()->back()->with(['message' => '出勤打刻して下さい。', 'status' => 'alert']);
                }
            }

    public function restStart()
    {
        $user = Auth::user();
        $timestamp = Stamp::where('user_id', $user->id)->latest()->first();
        if(!$timestamp){
            return redirect()->back()->with(['message' => '出勤打刻されていません。', 'status' => 'alert']);
        }else{
            $today = new Carbon();
            $day = $today->day;
            $oldEndWork = new Carbon($timestamp->stamp_date);
            $oldEndWorkDay = $oldEndWork->day;
        }
        if ($day !== $oldEndWorkDay) {
            return redirect()->back()->with(['message' => '出勤打刻されていません。', 'status' => 'alert']);
        }
        $restStamp = Rest::where('stamp_id', $timestamp->id)->latest()->first();
        if($timestamp->end_work){
            return redirect()->back()->with(['message' => '既に退勤しています。', 'status' => 'alert']);
        }
        if ($timestamp->start_work && !$timestamp->end_work && !$restStamp) {
            Rest::create([
                'stamp_id' => $timestamp->id,
                'rest_start' => Carbon::now()
            ]);
            return redirect()->back()->with(['message' => '休憩開始しました。', 'status' => 'info']);
        }elseif($restStamp->rest_start && !$restStamp->rest_end){
            return redirect()->back()->with(['message' => '休憩中です。', 'status' => 'alert']);
        }else{
            Rest::create([
                'stamp_id' => $timestamp->id,
                'rest_start' => Carbon::now()
            ]);
            return redirect()->back()->with(['message' => '休憩開始しました。', 'status' => 'info']);
        }
    }

    public function restEnd()
    {
        $user = Auth::user();
        $timestamp = Stamp::where('user_id', $user->id)->latest()->first();
        if($timestamp){
            $restStamp = Rest::where('stamp_id', $timestamp->id)->latest()->first();
            $today = new Carbon();
            $day = $today->day;
            $oldEndWork = new Carbon($timestamp->stamp_date);
            $oldEndWorkDay = $oldEndWork->day;
        }

        if (!$timestamp) {
            return redirect()->back()->with(['message' => '出勤打刻されていません。', 'status' => 'alert']);
        } else if(!$restStamp) {
            if ($day == $oldEndWorkDay && empty($restStamp->rest_start)) {
                return redirect()->back()->with(['message' => '休憩開始が押されていません。', 'status' => 'alert']);
            } else {
                return redirect()->back()->with(['message' => '出勤打刻されていません。', 'status' => 'alert']);
            }
        }

        if ($timestamp->start_work && $restStamp->rest_start && !$restStamp->rest_end) {
            $restStamp->update([
                'rest_end' => Carbon::now()
            ]);
            $restStamp = Rest::where('stamp_id', $timestamp->id)->latest()->first();
            $restStart = new Carbon($restStamp->rest_start);
            $restEnd = new Carbon($restStamp->rest_end);
            $restTime = $restStart->diffInSeconds($restEnd);
            $restTimeGet = gmdate("H:i:s", $restTime);
            $restStamp->update([
                'rest_time'=>$restTimeGet
            ]);

            return redirect()->back()->with(['message' => '休憩終了しました。', 'status' => 'info']);
        } else if ($restStamp->rest_start && $restStamp->rest_end && !$timestamp->end_work) {
            return redirect()->back()->with(['message' => '休憩開始が押されていません。', 'status' => 'alert']);
        } else {
            return redirect()->back()->with(['message' => '既に退勤しています。', 'status' => 'alert']);
        }
    }

}
