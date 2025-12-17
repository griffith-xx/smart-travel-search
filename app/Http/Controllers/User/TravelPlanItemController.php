<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTravelPlanItemRequest;
use App\Http\Requests\UpdateTravelPlanItemRequest;
use App\Models\Destination;
use App\Models\TravelPlan;
use App\Models\TravelPlanItem;
use Illuminate\Http\JsonResponse;

class TravelPlanItemController extends Controller
{
    public function store(StoreTravelPlanItemRequest $request): JsonResponse
    {
        $travelPlan = auth()->user()->activeTravelPlan()->first();

        if (! $travelPlan) {
            return response()->json([
                'success' => false,
                'message' => 'กรุณาสร้างแผนการท่องเที่ยวก่อน',
            ], 422);
        }

        $destination = Destination::findOrFail($request->destination_id);

        $existingItem = $travelPlan->items()
            ->where('destination_id', $destination->id)
            ->first();

        if ($existingItem) {
            return response()->json([
                'success' => false,
                'message' => 'สถานที่นี้มีอยู่ในแผนการท่องเที่ยวแล้ว',
            ], 422);
        }

        $maxOrder = $travelPlan->items()
            ->where('day_number', $request->day_number)
            ->max('order') ?? -1;

        $item = $travelPlan->items()->create([
            'destination_id' => $destination->id,
            'day_number' => $request->day_number,
            'order' => $request->order ?? ($maxOrder + 1),
            'notes' => $request->notes,
            'estimated_cost' => $request->estimated_cost ?? $destination->price_from,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'เพิ่มสถานที่ลงในแผนการท่องเที่ยวเรียบร้อยแล้ว',
            'item' => [
                'id' => $item->id,
                'destination_id' => $item->destination_id,
                'day_number' => $item->day_number,
                'order' => $item->order,
                'notes' => $item->notes,
                'estimated_cost' => $item->estimated_cost,
            ],
        ]);
    }

    public function update(UpdateTravelPlanItemRequest $request, TravelPlanItem $travelPlanItem): JsonResponse
    {
        if ($travelPlanItem->travelPlan->user_id !== auth()->id()) {
            abort(403);
        }

        $travelPlanItem->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'อัปเดตรายการเรียบร้อยแล้ว',
            'item' => [
                'id' => $travelPlanItem->id,
                'destination_id' => $travelPlanItem->destination_id,
                'day_number' => $travelPlanItem->day_number,
                'order' => $travelPlanItem->order,
                'notes' => $travelPlanItem->notes,
                'estimated_cost' => $travelPlanItem->estimated_cost,
            ],
        ]);
    }

    public function destroy(TravelPlanItem $travelPlanItem): JsonResponse
    {
        if ($travelPlanItem->travelPlan->user_id !== auth()->id()) {
            abort(403);
        }

        $travelPlanItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'ลบสถานที่ออกจากแผนการท่องเที่ยวเรียบร้อยแล้ว',
        ]);
    }

    public function reorder(TravelPlan $travelPlan): JsonResponse
    {
        if ($travelPlan->user_id !== auth()->id()) {
            abort(403);
        }

        $items = request()->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:travel_plan_items,id',
            'items.*.day_number' => 'required|integer|min:1',
            'items.*.order' => 'required|integer|min:0',
        ])['items'];

        foreach ($items as $itemData) {
            $item = TravelPlanItem::find($itemData['id']);
            if ($item && $item->travel_plan_id === $travelPlan->id) {
                $item->update([
                    'day_number' => $itemData['day_number'],
                    'order' => $itemData['order'],
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'จัดเรียงรายการเรียบร้อยแล้ว',
        ]);
    }
}
