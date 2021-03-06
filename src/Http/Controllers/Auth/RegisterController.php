<?php

namespace Module\Customer\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Module\Customer\Models\Customer;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest:customer']);
    }

    public function showRegistrationForm()
    {
        return view('customer::auth.register');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname'  => ['required', 'string', 'max:255'],
            'phone'     => ['required', 'numeric', 'unique:customer__customers,phone'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:customer__customers'],
            'password'  => ['required', 'string', 'min:6', 'confirmed'],
        ], [], [
            'name'                  => __('customer::customer.name'),
            'firstname'             => __('customer::customer.firstname'),
            'lastname'              => __('customer::customer.lastname'),
            'phone'                 => __('customer::customer.phone'),
            'email'                 => __('customer::customer.email'),
            'password'              => __('customer::customer.password'),
            'password_confirmation' => __('customer::customer.password_confirmation'),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Model|Customer
     */
    protected function create(array $data)
    {
        return Customer::create([
            'email'     => $data['email'],
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname'],
            'phone'     => $data['phone'],
            'password'  => Hash::make($data['password']),
        ]);
    }

    /**
     * Get the post register redirect path.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $config = config('customer.redirect_after_login', route('customer.web.customer.profile'));

        return is_callable($config) ? $config() : $config;
    }
}
