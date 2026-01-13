<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Submodule;
use Illuminate\Http\Request;

class CompanySubmoduleController extends Controller
{
    public function assign(Request $request, Company $company, Submodule $submodule)
    {
        $request->validate([
            'config' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        if (!$company->submodules->contains($submodule->id)) {
            $company->submodules()->attach($submodule->id, [
                'is_active' => $request->boolean('is_active', true),
                'config' => json_encode($request->config ?? [])
            ]);
        } else {
            $company->submodules()->updateExistingPivot($submodule->id, [
                'is_active' => $request->boolean('is_active', true),
                'config' => json_encode($request->config ?? $company->submodules->find($submodule->id)->pivot->config ?? [])
            ]);
        }

        return redirect()->back()->with('success', 'Submodule assigned successfully.');
    }

    public function remove(Company $company, Submodule $submodule)
    {
        $company->submodules()->detach($submodule->id);
        return redirect()->back()->with('success', 'Submodule removed successfully.');
    }

    public function toggleStatus(Company $company, Submodule $submodule)
    {
        $currentStatus = $company->submodules->find($submodule->id)->pivot->is_active ?? false;
        
        $company->submodules()->updateExistingPivot($submodule->id, [
            'is_active' => !$currentStatus
        ]);

        return redirect()->back()->with('success', 'Submodule status updated successfully.');
    }
}
