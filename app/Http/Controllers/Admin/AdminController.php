<?php

namespace App\Http\Controllers\Admin;

use Config;
use Auth;
use DB;
use App\Admin;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Role;
use App\Http\Requests\AdminFormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdminUsers()
    {
        return view('admin.admin.index');
    }

    public function createAdminUser()
    {
        $roles = Role::select('role_name', 'id')->orderBy('role_name')->pluck('role_name', 'id')->toArray();
        /*
          print_r($roles);
          print_r(['0' => 'Select a Role']+$roles);exit;
         */
        return view('admin.admin.create')->with('roles', $roles);
    }

    public function storeAdminUser(AdminFormRequest $request)
    {
        $user = new Admin;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role_id;
        $user->save();
        /*         * ******************** */
        Mail::send('admin.admin.emails.new_admin_user_created', ['user' => $user], function ($msg) use ($user) {
            $msg->from(config('mail.recieve_to.address'), config('mail.recieve_to.name'));
            $msg->to($user->email, $user->name)->subject('Please set your password to ' . config('app.name') . ' admin panel.');
        });
        /*         * ******************** */
        flash('New Admin User has been created!')->success();
        return \Redirect::route('edit.admin.user', array($user->id));
    }

    public function editAdminUser($id)
    {
        $user = Admin::findOrFail($id);
        $roles = Role::select('role_name', 'id')->orderBy('role_name')->pluck('role_name', 'id')->toArray();
        return view('admin.admin.edit')->with('roles', $roles)->with('user', $user);
    }

    public function updateAdminUser($id, AdminFormRequest $request)
    {
        $user = Admin::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->role_id = $request->role_id;
        $user->save();
        flash('Admin User has been updated!')->success();
        return \Redirect::route('edit.admin.user', array($user->id));
    }

    public function deleteAdminUser(Request $request)
    {
        $id = $request->input('id');
        try {
            $user = Admin::findOrFail($id);
            $user->delete();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function fetchAdminUsersData()
    {
        $users = Admin::join('roles', 'admins.role_id', '=', 'roles.id')
                ->select('admins.id', 'admins.name', 'admins.email', 'roles.role_name');
        return Datatables::of($users)
                        ->addColumn('action', function ($user) {
                            return '<a href="' . route('edit.admin.user', ['id' => $user->id]) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a><a href="javascript:void(0);" onclick="delete_user(' . $user->id . ');" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
                        })
                        ->removeColumn('password')
                        ->setRowId(function($user) {
                            return 'admin_user_dt_row_' . $user->id;
                        })
                        ->make(true);
    }

}
