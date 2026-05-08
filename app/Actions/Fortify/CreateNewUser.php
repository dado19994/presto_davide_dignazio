<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     *
     * @throws ValidationException
     */
    public function create(array $input): User
    {
        Validator::make(
            $input,

            // REGOLE
            [
                'name' => ['required', 'string', 'min:3', 'max:255'],

                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ],

                'password' => ['required', 'confirmed', 'min:8'],
            ],

            // MESSAGGI PERSONALIZZATI
            [
                'name.required' => 'Il nome è obbligatorio.',
                'name.min' => 'Il nome deve contenere almeno 3 caratteri.',

                'email.required' => 'L\'email è obbligatoria.',
                'email.email' => 'Inserisci un indirizzo email valido.',
                'email.unique' => 'Questa email è già registrata.',

                'password.required' => 'La password è obbligatoria.',
                'password.min' => 'La password deve contenere almeno 8 caratteri.',
                'password.confirmed' => 'Le password non coincidono.',
            ],

            // NOMI LEGGIBILI CAMPI
            [
                'name' => 'nome',
                'email' => 'email',
                'password' => 'password',
            ]

        )->validate();

        return User::create([
        'name' => $input['name'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
    ]);
    }
}
