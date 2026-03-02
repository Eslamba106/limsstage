<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSampleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('edit_sample');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $sampleId = $this->route('id');

        return [
            // Basic Information
            'main_plant_item' => ['required', 'exists:plants,id'],
            'sub_plant_item' => ['nullable', 'exists:plants,id'],
            'sample_name' => [
                'required',
                'exists:plant_samples,id',
                Rule::unique('samples', 'plant_sample_id')->ignore($sampleId)
            ],
            'toxic' => ['nullable', 'exists:toxic_degrees,id'],
            'coa' => ['nullable', 'boolean'],
            
            // Existing Test Methods
            'test_method' => ['nullable', 'array'],
            'test_method.*' => ['required', 'exists:test_methods,id'],
            
            // Existing Test Method Items
            'test_method_item_id' => ['nullable', 'array'],
            'test_method_item_id.*' => ['nullable', 'exists:test_method_items,id'],
            'component_old' => ['nullable', 'array'],
            'component_old.*' => ['nullable', 'boolean'],
            
            // Existing Warning Limits
            'warning_limit_old' => ['nullable', 'array'],
            'warning_limit_old.*' => ['nullable', 'numeric'],
            'warning_limit_end_old' => ['nullable', 'array'],
            'warning_limit_end_old.*' => ['nullable', 'numeric'],
            'warning_limit_type_old' => ['nullable', 'array'],
            'warning_limit_type_old.*' => ['nullable', 'in:=,>=,<=,<,>,8646'],
            
            // Existing Action Limits
            'action_limit_old' => ['nullable', 'array'],
            'action_limit_old.*' => ['nullable', 'numeric'],
            'action_limit_end_old' => ['nullable', 'array'],
            'action_limit_end_old.*' => ['nullable', 'numeric'],
            'action_limit_type_old' => ['nullable', 'array'],
            'action_limit_type_old.*' => ['nullable', 'in:=,>=,<=,<,>,8646'],
            
            // New Test Methods (dynamic validation)
            // Note: We validate test_method_item_id_new values in mergeTestMethodItemIds()
            // to avoid issues with complex array keys like "1-123-1"
            'test_method_item_id_new' => ['nullable', 'array'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'main_plant_item.required' => __('validation.required', ['attribute' => __('samples.plant_name')]),
            'main_plant_item.exists' => __('validation.exists', ['attribute' => __('samples.plant_name')]),
            'sample_name.required' => __('validation.required', ['attribute' => __('samples.sample_name')]),
            'sample_name.exists' => __('validation.exists', ['attribute' => __('samples.sample_name')]),
            'sample_name.unique' => __('validation.unique', ['attribute' => __('samples.sample_name')]),
            'test_method_item_id.*.exists' => __('validation.exists', ['attribute' => __('test_method.component')]),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkbox 'on' to boolean
        if ($this->has('coa')) {
            $this->merge([
                'coa' => $this->coa === 'on' || $this->coa === true || $this->coa === '1',
            ]);
        }
        
        // Convert component_old checkboxes from 'on' to boolean
        $this->normalizeComponentOldCheckboxes();
        
        // Convert test_method_item_id_new to test_method_item_id for validation
        $this->mergeTestMethodItemIds();
    }

    /**
     * Normalize component_old checkboxes from 'on' to boolean.
     */
    protected function normalizeComponentOldCheckboxes(): void
    {
        if (!$this->has('component_old')) {
            return;
        }

        $componentOld = $this->input('component_old', []);
        $normalized = [];

        foreach ($componentOld as $key => $value) {
            // Convert 'on' or any truthy value to true, otherwise false
            $normalized[$key] = $value === 'on' || $value === true || $value === '1' || $value === 1;
        }

        if (!empty($normalized)) {
            $this->merge([
                'component_old' => $normalized,
            ]);
        }
    }

    /**
     * Merge new test method item IDs into existing ones for validation.
     */
    protected function mergeTestMethodItemIds(): void
    {
        if (!$this->has('test_method_item_id_new')) {
            return;
        }

        $newItems = $this->input('test_method_item_id_new', []);
        $existingItems = $this->input('test_method_item_id', []);
        
        // Clean and merge new items into existing items for validation
        // Only include valid numeric IDs that exist in test_method_items table
        $cleanedNewItems = [];
        foreach ($newItems as $key => $value) {
            // Skip empty, null, or invalid values
            if ($value === null || $value === '' || !is_numeric($value)) {
                continue;
            }
            
            $intValue = (int) $value;
            
            // Verify that the test method item exists
            // We'll validate this in the rules() method through test_method_item_id
            $cleanedNewItems[$key] = $intValue;
        }
        
        // Remove empty values from test_method_item_id_new to avoid validation errors
        if (!empty($cleanedNewItems)) {
            $this->merge([
                'test_method_item_id_new' => $cleanedNewItems,
            ]);
        } else {
            // Remove test_method_item_id_new if all values are empty
            $this->merge([
                'test_method_item_id_new' => [],
            ]);
        }
        
        // Merge cleaned items into existing items for validation
        // This allows us to validate all test_method_item_ids (both old and new) together
        foreach ($cleanedNewItems as $key => $value) {
            // Generate a unique key to avoid conflicts with existing items
            $uniqueKey = 'new_' . md5($key);
            $existingItems[$uniqueKey] = $value;
        }
        
        if (!empty($existingItems)) {
            $this->merge([
                'test_method_item_id' => $existingItems,
            ]);
        }
    }
}
