<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use App\Models\User;
use JWTAuth;

class authorise_controller extends Controller
{
    public function user(Request $request) {
        $username = $request->search.'%';
        $name = $request->search.'%';

        $users = DB::table('users')
                ->orWhere('username', 'like', $username)
                ->orWhere('name', 'like', $name)
                ->orderBy('username')
                ->select('*')
                ->paginate(10);
        return $users;
    }

    public function codeMenu() {
        $menuCode = DB::table('code_menus')->select('menu as value', 'name')->orderBy('menu', 'asc')->get();
        return $menuCode;
    }

    public function authMenu(Request $request) {
        $userMenu = DB::select('select b.user_id, a.menu, a.name, b.acc from code_menus a, user_auth_menus b where b.menu = a.menu order by b.user_id, a.menu');
        return $userMenu;
    }

    public function codeSubmenu() {
        $menuCode = DB::table('code_submenus')->select('menu', 'sub', 'name')->orderBy('menu', 'asc')->orderBy('sub_id', 'asc')->get();
        return $menuCode;
    }

    public function authSubmenu(Request $request) {
        $authSub = DB::select('select b.user_id, b.menu, b.sub, a.name, b.acc, b.new, b.edit, b.del from code_submenus a, user_auth_submenus b where b.menu = a.menu and b.sub = a.sub order by user_id, menu, sub_id');
        return $authSub;
    }

    public function addAuthMenu(Request $request) {
        foreach($request->menuList as $menu) {
            DB::table('user_auth_menus')
            ->insert([
                'user_id' => $request->user_id,
                'menu' => $menu,
                'acc' => 1
            ]);
        }
    }

    public function updAuthMenu(Request $request) {
        DB::table('user_auth_menus')
            ->where('user_id', $request->user_id)
            ->where('menu', $request->menu)
            ->update([
                'acc' => $request->acc
            ]);
    }

    public function addAuthSubmenu(Request $request) {
        foreach($request->subList as $sub) {
            $check = DB::table('user_auth_submenus')
                    ->where('user_id', $request->user_id)
                    ->where('menu', $sub['menu'])
                    ->where('sub', $sub['sub']); 

            if (!$check->count()) {
                DB::table('user_auth_submenus')
                ->insert([
                    'user_id' => $request->user_id,
                    'menu' => $sub['menu'],
                    'sub' => $sub['sub'],
                    'acc' => $sub['acc'],
                    'new' => $sub['new'],
                    'edit' => $sub['edit'],
                    'del' => $sub['del']
                ]);
            }
        }
    }

    public function updAuthSubmenu(Request $request) {
        DB::table('user_auth_submenus')
        ->where('user_id', $request->user_id)
        ->where('menu', $request->menu)
        ->where('sub', $request->sub)
        ->update([
            'acc' => $request->acc,
            'new' => $request->new,
            'edit' => $request->edit,
            'del' => $request->del
        ]);
    } 

    public function authAccess() {
        $userId = Auth::user()->id;
        $authAcc = DB::select('exec dbo.usp_auth_accesses ?', [$userId]);
        return response()->json($authAcc);
    }

    public function authAction(Request $request) {
        $userId = Auth::user()->id;
        $authAction = DB::table('user_auth_submenus')
                        ->where('user_id', $userId)
                        ->where('sub', $request->submenu)
                        ->get();
        return $authAction;
    }
}
