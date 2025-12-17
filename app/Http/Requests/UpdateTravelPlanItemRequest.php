<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTravelPlanItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'day_number' => 'sometimes|required|integer|min:1',
            'order' => 'sometimes|integer|min:0',
            'notes' => 'nullable|string|max:1000',
            'estimated_cost' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'day_number.required' => 'กรุณาระบุวันที่',
            'day_number.integer' => 'วันที่ต้องเป็นตัวเลข',
            'day_number.min' => 'วันที่ต้องมากกว่าหรือเท่ากับ 1',
            'order.integer' => 'ลำดับต้องเป็นตัวเลข',
            'order.min' => 'ลำดับต้องมากกว่าหรือเท่ากับ 0',
            'notes.max' => 'หมายเหตุต้องไม่เกิน 1000 ตัวอักษร',
            'estimated_cost.numeric' => 'ค่าใช้จ่ายประมาณการต้องเป็นตัวเลข',
            'estimated_cost.min' => 'ค่าใช้จ่ายประมาณการต้องมากกว่าหรือเท่ากับ 0',
        ];
    }
}
