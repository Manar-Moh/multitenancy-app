<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {

        $invitationEmail = null;

        if (request('token')) {
            $invitation = Invitation::where('token', request('token'))
                ->whereNull('accepted_at')
                ->firstOrFail();
            $invitationEmail = $invitation->email;
        }
//        return view('auth.register');
        return view('auth.register', compact('invitationEmail'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'subdomain' => ['sometimes', 'alpha', 'unique:'.Tenant::class],
        ]);
        $email = $request->email;
        $invitation = null;

        if ($request->has('tokenInvitation')) {
            $invitation = Invitation::with('tenant')
                ->where('token', $request->tokenInvitation)
                ->whereNull('accepted_at')
                ->firstOr(function () {
                    throw ValidationException::withMessages([
                        'email' => __('Invitation link incorrect'),
                    ]);
                });

            $email = $invitation->email;
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->password),
        ]);

        if($request->has('tokenInvitation')){
            $invitation->update(['accepted_at' => now()]);
            $user->tenants()->attach($invitation->tenant_id);
            $user->update(['current_tenant_id' => $invitation->tenant_id]);
        }else{
            $tenant = Tenant::create(['name' => $request->name.' Team','subdomain' => $request->subdomain]);
            $tenant->users()->attach($user, ['is_owner' => true]);
            $user->update(['current_tenant_id' => $tenant->id]);
        }

        event(new Registered($user));

        Auth::login($user);
        $tenantDomain = str_replace('://', '://' . $tenant->subdomain . '.', config('app.url'));
        return redirect($tenantDomain . route('dashboard', absolute: false));
//        return redirect(route('dashboard', absolute: false));
    }
}
