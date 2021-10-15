<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stamp;
use App\Models\User;
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
        $nowTime=Carbon::now();
        return view('index',compact('nowTime'));
    }

    public function startWork()
    {
        $user=Auth::user();

        $oldTimestamp=Stamp::where('user_id',$user->id)->latest()->first();
        if($oldTimestamp){
            $oldTimestampStart=new Carbon($oldTimestamp->start_work);
            $oldTimestampDay=$oldTimestampStart->startOfDay();
        }else{
            Stamp::create([
                'user_id' => $user->id,
                'date' => Carbon::now()->toDateString(),
                'start_work' => Carbon::now(),
            ]);

            return redirect()->route('index')->with(['message'=>'出勤打刻が完了しました。','status'=>'info']);
        }

        $newTimestamp=Carbon::today();
        if(($oldTimestampDay == $newTimestamp) && (empty($oldTimestamp->end_work)))
        {
            return redirect()->route('index')->with(['message'=>'既に出勤打刻がされています。','status'=>'alert']);
        }
        if($oldTimestamp){
            $oldTimestampEnd=new Carbon($oldTimestamp->end_work);
            $oldDay=$oldTimestampEnd->startOfDay();
        }
        if(($oldDay == $newTimestamp)){
            return redirect()->route('index')->with(['message'=>'退勤打刻済みです。','status'=>'alert']);
        }
        Stamp::create([
            'user_id'=>$user->id,
            'date'=>Carbon::now()->toDateString(),
            'start_work' => Carbon::now(),
        ]);

        return redirect()->route('index')->with(['message' => '出勤打刻が完了しました。', 'status' => 'info']);
    }

    public function endWork()
    {
        $user=Auth::user();
        $timestamp = Stamp::where('user_id', $user->id)->latest()->first();
        if($timestamp){
            if(empty($timestamp->end_work)){
                if($timestamp->breakStart && !$timestamp->breakEnd){
                    return redirect()->route('index')->with(['message'=>'休憩終了が打刻されていません。','status'=>'alert']);
                }else{
                    $timestamp->update([
                        'end_work'=>Carbon::now()
                    ]);
                    return redirect()->route('index')->with(['message'=>'退勤打刻が完了しました。お疲れ様でした。','status'=>'info']);
                }
            }else{
                $today=new Carbon();
                $day=$today->day;
                $oldEndWork=new Carbon();
                $oldEndWorkDay=$oldEndWork->day;
                if($day == $oldEndWorkDay){
                    return redirect()->route('index')->with(['message'=>'退勤済みです。','status'=>'alert']);
                }else{
                    return redirect()->route('index')->with(['message'=>'出勤打刻して下さい','status'=>'alert']);
                }
            }
        }else{
            return redirect()->route('index')->with(['message'=>'出勤打刻がされていません。','status'=>'alert']);
        }
    }

    public function breakStart()
    {
        $user = Auth::user();
        $timestamp = Stamp::where('user_id', $user->id)->latest()->first();
        if($timestamp->start_work && !$timestamp->end_work && !$timestamp->break_start){
            $timestamp->update([
                'break_start'=>Carbon::now()
            ]);
            return redirect()->back()->with(['message'=>'休憩開始しました。','status'=>'info']);
        }
        return redirect()->back()->with(['message'=>'既に退勤しています。','status'=>'alert']);
    }

    public function breakEnd()
    {
        $user = Auth::user();
        $timestamp = Stamp::where('user_id', $user->id)->latest()->first();
        if ($timestamp->break_start && !$timestamp->break_end) {
            $timestamp->update([
                'break_end' => Carbon::now()
            ]);
            return redirect()->back()->with(['message' => '休憩終了しました。', 'status' => 'info']);
        }
        return redirect()->back()->with(['message'=>'既に退勤しています。','status'=>'alert']);
    }

    public function showTable()
    {
        return view('showTable');
    }

}
