<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTravelPlanRequest;
use App\Http\Requests\UpdateTravelPlanRequest;
use App\Models\TravelPlan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TravelPlanController extends Controller
{
    public function index(): Response
    {
        $travelPlan = auth()->user()->activeTravelPlan()
            ->with(['items.destination.province', 'items.destination.category'])
            ->first();

        return Inertia::render('User/TravelPlan/Index', [
            'travelPlan' => $travelPlan ? [
                'id' => $travelPlan->id,
                'name' => $travelPlan->name,
                'start_date' => $travelPlan->start_date->format('Y-m-d'),
                'end_date' => $travelPlan->end_date->format('Y-m-d'),
                'total_budget' => $travelPlan->total_budget,
                'notes' => $travelPlan->notes,
                'status' => $travelPlan->status,
                'total_days' => $travelPlan->total_days,
                'total_estimated_cost' => $travelPlan->total_estimated_cost,
                'items' => $travelPlan->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'destination_id' => $item->destination_id,
                        'day_number' => $item->day_number,
                        'order' => $item->order,
                        'notes' => $item->notes,
                        'estimated_cost' => $item->estimated_cost,
                        'destination' => [
                            'id' => $item->destination->id,
                            'name' => $item->destination->name,
                            'slug' => $item->destination->slug,
                            'cover_image' => $item->destination->cover_image,
                            'province' => $item->destination->province?->name,
                            'category' => $item->destination->category?->name,
                            'rating_average' => $item->destination->rating_average,
                            'price_from' => $item->destination->price_from,
                            'price_to' => $item->destination->price_to,
                            'latitude' => $item->destination->latitude,
                            'longitude' => $item->destination->longitude,
                        ],
                    ];
                }),
            ] : null,
        ]);
    }

    public function store(StoreTravelPlanRequest $request): RedirectResponse
    {
        $existingPlan = auth()->user()->activeTravelPlan()->first();
        if ($existingPlan) {
            $existingPlan->update(['status' => 'completed']);
        }

        $travelPlan = auth()->user()->travelPlans()->create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_budget' => $request->total_budget,
            'notes' => $request->notes,
            'status' => 'active',
        ]);

        return redirect()->route('travel-plan.index')
            ->with('success', 'สร้างแผนการท่องเที่ยวเรียบร้อยแล้ว');
    }

    public function update(UpdateTravelPlanRequest $request, TravelPlan $travelPlan): RedirectResponse
    {
        if ($travelPlan->user_id !== auth()->id()) {
            abort(403);
        }

        $travelPlan->update($request->validated());

        return redirect()->route('travel-plan.index')
            ->with('success', 'อัปเดตแผนการท่องเที่ยวเรียบร้อยแล้ว');
    }

    public function destroy(TravelPlan $travelPlan): RedirectResponse
    {
        if ($travelPlan->user_id !== auth()->id()) {
            abort(403);
        }

        $travelPlan->delete();

        return redirect()->route('travel-plan.index')
            ->with('success', 'ลบแผนการท่องเที่ยวเรียบร้อยแล้ว');
    }

    public function getActivePlan(): JsonResponse
    {
        $travelPlan = auth()->user()->activeTravelPlan()->first();

        return response()->json([
            'has_plan' => $travelPlan !== null,
            'plan' => $travelPlan ? [
                'id' => $travelPlan->id,
                'name' => $travelPlan->name,
                'items_count' => $travelPlan->items()->count(),
            ] : null,
        ]);
    }
}
