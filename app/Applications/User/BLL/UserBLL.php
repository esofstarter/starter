<?php

namespace App\Applications\User\BLL;

use App\Applications\Common\DAL\MediaDALInterface;
use App\Applications\User\DAL\UserDALInterface;
use App\Mail\ActivateUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @property UserDALInterface $userDAL
 * @property MediaDALInterface $mediaDAL
 */
class UserBLL implements UserBLLInterface
{
    use DispatchesJobs;

    public function __construct(
        UserDALInterface $userDAL,
        MediaDALInterface $mediaDAL,
    ){
        $this->userDAL = $userDAL;
        $this->mediaDAL = $mediaDAL;
    }

    public function getAllUsers(){
        return $this->userDAL->getAll();
    }

    public function getUserByIdForFormEdit($id){
        return $this->userDAL->getUserByIdForFormEdit($id);
    }

    public function saveNewUser($request){
        $request_array = $request->all();
        if(empty($request_array['password']))
            unset($request_array['password']);
        $request_array['is_disabled'] = (integer)$request_array['is_disabled'];
        $user = $this->userDAL->saveNewUser($request_array);
        //TODO This works but always adds a new image instead of editing the previous
        $this->mediaDAL->save($request, $user, 'user_avatars');
        if(!empty($request_array['password']))
            $this->userDAL->setUserPassword($user, $request_array['password']);
        $this->userDAL->changeRoles($user->id, $request_array['roles']);
        return $user;
    }

    public function saveNewPublicUser($request){
        $request_array = $request->all();
        $activation_code = hash_hmac('sha256', str_random(40), config('app.key'));
        $request_array['activation_code'] = $activation_code;
        $user = $this->userDAL->saveNewUser($request_array);
        if(!empty($request_array['password']))
            $this->userDAL->setUserPassword($user, $request_array['password']);
        $this->userDAL->changeRoles($user->id, 3);
        Mail::to($user->email)->send(new ActivateUser($user));
        return $user;
    }

    public function editUser($request, $id){
        $request_array = $request->all();
        $user_data = $request_array;
        unset($user_data['password']);
        $user = $this->userDAL->getUserById($id);
        //TODO This works but always adds a new image instead of editing the previous
        $this->mediaDAL->save($request, $user, 'user_avatars');
        $request_array['is_disabled'] = (integer)$request_array['is_disabled'];
        $this->userDAL->editUser($user, $user_data);
        if(!empty($request_array['password']) || $request_array['password'] != null)
            $this->userDAL->setUserPassword($user, $request_array['password']);
        $this->userDAL->changeRoles($id, $request_array['roles']);
    }

    public function editMyProfile($request){
        $request_array = $request->all();
        $user = $this->userDAL->getUserById(Auth::user()->id);
        $this->mediaDAL->save($request, $user, 'user_avatars');
        $data['first_name'] = $request_array['first_name'];
        $data['last_name'] = $request_array['last_name'];
        $data['email'] = $request_array['email'];
        if (array_key_exists('country_id', $request_array)) $data['country_id'] = $request_array['country_id'];
        $this->userDAL->editUser($user, $data);
        if($request_array['password']!=null)
            $this->userDAL->setUserPassword($user, $request_array['password']);
    }

    public function editMyAvatar($request){
        $user = $this->userDAL->getUserById(Auth::user()->id);
        $this->mediaDAL->save($request, $user, 'user_avatars');
    }

    public function getDatatablesReady($request){
        $data['columns'] = Array('users.first_name', 'users.last_name', 'email', 'roles.id', 'users.is_disabled');
        $data['length'] = $request->input('length');
        $data['column'] = $request->input('column'); //Index
        $data['dir'] = $request->input('dir');
        // TODO: Improve this segment
        // this logic is required so that sorting can be done alphabetically
        if ($data['column'] == 6) {
            if ($data['dir'] == 'asc') {
                $data['dir'] = 'desc';
            } else {
                $data['dir'] = 'asc';
            }
        }
        $data['search'] = $request->input('search');
        $data['draw'] = $request->input('draw');
//        $data['lang'] = $request->input('lang');

        return $this->userDAL->getDataTablesReady($data);
    }

    public function getDatatablesReadyPublic($request){
        $data['columns'] = Array('users.first_name', 'users.last_name', 'email', 'roles.id', 'users.is_disabled');
        $data['length'] = $request->input('length');
        $data['column'] = $request->input('column'); //Index
        $data['dir'] = $request->input('dir');
        // TODO: Improve this segment
        // this logic is required so that sorting can be done alphabetically
        if ($data['column'] == 6) {
            if ($data['dir'] == 'asc') {
                $data['dir'] = 'desc';
            } else {
                $data['dir'] = 'asc';
            }
        }
        $data['search'] = $request->input('search');
        $data['draw'] = $request->input('draw');
        $data['source'] = $request->input('source');
//        $data['lang'] = $request->input('lang');

        return $this->userDAL->getDataTablesReadyPublic($data);
    }

    public function getDataExportPublic($request){
        $data['columns'] = Array('users.first_name', 'users.last_name', 'email', 'roles.id', 'users.is_disabled');
        $data['column'] = $request->input('column'); //Index
        $data['dir'] = $request->input('dir');
        // TODO: Improve this segment
        // this logic is required so that sorting can be done alphabetically
        if ($data['column'] == 6) {
            if ($data['dir'] == 'asc') {
                $data['dir'] = 'desc';
            } else {
                $data['dir'] = 'asc';
            }
        }
        $data['search'] = $request->input('search');
        $data['source'] = $request->input('source');

        return $this->userDAL->getDataExportPublic($data);
    }

    public function getDataExportAdmin($request){
        $data['columns'] = Array('users.first_name', 'users.last_name', 'email', 'roles.id', 'users.is_disabled');
        $data['column'] = $request->input('column'); //Index
        $data['dir'] = $request->input('dir');
        // TODO: Improve this segment
        // this logic is required so that sorting can be done alphabetically
        if ($data['column'] == 6) {
            if ($data['dir'] == 'asc') {
                $data['dir'] = 'desc';
            } else {
                $data['dir'] = 'asc';
            }
        }
        $data['search'] = $request->input('search');
        $data['source'] = $request->input('source');

        return $this->userDAL->getDataExportAdmin($data);
    }

    public function getUserRoles(){
        return $this->userDAL->getUserRoles()->toJson();
    }

    public function getAdmins($count, $search){
        return $this->userDAL->getAdmins($count, $search);
    }

    public function deleteUser($id){
        return $this->userDAL->delete($id);
    }

    public function userActivate($request){
        $request_array = $request->all();
        $token = $request_array['token'];
        $user = $this->userDAL->findUserByActivationCode($token);
        if ($user) {
            $this->userDAL->activateUser($user);
            // TODO: #26689 Log in activated user
            $userToken = auth()->login($user);
            $user = Auth::user();
            $user['roles_array'] = $user->roles_array();
            $permissions = $user->permissions_array();
            $user['permissions_array'] = $permissions;
            return response()->json([
                'user' => $user,
                'access_token' => $userToken,
                'token_type' => 'bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
            ])->header('Authorization', $userToken);
        } else {
            return response()->json([
                'error' => 'Problem activating user'
            ]);
        }
    }
}



