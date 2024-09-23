<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $tenant = auth()->user()->tenants()->findOrFail($request->id);
        auth()->user()->update(['current_tenant_id' => $tenant->id]);
        return redirect()->route('projects');
    }
}
