<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\TaskAddRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;


class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $tasks = $user->tasks()->orderByDesc('created_at')->get();
        return $this->success( TaskResource::collection($tasks) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskAddRequest $request)
    {
        $task = new Task();
        $task->title = $request->get('title');
        $task->description = $request->get('description');
        if ($request->has('completed')) {
            $task->completed_at = $request->get('completed') == true ? Carbon::now() : null;
        }
        $task->user_id = auth()->user()->id;

        $task->save();

        return $this->success([
            'data' => new TaskResource($task),
            'message' => 'successfully created',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();
        $task = $user->tasks()->findOrFail($id);

        return $this->success([
            'data' => new TaskResource($task),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskAddRequest $request, $id)
    {
        $user = $request->user();
        $task = $user->tasks()->findOrFail($id);
        $task->title = $request->get('title');
        $task->description = $request->get('description');
        if ($request->has('completed')) {
            $task->completed_at = $request->get('completed') == true ? Carbon::now() : null;
        }
        $task->save();

        return $this->success([
            'data' => new TaskResource($task),
            'message' => 'successfully updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $task = $user->tasks()->findOrFail($id);
        $task->delete();

        return $this->success([
            'message' => 'product deleted successfully',
        ]);
    }

}
