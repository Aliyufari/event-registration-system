<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'events' => Event::paginate(10)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        try {
            Event::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Event created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'errors' => 'Error creating event ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        try {
            return response()->json([
                'status' => true,
                'event' => $event,
                'message' => 'Event added successfully'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'errors' => 'Error retreiving event ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->authorize('update', $event);
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        try {
            $event->update($data);

            return response()->json([
                'status' => true,
                'event' => $event,
                'message' => 'Event updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'errors' => 'Error updating event ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        
        try {
            $event->delete();

            return response()->json([
                'status' => true,
                'message' => 'Evant deleted successful'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'errors' => 'Error deleting event ' . $e->getMessage()
            ]);
        }
    }
}
