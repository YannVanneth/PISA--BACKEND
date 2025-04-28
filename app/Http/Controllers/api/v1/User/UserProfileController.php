<?php

namespace App\Http\Controllers\api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User\UserModel;
use App\Models\User\UserProfileModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function index()
    {
        return UserProfileModel::all();
    }

    public function store(Request $request)
    {
        return UserProfileModel::create($request->all());
    }

    public function show($id)
    {
        return UserProfileModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'first_name' => 'string|max:60|nullable',
                'last_name' => 'string|max:60|nullable',
                'image_url' => 'file|mimes:jpeg,png,jpg,gif,svg|max:204|nullable',
                'password' => 'string|min:8|nullable',
            ]);

            DB::beginTransaction();
            $userProfile = UserProfileModel::find($id);

            if (!$userProfile) {
                return response()->json(['message' => 'User not found'], 404);
            }

            if ($request->filled('first_name')) {
                $userProfile->first_name = $request->input('first_name');
            }

            if ($request->filled('last_name')) {
                $userProfile->last_name = $request->input('last_name');
            }

            if ($request->filled('password')) {
                $userProfile->password = Hash::make($request->input('password'));
            }

            if ($request->hasFile('image_url')) {

                $image = $request->file('image_url');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $imageURL = url('images/' . $imageName);

                $oldImage = $userProfile->image_url;
                if ($oldImage) {
                    $oldImagePath = public_path(parse_url($oldImage, PHP_URL_PATH));
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $userProfile->image_url = $imageURL;
            }


            $userProfile->update([
                'first_name' => $userProfile->first_name,
                'last_name' => $userProfile->last_name,
                'image_url' => $userProfile->image_url,
            ]);

            DB::commit();
            return response()->json([
                'message' => 'User updated successfully',
                'data' => $userProfile,
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'error' => $exception->getMessage(),
                'message' => 'Oops! Something went wrong!'
            ], 500);
        }
    }


    public function destroy($id)
    {
        UserProfileModel::destroy($id);
        return response()->noContent();
    }
    public function checkExistingUser(Request $request)
    {
        try{
            $username = $request->query('username');
            $email = $request->query('email');

            $user = UserProfileModel::where('email', $email)->first();
            $username = UserModel::where('username', $username)->first();

            if($user || $username){
                return response()->json([
                    'message' => 'Username or Email already exists',
                    'is_available' => false
                ], 200);
            };

            return response()->json([
                'message' => 'Username and Email available',
                'is_available' => true
            ], 200);

        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage(), 'message' => 'Oops! Something went wrong.'], 500);
        }
    }
}
