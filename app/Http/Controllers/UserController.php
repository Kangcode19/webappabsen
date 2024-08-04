<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $departemen = DB::table('departemen')->orderBy('kode_dept')->get();
        $role = DB::table('roles')->orderBy('id')->get();
        $query = User::query();
        $query->select('users.id', 'users.name', 'email', 'nama_dept', 'roles.name as role', 'kode_cabang');
        $query->join('departemen', 'users.kode_dept', '=', 'departemen.kode_dept');
        $query->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id');
        $query->join('roles', 'model_has_roles.role_id', '=', 'roles.id');
        if (!empty($request->name)) {
            $query->where('users.name', 'like', '%' . $request->name . '%');
        }
        $users = $query->paginate(10);
        $users->appends(request()->all());

        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        return view('users.index', compact('users', 'departemen', 'role', 'cabang'));
    }


    public function store(Request $request)
    {
        $nama_user = $request->nama_user;
        $email = $request->email;
        $kode_dept = $request->kode_dept;
        $role = $request->role;
        $password = bcrypt($request->password);
        $kode_cabang = $request->kode_cabang;
        DB::beginTransaction();
        try {

            $user = User::create([
                'name' => $nama_user,
                'email' => $email,
                'kode_dept' => $kode_dept,
                'password' => $password,
                'kode_cabang' => $kode_cabang
            ]);

            $user->assignRole($role);

            DB::commit();

            return Redirect::back()->with(['success' => ' Data Berhasil Disimpan']);
        } catch (\Exception $e) {

            dd($e);
            DB::rollBack();
            return Redirect::back()->with(['warning' => ' Data Gagal Disimpan']);
        }
    }

    public function edit(Request $request)
    {
        $id_user = $request->id_user;
        $departemen = DB::table('departemen')->orderBy('kode_dept')->get();
        $role = DB::table('roles')->orderBy('id')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        $user = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('id', $id_user)->first();
        return view('users.edituser', compact('departemen', 'role', 'user', 'cabang'));
    }

    public function update(Request $request, $id_user)
    {
        $nama_user = $request->nama_user;
        $email = $request->email;
        $kode_dept = $request->kode_dept;
        $role = $request->role;
        $password = bcrypt($request->password);
        $kode_cabang = $request->kode_cabang;

        if (isset($request->password)) {
            $data = [
                'name' => $nama_user,
                'email' => $email,
                'kode_dept' => $kode_dept,
                'kode_cabang' => $kode_cabang,
                'password' => $password
            ];
        } else {
            $data = [
                'name' => $nama_user,
                'email' => $email,
                'kode_dept' => $kode_dept,
                'kode_cabang' => $kode_cabang
            ];
        }

        DB::beginTransaction();
        try {
            //UPdate Data User
            DB::table('users')->where('id', $id_user)
                ->update($data);

            //UPdate Data Role
            DB::table('model_has_roles')->where('model_id', $id_user)
                ->update([
                    'role_id' => $role
                ]);

            DB::commit();
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        } catch (\Exception $e) {

            dd($e);
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }


    public function delete($id_user)
    {
        try {
            DB::table('users')->where('id', $id_user)->delete();
            return Redirect::back()->with(['success' => ' Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => ' Data Gagal Dihapus']);
        }
    }
}
