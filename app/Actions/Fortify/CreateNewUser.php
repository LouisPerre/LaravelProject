<?php

namespace App\Actions\Fortify;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param array $input
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'pseudo' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'profile_picture' => ['required', File::types(['png', 'jpg', 'jpeg']), 'max:2048'],
            'birth_date' => ['date'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
        $file = Storage::disk('public')->put('profile-photos', $this->request->file('profile_picture'));

        $user = User::create([
            'name' => $input['name'],
            'last_name' => $input['last_name'],
            'pseudo' => $input['pseudo'],
            'email' => $input['email'],
            'profile_photo_path' => $file,
            'birth_date' => $input['birth_date'],
            'password' => Hash::make($input['password']),
        ]);
        $user->roles()->attach(Role::where('name', 'admin')->first());
        return $user;
    }
}
