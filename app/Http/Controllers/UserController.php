<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Invitation;
use App\Notifications\SendInvitationNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $invitations = Invitation::where('user_id', auth()->id())->where('tenant_id', auth()->user()->current_tenant_id)->get();
        return view('users',compact('invitations'));
    }

    public function store(StoreUserRequest $request)
    {
//wuryvokyka@mailinator.com
        $tenantId = auth()->user()->current_tenant_id;

        $invitation = Invitation::create([
            'tenant_id' => $tenantId,
            'email' => $request->email,
            'token' => Str::random(32),
            'user_id' => auth()->id(),
        ]);

        Notification::route('mail', $request->email)->notify(new SendInvitationNotification($invitation));

        return redirect()->route('users.index');
    }

    public function acceptInvitation(string $token)
    {
        $invitation = Invitation::where('token', $token)->whereNull('accepted_at')->firstOrFail();

        if(auth()->check()){
            $invitation->update(['accepted_at', now()]);

            auth()->user()->tenants()->attach($invitation->tenant_id);

            auth()->user()->update([
                'current_tenant_id' => $invitation->tenant_id
            ]);

            return redirect()->route('dashboard');

        }else{
            return redirect()->route('register', ['token' => $token]);
        }
    }
}
