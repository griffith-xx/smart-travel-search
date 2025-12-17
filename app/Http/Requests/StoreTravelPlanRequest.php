<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTravelPlanRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_budget' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:5000',
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
            'name.required' => 'กรุณาระบุชื่อแผนการท่องเที่ยว',
            'name.max' => 'ชื่อแผนการท่องเที่ยวต้องไม่เกิน 255 ตัวอักษร',
            'start_date.required' => 'กรุณาระบุวันที่เริ่มต้น',
            'start_date.date' => 'วันที่เริ่มต้นไม่ถูกต้อง',
            'start_date.after_or_equal' => 'วันที่เริ่มต้นต้องเป็นวันนี้หรือในอนาคต',
            'end_date.required' => 'กรุณาระบุวันที่สิ้นสุด',
            'end_date.date' => 'วันที่สิ้นสุดไม่ถูกต้อง',
            'end_date.after_or_equal' => 'วันที่สิ้นสุดต้องเป็นวันเดียวกันหรือหลังจากวันที่เริ่มต้น',
            'total_budget.numeric' => 'งบประมาณต้องเป็นตัวเลข',
            'total_budget.min' => 'งบประมาณต้องมากกว่าหรือเท่ากับ 0',
            'notes.max' => 'หมายเหตุต้องไม่เกิน 5000 ตัวอักษร',
        ];
    }
}
