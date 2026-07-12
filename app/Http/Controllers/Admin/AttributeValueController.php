<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAttributeValueRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function index(Attribute $attribute)
    {
        $attribute->load('values');

        return view('admin.attribute-values.index', compact('attribute'));
    }

    public function store(StoreAttributeValueRequest $request, Attribute $attribute)
    {
        $attribute->values()->create($request->validated());

        return redirect()->route('admin.attributes.values', $attribute)
            ->with('success', 'Value added successfully.');
    }

    public function update(StoreAttributeValueRequest $request, Attribute $attribute, AttributeValue $attributeValue)
    {
        $attributeValue->update($request->validated());

        return redirect()->route('admin.attributes.values', $attribute)
            ->with('success', 'Value updated successfully.');
    }

    public function destroy(Attribute $attribute, AttributeValue $attributeValue)
    {
        $attributeValue->delete();

        return redirect()->route('admin.attributes.values', $attribute)
            ->with('success', 'Value deleted successfully.');
    }

    public function updateSortOrder(Request $request, Attribute $attribute)
    {
        $request->validate([
            'values' => 'required|array',
            'values.*.id' => 'required|exists:attribute_values,id',
            'values.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->input('values') as $item) {
            AttributeValue::where('id', $item['id'])
                ->where('attribute_id', $attribute->id)
                ->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['message' => 'Sort order updated.']);
    }
}
