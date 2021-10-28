<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stamp;
use App\Models\Rest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class ShowTableController extends Controller
{
    public function showTable()
    {
        $stampDate = Stamp::select('stamp_date')->get();
        if (!$stampDate) {
            return redirect()->back()->with(['message' => '勤務履歴がありません', 'status' => 'alert']);
        }

        $user = Auth::user();
        $timestamp = Stamp::where('user_id', $user->id)->latest()->first();
        $restStamp = Rest::where('stamp_id', $timestamp->id)->latest()->first();

        $date = date("Y-m-d");

        $users = Stamp::join('users', 'users.id', 'user_id')
            ->where('stamp_date', $date)
            ->orderBy('stamps.updated_at','asc')
            ->paginate(5);

        return view('showTable', compact('users', 'date'));
    }

    public function search(Request $request)
    {
        $date = $request->date;
        $users = Stamp::join('users', 'users.id', 'user_id')
            ->where('stamp_date', $date)
            ->orderBy('stamps.updated_at', 'asc')
            ->paginate(5);

        return view('showTable', compact('users', 'date'));
    }
}
