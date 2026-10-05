<?php
namespace App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRoleController extends Controller {
 public function assign(Request $r, User $user): JsonResponse {
  $d=$r->validate(['role_id'=>['required','uuid','exists:roles,id']]);
  $role=Role::findOrFail($d['role_id']);
  DB::table('user_roles')->updateOrInsert(['user_id'=>$user->id,'role_id'=>$role->id],[]);
  return response()->json(['message'=>'Role assigned successfully.','user'=>$user->load('roles.permissions')]);
 }
 public function remove(Request $r, User $user, Role $role): JsonResponse {
  DB::table('user_roles')->where('user_id',$user->id)->where('role_id',$role->id)->delete();
  return response()->json(['message'=>'Role removed successfully.']);
 }
}
