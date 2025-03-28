<?php

namespace App\Rules;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class Valid2FACode implements Rule
{
    /**
     * The ID of the user.
     *
     * @var int
     */
    protected $userId;

    /**
     * Create a new rule instance.
     *
     * @param int $userId
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::find($this->userId);
        return $user && $user->code && Hash::check($value, $user->code) && Carbon::now()->lessThanOrEqualTo($user->code_expires_at);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid code';
    }
}