<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Response;

class UserController extends Controller
{
    #[Endpoint("Get users list", <<<DESC
    This endpoint allows you to get users list but not using UserResource.
    It's a really useful endpoint, and you should play around 
    with it for a bit.
    <aside class="notice">We mean it; you really should.😕</aside>
   DESC)]
    public function index(Request $request)
    {
        return new JsonResource(User::query()
            ->when($request->get('email'), function($query, $email) {
                return $query->where('email', $email);
            })
            ->when($request->get('name'), function($query, $name) {
                return $query->where('name', 'ilike', "%$name%");
            })
            ->select('id', 'name', 'email')
            ->get()
        );
    }

    #[Response(description: 'success', content: [
        'data' => [
            'id' => 1,
            'name' => 'Testing',
            'email' => 'testing@example.com'
        ]
    ])]
    #[Response(status: 404, description: 'user not found', content: [
        'message' => 'User not found'
    ])]
    public function show(User $user)
    {
        return new JsonResource($user->only('id', 'name', 'email'));
    }
}
