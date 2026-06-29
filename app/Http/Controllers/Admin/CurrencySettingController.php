<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CurrencySetting;
use Illuminate\Http\Request;

class CurrencySettingController extends Controller
{
    public function index()
    {
        $currencies = CurrencySetting::latest()->get();
        return view('admin.currency-settings.index', compact('currencies'));
    }

    public function create()
    {
        return view('admin.currency-settings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'currency_name' => 'required|string|max:255',
            'currency_code' => 'required|string|max:10',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0.0001',
            'is_default' => 'boolean',
            'status' => 'boolean',
        ]);

        CurrencySetting::create($validated);

        return redirect()->route('admin.currency-settings.index')
            ->with('success', 'Currency created successfully.');
    }

    public function edit(CurrencySetting $currencySetting)
    {
        return view('admin.currency-settings.edit', compact('currencySetting'));
    }

    public function update(Request $request, CurrencySetting $currencySetting)
    {
        $validated = $request->validate([
            'currency_name' => 'required|string|max:255',
            'currency_code' => 'required|string|max:10',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0.0001',
            'is_default' => 'boolean',
            'status' => 'boolean',
        ]);

        $currencySetting->update($validated);

        cache()->forget('active_currency');

        return redirect()->route('admin.currency-settings.index')
            ->with('success', 'Currency updated successfully.');
    }

    public function destroy(CurrencySetting $currencySetting)
    {
        if ($currencySetting->is_default) {
            return redirect()->route('admin.currency-settings.index')
                ->with('error', 'Cannot delete the default currency.');
        }

        $currencySetting->delete();

        cache()->forget('active_currency');

        return redirect()->route('admin.currency-settings.index')
            ->with('success', 'Currency deleted successfully.');
    }

    public function toggle(CurrencySetting $currencySetting)
    {
        $currencySetting->status = !$currencySetting->status;
        $currencySetting->save();

        cache()->forget('active_currency');

        $message = $currencySetting->status ? 'Currency activated.' : 'Currency deactivated.';

        return redirect()->route('admin.currency-settings.index')
            ->with('success', $message);
    }
}
