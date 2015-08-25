<html>
<head>
    <title>To-do List Application</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="assets/css/style.css">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
<div class="container">
    <section id="todo-controls">
        <ul>
            <li>
                <button class="bt add">add</button>
            </li>
        </ul>
        <ul>
            @foreach($todos as $todo)
                <li id="todo-item-{{$todo->id}}" class="todo-item" data-id="{{$todo->id}}">
                    <a href="#"></a>
                    <span class="title">{{$todo->title}}</span>
                    <button class="bt delete">Delete</button>
                    <a href="#" class="icon-edit">Edit</a>
                </li>
            @endforeach
        </ul>
    </section>
    <section id="todo-form" style="display:none">
        <form onsubmit="return false;">
            <input class="title" type="text" name="title" placeholder="Enter a task name" value=""/>
            <button class="bt submit" onclick="Todo.submitFormClick(); return false;">Submit</button>
        </form>
    </section>
</div>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script src="assets/js/todo.js" type="text/javascript"></script>
<script src="assets/js/app.js" type="text/javascript"></script>
</body>
</html>