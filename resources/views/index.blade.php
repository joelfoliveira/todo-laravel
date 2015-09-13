<html>
<head>
    <title>To-do List Application</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="assets/js/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    @yield('head')

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
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="assets/js/todo.js" type="text/javascript"></script>
    <script src="assets/js/app.js" type="text/javascript"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @yield('scripts')

</body>
</html>