<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Exception;
use App\Http\Requests\StoreTask;
use App\Http\Resources\Task\TaskCollection;
use App\Http\Resources\Task\TaskResource;

class Task2Controller extends Controller
{

    public function index()
    {
        try {
            $tasks = Task::all();
            return response()->json([
                'message' => 'Tasks retrieved successfully',
                'data' => new TaskCollection($tasks)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Task get failed',
                'error' =>  $e->getMessage()
            ]);
        }
    }

    public function store(StoreTask $request)
    {
        $validateData = $request->validated;
        try {
            // $title = $request->title;
            // $description = $request->description;

            $image = $request->hasFile('image');
            $imagePath = null;
            if ($image) {
                $imagePath = $request->file('image')->store('task_images', 'public');
            }

            $tasks = Task::create([
                'title' => $validateData['title'],
                'description' => $validateData['description'],
                'image' => $imagePath
            ]);

            return response()->json([
                'message' => 'Task created successfully'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Task creation failed',
                'error' =>  $e->getMessage()
            ], 404);
        }
    }

    public function show($id)
    {
        try {
            $tasks = Task::findOrFail($id);
            return response()->json([
                'message' => 'Task retrieved successfully',
                'data' => new TaskResource($tasks)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Task retrieval failed',
                'error' =>  $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            $task->title = $request->input('title', $task->title);
            $task->description = $request->input('description', $task->description);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('task_images', 'public');
                $task->image = $imagePath;
            }

            $task->save();

            return response()->json([
                'message' => 'Task updated successfully',
                'data' => $task
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Task update failed',
                'error' =>  $e->getMessage()
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();

            return response()->json([
                'message' => 'Task deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Task deletion failed',
                'error' =>  $e->getMessage()
            ], 404);
        }
    }
}
