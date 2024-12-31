<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Response;
use Knuckles\Scribe\Attributes\ResponseField;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group("User Management", 'A group for managing users')]
class ResourceUserController extends Controller
{
    // #[Group("Get users list")]
    #[QueryParam('name', 'string', description: 'Filter users by name', required: false, example: 'John')]
    #[ResponseFromApiResource(UserResource::class, User::class, collection: true, paginate: 10, with: ['posts'],
    additional: [
        'message' => 'Success'
    ])]
    #[ResponseField("id", "integer", "The id of the newly created word")]
    #[ResponseField("posts.id", "The id of the newly created word")]
    public function index(Request $request)
    {
        $input = $request->validate([
            'name' => 'string',
            'email' => 'string',
        ]);
        $users = User::with('posts')
            ->when($request->get('email'), function($query, $email) {
                return $query->where('email', $email);
            })
            ->when($request->get('name'), function($query, $name) {
                return $query->where('name', 'like', "%$name%");
            });

        return UserResource::collection($users->paginate(10))
            ->additional([
                'message' => 'Success',
            ]);
    }

    #[Authenticated()]
    #[ResponseFromApiResource(UserResource::class, User::class, collection: false, with: ['posts'],
    additional: [
        'message' => 'Success'
    ])]
    #[ResponseField("id", "integer", "The id of the newly created word")]
    #[ResponseField("posts.id", "The id of the newly created word")]
    public function show(User $resourceUser, Request $request)
    {
        $resourceUser->load('posts');
        return (new UserResource($resourceUser))->additional([
            'message' => 'Success',
        ]);
    }
}
