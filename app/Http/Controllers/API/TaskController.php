<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Task;
use Validator;
use DataTables;
use App\Http\Resources\Task as TaskResource;

class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tasks = Task::get()->where('date', '>=', NOW());

        return $this->sendResponse(TaskResource::collection($tasks), 'Tasks retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'date' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $task = Task::create($input);

        return $this->sendResponse(new TaskResource($task), 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'date' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $task->name = $input['name'];
        $task->date = $input['date'];
        $task->status = $input['status'];
        $task->save();

        return $this->sendResponse(new TaskResource($task), 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        if(date_diff(new \DateTime($task->date), new \DateTime())->format("%d") > 6) {
            $task->delete();
        } else {
            return $this->sendError('Date diff invalid : ' .date_diff(new \DateTime($task->date), new \DateTime())->format("%d") . 'Days and need more than 6 days', $task->date);
        }

        return $this->sendResponse([], 'Task deleted successfully.');
    }

}
