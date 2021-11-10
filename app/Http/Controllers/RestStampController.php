<?php

namespace App\Http\Controllers;

use App\Models\Stamp;
use App\Models\Rest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RestStampController extends Controller
{
    public function restStart()
    {
        $user = Auth::user();
        $timestamp = Stamp::where('user_id', $user->id)->latest()->first();
        if (!$timestamp) {
            return redirect()->back()->with(['message' => '出勤打刻されていません。', 'status' => 'alert']);
        } else {
            $today = new Carbon();
            $day = $today->day;
            $oldEndWork = new Carbon($timestamp->stamp_date);
            $oldEndWorkDay = $oldEndWork->day;
        }
        if ($day !== $oldEndWorkDay) {
            return redirect()->back()->with(['message' => '出勤打刻されていません。', 'status' => 'alert']);
        }
        $restStamp = Rest::where('stamp_id', $timestamp->id)->latest()->first();
        if ($timestamp->end_work) {
            return redirect()->back()->with(['message' => '既に退勤しています。', 'status' => 'alert']);
        }
        if ($timestamp->start_work && !$timestamp->end_work && !$restStamp) {
            Rest::create([
                'stamp_id' => $timestamp->id,
                'rest_start' => Carbon::now()
            ]);
            return redirect()->back()->with(['message' => '休憩開始しました。', 'status' => 'info']);
        } elseif ($restStamp->rest_start && !$restStamp->rest_end) {
            return redirect()->back()->with(['message' => '休憩中です。', 'status' => 'alert']);
        } else {
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
        if ($timestamp) {
            $restStamp = Rest::where('stamp_id', $timestamp->id)->latest()->first();
            $today = new Carbon();
            $day = $today->day;
            $oldEndWork = new Carbon($timestamp->stamp_date);
            $oldEndWorkDay = $oldEndWork->day;
        }

        if (!$timestamp) {
            return redirect()->back()->with(['message' => '出勤打刻されていません。', 'status' => 'alert']);
        } else if (!$restStamp) {
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
            // dd($restTime);
            // $restTimeGet = gmdate("H:i:s", $restTime);
            $restStamp->update([
                'rest_time' => $restTime
            ]);

            return redirect()->back()->with(['message' => '休憩終了しました。', 'status' => 'info']);
        } else if ($restStamp->rest_start && $restStamp->rest_end && !$timestamp->end_work) {
            return redirect()->back()->with(['message' => '休憩開始が押されていません。', 'status' => 'alert']);
        } else {
            return redirect()->back()->with(['message' => '既に退勤しています。', 'status' => 'alert']);
        }
    }
}
