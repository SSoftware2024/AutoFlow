<?php
namespace App\Actions\Fortify\Admin;

use App\Models\Administrator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateAdminPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param  array<string, string>  $input
     */
    public function update(Administrator $user, array $input, bool $validate_default = true): void
    {
        if($validate_default){
            Validator::make($input, [
                'current_password' => ['required', 'string', 'current_password:admin'],
                'password' => $this->passwordRules(),
            ], [
                'current_password.current_password' => __('The provided password does not match your current password.'),
            ])->validateWithBag('updatePassword');
        }

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
