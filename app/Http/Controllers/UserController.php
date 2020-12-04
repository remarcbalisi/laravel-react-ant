<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return new UserResource($user);
    }

    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->except('role'));
        $user->assignRole(Role::where('name', $request->role)->first());
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user = tap($user)->update($request->except('role'));
        if($request->is('api/admin/user/*')){
            $user->syncRoles([Role::where('name', $request->role)->first()]);
        }
        return new UserResource($user);
    }
}
