<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stamp;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;


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

        $stamps = Stamp::join('users', 'users.id', 'user_id')
            // ->join('rests','stamps.id','stamp_id')
            ->where('stamp_date', $date)
            ->orderBy('stamps.updated_at','asc')
            ->paginate(5);

        return view('showTable', compact('stamps', 'date'));
    }

    public function search(Request $request)
    {
        $date = $request->date;
        $stamps = Stamp::join('users', 'users.id', 'user_id')
            ->where('stamp_date', $date)
            ->orderBy('stamps.updated_at', 'asc')
            ->paginate(5);

        return view('showTable', compact('stamps', 'date'));
    }
}
