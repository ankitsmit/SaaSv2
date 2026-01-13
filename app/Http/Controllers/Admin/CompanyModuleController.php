<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Module;
use App\Models\Submodule;
use Illuminate\Http\Request;

class CompanyModuleController extends Controller
{
    public function assign(Request $request, Company $company, Module $module)
    {
        $request->validate([
            'config' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        if (!$company->modules->contains($module->id)) {
            $company->modules()->attach($module->id, [
                'is_active' => $request->boolean('is_active', true),
                'config' => json_encode($request->config ?? [])
            ]);

            // Auto-assign submodules
            $submodules = $module->submodules()->where('is_active', true)->get();
            foreach ($submodules as $submodule) {
                if (!$company->submodules->contains($submodule->id)) {
                    $company->submodules()->attach($submodule->id, [
                        'is_active' => true,
                        'config' => json_encode([])
                    ]);
                }
            }
        } else {
            $company->modules()->updateExistingPivot($module->id, [
                'is_active' => $request->boolean('is_active', true),
                'config' => json_encode($request->config ?? $company->modules->find($module->id)->pivot->config ?? [])
            ]);
        }

        return redirect()->back()->with('success', 'Module assigned successfully.');
    }

    public function remove(Company $company, Module $module)
    {
        $company->modules()->detach($module->id);
        
        // Also remove submodules
        $submoduleIds = $module->submodules->pluck('id');
        $company->submodules()->detach($submoduleIds);

        return redirect()->back()->with('success', 'Module removed successfully.');
    }

    public function toggleStatus(Company $company, Module $module)
    {
        $currentStatus = $company->modules->find($module->id)->pivot->is_active ?? false;
        
        $company->modules()->updateExistingPivot($module->id, [
            'is_active' => !$currentStatus
        ]);

        return redirect()->back()->with('success', 'Module status updated successfully.');
    }
}
