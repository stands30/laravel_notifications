<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Validator;
use Illuminate\Support\Facades\Input;
use Redirect;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function index(Request $request)
    // {
    //     return self::getUserList($request);
    //     return view('welcome');
    // }

    public function index(Request $request){
        if(\request()->ajax()){

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
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['notification_status'])
                ->make(true);
        }
        return view('user_list');
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

}
