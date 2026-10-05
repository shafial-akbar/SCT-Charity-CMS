<?php
namespace App\Http\Controllers\Api\V1\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller {
 public function login(Request $request): JsonResponse {
  $d=$request->validate(['email'=>['required','email'],'password'=>['required','string'],'device_name'=>['nullable','string','max:100']]);
  $u=\App\Models\User::where('email',$d['email'])->first();
  if(!$u || !Hash::check($d['password'],$u->password)) throw ValidationException::withMessages(['email'=>['The provided credentials are incorrect.']]);
  if(isset($u->status) && $u->status!=='active') return response()->json(['message'=>'Your account is not active.'],403);
  $token=$u->createToken($d['device_name']??'admin-panel',['admin'])->plainTextToken;
  if(property_exists($u,'last_login_at') || \Schema::hasColumn('users','last_login_at')) { $u->forceFill(['last_login_at'=>now()])->save(); }
  $u->load('roles.permissions');
  return response()->json(['message'=>'Login successful.','token'=>$token,'token_type'=>'Bearer','user'=>$u]);
 }
 public function me(Request $r): JsonResponse { return response()->json(['user'=>$r->user()->load('roles.permissions')]); }
 public function logout(Request $r): JsonResponse { $r->user()->currentAccessToken()?->delete(); return response()->json(['message'=>'Logged out successfully.']); }
 public function logoutAll(Request $r): JsonResponse { $r->user()->tokens()->delete(); return response()->json(['message'=>'All sessions have been logged out.']); }
}
