<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Exception;
use App\Http\Requests\StoreTask;


class TaskController extends Controller
{
    public function test(Request $request)
    {
        try {
            $name = $request->name;
            $email = $request->email;

            return response()->json([
                'name' => $name,
                'email' => $email,
                'message' => 'Test endpoint is working!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Task creation failed',
                'error' =>  $e->getMessage()
            ]);
        }
    }

    public function getAllTask()
    {
        try {
            $tasks = Task::all();
            return response()->json([
                'message' => 'Tasks retrieved successfully',
                'data' => $tasks,
            ], 201);
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

            $task = Task::create([
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

    public function edit($id)
    {
        try {
            $tasks = Task::findOrFail($id);
            return response()->json([
                'message' => 'Task edit successfully',
                'data' => $tasks
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Task edited failed',
                'error' =>  $e->getMessage()
            ], 404);
        }
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id)->delete();
        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }
}
