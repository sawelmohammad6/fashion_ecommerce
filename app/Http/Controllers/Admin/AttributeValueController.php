<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAttributeValueRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Support\Str;

class AttributeValueController extends Controller
{
    public function store(StoreAttributeValueRequest $request, Attribute $attribute)
    {
        $data = $request->validated();
        $attribute->values()->create($data);

        return redirect()->route('admin.attributes.edit', $attribute)
            ->with('success', 'Value added successfully.');
    }

    public function update(StoreAttributeValueRequest $request, Attribute $attribute, AttributeValue $attributeValue)
    {
        $attributeValue->update($request->validated());

        return redirect()->route('admin.attributes.edit', $attribute)
            ->with('success', 'Value updated successfully.');
    }

    public function destroy(Attribute $attribute, AttributeValue $attributeValue)
    {
        $attributeValue->delete();

        return redirect()->route('admin.attributes.edit', $attribute)
            ->with('success', 'Value deleted successfully.');
    }
}
