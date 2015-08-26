function Todo()
{

};

Todo.init = function(callback)
{
    Todo.setEvents();
}

Todo.list = function(callback)
{
    $.ajax({
        url: 'todo',
        type: 'GET',
        success: function(result)
        {

        }
    });
};

Todo.insert = function(data, callback)
{
    $.ajax({
        url: 'todo',
        data: data,
        type: 'POST',
        complete: function(result, status)
        {
            if(typeof callback === "function")
            {
                if(status == 'success')
                {
                    callback(result.responseJSON.success, result.responseJSON);
                }
                else
                {
                    callback(false, null);
                }
            }
        }
    });
};

Todo.update = function(id, data, callback)
{
    $.ajax({
        url: 'todo/' + id,
        data: data,
        type: 'PUT',
        complete: function(result, status)
        {
            if(typeof callback === "function")
            {
                if(status == 'success')
                {
                    callback(result.responseJSON.success, result.responseJSON);
                }
                else
                {
                    callback(false, null);
                }
            }
        }
    });
};

Todo.setStatus = function(id, status, callback)
{
    Todo.update(id, {status: status});
};

Todo.delete = function(id, callback)
{
    $.ajax({
        url: 'todo/' + id,
        type: 'DELETE',
        complete: function(result, status)
        {
            if(typeof callback === "function")
            {
                if(status == 'success')
                {
                    callback(result.responseJSON.success, result.responseJSON);
                }
                else
                {
                    callback(false, null);
                }
            }
        }
    });
};

Todo.setEvents = function()
{
    $('#todo-controls .add').off('click').on('click', function()
    {
        Todo.showForm();
    });

    $('#todo-form .submit').off('click').on('click', function()
    {
        var title = $('#todo-form .title').val();

        Todo.insert({
            title: title
        }, function(success, result)
        {

        });
    });

    $('.todo-item .edit').off('click').on('click', function()
    {
        var title = $(this).siblings(".title").val();
        $(this).siblings(".title").data('title', title);

        $(this).siblings(".title").attr("readonly", false);
        $(this).siblings(".save").show();
        $(this).hide();
    });

    $('.todo-item .save').off('click').on('click', function()
    {
        var elem = $(this);
        var todoId = elem.parent().data('id');
        var title = elem.siblings(".title").val();
        if(todoId > 0)
        {
            Todo.update(todoId, {title: title}, function(success, result)
            {
                elem.siblings(".title").attr("readonly", true);
                elem.hide();
                elem.siblings(".edit").show();

                if(success != true)
                {
                    var oldTitle = elem.siblings(".title").data('title');
                    elem.siblings(".title").val(oldTitle);
                }
            });
        }
    });

    $('.todo-item .delete').off('click').on('click', function()
    {
        var itemElem = $(this).parent();
        var todoId = itemElem.data('id');
        if(todoId > 0)
        {
            Todo.delete(todoId, function(success, result)
            {
                if(success == true)
                {
                    itemElem.remove();
                }
            });
        }
    });
};

Todo.showForm = function()
{
    $('#todo-form').show();
};

Todo.hideForm = function()
{
    $('#todo-form').hide();
};