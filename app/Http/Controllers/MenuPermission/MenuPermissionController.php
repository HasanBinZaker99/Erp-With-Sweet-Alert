<?php

namespace App\Http\Controllers\MenuPermission;
use App\Models\UserManagement\MenuPermission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuPermissionController extends Controller
{

    public function MenuPermitView(){
        return view('Menu-Permission.menuPermission');
    }
    public function givepermission(Request $request){
        $menuPermission = new MenuPermission();
        $menuPermission->userId = $request->user;
        $menuPermission->menuIds =json_encode($request->menu);
        $menuPermission->subMenuIds =json_encode($request->submenu);
        $menuPermission->actions =json_encode($request->action);
        $menuPermission->save();
        return "Menu added successfully";

    }
}
