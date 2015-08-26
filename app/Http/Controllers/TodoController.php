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
     * @return mixed
     */
    public function getIndex()
    {
        $todos = Todo::all();
        return View::make("index")->with("todos", $todos);
    }

    /**
     * Create To-Do
     * @return \Illuminate\Http\JsonResponse
     */
    public function postTodo()
    {
        $success = false;
        $message = '';
        $errors = array();
        $httpCode = 200;

        $validator = Validator::make(Input::all(), array('title' => 'required'));

        if(!$validator->fails())
        {
            $todo = new Todo();
            $todo->title = Input::get("title");
            if($todo->save())
            {
                $success = true;
                $message = "Record inserted";
            }
        }
        else
        {
            $errors = $validator->messages();
            $message = $validator->messages()->first();
            $httpCode = 422;
        }

        return response()->json(['success' => $success, 'message' => $message, 'errors' => $errors], $httpCode);
    }

    /**
     * Update To-Do
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function putTodo($id)
    {
        $success = false;
        $message = '';
        $errors = array();
        $httpCode = 200;

        $validator = Validator::make(array('id' => $id, 'title' => Input::get('title')), array('id' => 'exists:todos,id', 'title' => 'required'));

        if(!$validator->fails())
        {
            $todo = Todo::whereId($id)->first();
            if($todo)
            {
                if(Input::has('title'))
                {
                    $todo->title = Input::get('title');
                }

                if(Input::has('status'))
                {
                    $todo->status = Input::get('status');
                }

                if($todo->save())
                {
                    $success = true;
                    $message = "Record updated";
                }
            }
            else
            {
                $message = "Error occurred";
                $httpCode = 500;
            }
        }
        else
        {
            $errors = $validator->messages();
            $message = "Some fields are invalid";
            $httpCode = 422;
        }

        return response()->json(['success' => $success, 'message' => $message, 'errors' => $errors], $httpCode);
    }

    /**
     * Delete To-Do
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteTodo($id)
    {
        $success = false;
        $message = '';
        $errors = array();
        $httpCode = 200;

        $validator = Validator::make(array('id' => $id), array('id' => 'exists:todos,id'));

        if(!$validator->fails())
        {
            $todo = Todo::whereId($id)->first();
            if($todo && $todo->delete())
            {
                $success = true;
                $message = "Record deleted";
            }
            else
            {
                $message = "Error occurred";
                $httpCode = 500;
            }
        }
        else
        {
            $errors = $validator->messages();
            $message = $validator->messages()->first();
            $httpCode = 422;
        }

        return response()->json(['success' => $success, 'message' => $message, 'errors' => $errors], $httpCode);
    }
}
