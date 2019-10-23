<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class ChangePasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showChangeForm(Request $request)
    {
        return view('auth.passwords.change')->with(
            ['email' => $request->user()->email]
        );
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function change(Request $request)
    {
        if ($request->user()->email != $request->email) {
            throw new \Exception("tried to change someone elss password! or not logged in..");
        }

        $this->validate($request, $this->rules());


        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    protected function sendResetResponse($response)
    {
        return redirect($this->redirectPath())
                            ->with('status', $response);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => $response]);
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation'
        );
    }

    protected function validateReset(array $credentials)
    {
        if (is_null($user = $this->broker()->getUser($credentials))) {
            return Password::INVALID_USER;
        }
 
        if (! $this->broker()->validateNewPassword($credentials)) {
            return Password::INVALID_PASSWORD;
        }
 
        return $user;
    }

    /**
     * Reset the password for the given token.
     *
     * @param  array  $credentials
     * @param  \Closure  $callback
     * @return mixed
     */
    public function reset(array $credentials, Closure $callback)
    {
        // If the responses from the validate method is not a user instance, we will
        // assume that it is a redirect and simply return it from this method and
        // the user is properly redirected having an error message on the post.
        $user = $this->validateReset($credentials);

        if (! $user instanceof CanResetPasswordContract) {
            return $user;
        }

        $password = $credentials['password'];

        // Once the reset has been validated, we'll call the given callback with the
        // new password. This gives the user an opportunity to store the password
        // in their persistent storage. Then we'll delete the token and return.
        $callback($user, $password);

        return Password::PASSWORD_RESET;
    }

}
