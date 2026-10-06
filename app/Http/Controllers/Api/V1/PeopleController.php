<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonResource;
use App\Models\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PeopleController extends Controller
{
    public function index(Request $request)
    {
        $perPage = min(max($request->integer('per_page', 12), 1), 50);

        $people = Person::query()
            ->with('photo')
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return PersonResource::collection($people);
    }

    public function show(string $id): PersonResource|JsonResponse
    {
        $query = Person::query()
            ->with('photo')
            ->where('status', 'active');

        /*
         * The current People schema uses UUID id and has no slug columns.
         * If slug_en/slug_bn are added later, this endpoint automatically
         * supports slug lookup without changing the route.
         */
        if (Schema::hasColumn('people', 'slug_en') || Schema::hasColumn('people', 'slug_bn')) {
            $query->where(function ($q) use ($id) {
                $q->whereKey($id);

                if (Schema::hasColumn('people', 'slug_en')) {
                    $q->orWhere('slug_en', $id);
                }

                if (Schema::hasColumn('people', 'slug_bn')) {
                    $q->orWhere('slug_bn', $id);
                }
            });
        } else {
            $query->whereKey($id);
        }

        $person = $query->first();

        if (!$person) {
            return response()->json([
                'message' => 'Person not found.',
            ], 404);
        }

        return new PersonResource($person);
    }
}
