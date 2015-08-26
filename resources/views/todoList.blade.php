<ul>
    @foreach($todos as $todo)
        <li id="todo-item-{{$todo->id}}" class="todo-item" data-id="{{$todo->id}}">
            <input type="checkbox"/>
            <input class="title" type="text" value="{{$todo->title}}" readonly/>
            <button class="bt edit">Edit</button>
            <button class="bt save" style="display: none;">Save</button>
            <button class="bt delete">Delete</button>
        </li>
    @endforeach
</ul>