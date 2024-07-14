<?php

namespace App\Http\Controllers\Mobile;

use App\Enums\ProjectStatusTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\FeedbackRequest;
use App\Http\Resources\ProjectCardResource;
use App\Http\Resources\UserResource;
use App\Models\Feedback;
use App\Models\ProjectUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @tags 😸 Mobile > 2 > Profile
 */
class ProfileController extends Controller
{

    /**
     * Profile
     *
     * Bu servis sisteme giriş yapmış kullanıcının profil bilgilerinin çekildiği servistir.
     */
    public function profile()
    {
        $userId = null;
        if (!$userId = @(Auth::guard('user-api')->user())->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::find($userId);

        if (!$user) {
            abort(response()->json([
                "Kullanıcı bulunamadı"
            ], 400));
        }


        return [
            /** @var UserResource */
            "user" => new UserResource($user),
        ];
    }
}
