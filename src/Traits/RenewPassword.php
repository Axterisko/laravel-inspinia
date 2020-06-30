<?php


namespace Axterisko\Inspinia\Traits;


use Carbon\Carbon;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

trait RenewPassword
{
    use RedirectsUsers;

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'password' => 'required|password',
            'new_password' => 'required|min:8|confirmed|different:password'
        ];
    }

    /**
     * Get the password reset validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }

    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);
        $user->save();
        $this->guard()->login($user);
    }

    /**
     * Set the user's password.
     *
     * @param \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param string $password
     * @return void
     */
    protected function setUserPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->password_changed_at = Carbon::now();
    }

    /**
     * Display the password renew view
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRenewForm(Request $request)
    {
        return view('auth.passwords.renew');
    }


    /**
     * Reset the given user's password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function renew(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $this->resetPassword(auth()->user(), $request->input('new_password'));

        $message = trans('inspinia::auth.renew.renew_confirmed');

        if ($request->wantsJson()) {
            return new JsonResponse(['message' => $message], 200);
        }

        return redirect($this->redirectPath())
            ->with('status', $message);
    }
}
