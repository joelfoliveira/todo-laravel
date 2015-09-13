<?php

namespace todolist\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use todolist\Todo;

class TodoController extends BaseController
{
    public $restful = true;

    /**
     * @return mixed
     */
    public function showIndex()
    {
        $todos = Todo::where('done', 0)->orderBy('order', 'asc')->get();
        $todoListView = View::make("todoList")->with("todos", $todos);
        return View::make("index")->with("todoListView", $todoListView);
    }

    /**
     * @return mixed
     */
    public function getTodoList(Request $request)
    {
        $todos = Todo::where('done', 0)->orderBy('order', 'asc')->get();

        if($request->getRequestFormat('html') == 'html')
        {
            return View::make("todoList")->with("todos", $todos);
        }
        else
        {
            return response()->json(['success' => true, 'message' => '', 'errors' => array(), 'data' => $todos], 200);
        }
    }

    /**
     * Create To-Do
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTodo()
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
    public function updateTodo($id)
    {
        $success = false;
        $message = '';
        $errors = array();
        $httpCode = 200;

        $validator = Validator::make(array(
            'id' => $id,
            'title' => Input::get('title')
        ), array(
            'id' => 'exists:todos,id',
            'title' => 'string',
            'done' => 'boolean',
        ));

        if(!$validator->fails())
        {
            $todo = Todo::whereId($id)->first();
            if($todo)
            {
                if(Input::has('title'))
                {
                    $todo->title = Input::get('title');
                }

                if(Input::has('done'))
                {
                    $todo->done = Input::get('done') ? 1 : 0;
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
     * Update To-Do's order in bulk
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderTodoList()
    {
        $success = false;
        $message = '';
        $errors = array();
        $httpCode = 200;

        $validator = Validator::make(Input::all(), array('todos' => 'required|array'));

        if(!$validator->fails())
        {
            $todos = Input::get('todos');
            foreach($todos as $todo)
            {
                DB::table('todos')->where('id', $todo['id'])->update(array('order' => $todo['order']));
            }

            $success = true;
            $message = "Records updated";
        }
        else
        {
            $errors = $validator->messages();
            $message = "Invalid data";
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
