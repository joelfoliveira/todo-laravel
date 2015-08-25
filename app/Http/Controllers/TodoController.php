<?php

namespace todolist\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use todolist\Http\Requests\Request;
use todolist\Todo;

class TodoController extends BaseController
{
    public $restful = true;

    /**
     *
     * @return mixed
     */
    public function getIndex()
    {
        $todos = Todo::all();
        return View::make("index")->with("todos", $todos);
    }

    /**
     * Create To-Do
     * @return mixed
     */
    public function postTodo()
    {
        $success = false;
        $message = '';
        $details = array();

        $validator = Validator::make(Input::all(), array('title' => 'required'));

        if(!$validator->fails())
        {
            $todo = new Todo();
            $todo->title = Input::get("title");
            if($todo->save())
            {
                $success = true;
            }
        }
        else
        {

        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'details' => $details
        ]);
    }

    /**
     * Update To-Do
     * @param $id
     * @return string
     */
    public function putTodo($id)
    {
        if(Request::ajax())
        {
            $task = Todo::find($id);
            $task->status = 1;
            $task->save();
            return "OK";
        }
    }

    /**
     * Delete To-Do
     * @param $id
     * @return string
     */
    public function deleteTodo($id)
    {
        $todo = Todo::whereId($id)->first();
        $todo->delete();
        return "OK";

        return response()->json(['success' => true, 'message' => '', 'details' => array()]);
    }
}
