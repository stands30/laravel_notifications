<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Input;
use Redirect;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        if( Auth::user()->user_role != 'admin'){
            return view('home');
        }

        if($request->ajax()){

            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('notification_status', function($row){
                    $checked = ($row->is_notification_enabled == 1 ) ? "checked":'';
                    return '<label class="switch">
                            <input type="checkbox" '.$checked.'  class="notification_status" data-id="'.$row->id.'" >
                                <span class="slider round"></span>z
                    </label>';
                })
                ->addColumn('unred_count', function($row){
                    return $row->un_read_notif_count;
                })
                ->rawColumns(['notification_status'])
                ->make(true);
        }
        $notifications = auth()->user()->unreadNotifications->where('expiration_date','<', now());
        return view('user_list', compact('notifications'));
    }

    public static function update(Request $request, $id)
    {
        // validate
        $rules = array(
            'notification_status'       => 'required',
        );
        $validator = Validator::make($request->post(), $rules);
        // process the login
        if ($validator->fails()) {
            return response()->json([
                        'message' => "Notification Status missing",
                        'status' => false,
            ], 404);
        } else {
            // store
            $user = User::find($id);
            $user->is_notification_enabled = $request->post('notification_status');
            $user->save();

            // redirect
            return response()->json([
                        'message' => "Notification Status updated",
                        'status' => true,
            ], 200);
        }
    }

    public static function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }


}
