<ul class="sortable">
    @foreach($todos as $todo)
        <li id="todo-item-{{$todo->id}}" class="todo-item" data-id="{{$todo->id}}">
            <button class="helper-sortable">[]</button>
            <input class="switch status" type="checkbox"/>
            <input class="title" type="text" value="{{$todo->title}}" readonly/>
            <button class="bt edit">Edit</button>
            <button class="bt save" style="display: none;">Save</button>
            <button class="bt delete">Delete</button>
        </li>
    @endforeach
</ul>