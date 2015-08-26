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
    </section>
    <section id="todo-form" style="display:none">
        <form onsubmit="return false;">
            <input class="title" type="text" placeholder="Enter a task name" value=""/>
            <button class="bt submit">Submit</button>
        </form>
    </section>
    <section id="todo-list">
        {!!$todoListView!!}
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