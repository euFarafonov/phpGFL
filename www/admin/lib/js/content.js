function Content(options) {
    var content = document.getElementById(options.contentId);
    
    content.addEventListener('click', function(event) {
        var target = event.target;
        
        if (target.classList.contains('js_content')) {
            var leftbarActive = document.querySelector('.leftbar .active');
            if (leftbarActive) leftbarActive.classList.remove('active');
            
            var todoArr = target.dataset.todo.split('_');
            var action = todoArr[0]; // add/edit/del
            var item = todoArr[1]; // book/author/genre
            
            switch(action) {
                case 'add':
                    renderAdd(item);
                break;
                
                case 'edit':
                    var id = target.dataset.id;
                    
                    getData({
                        item: item,
                        target: null,
                        action: 'editData',
                        queryOpt: {
                            whereName: 'id',
                            whereValue: id
                        }
                    });
                    
                break;
                
                case 'del':
                    if (!confirm("Подтвердите удаление")) return false;
                    
                    var id = target.dataset.id;
                    
                break;
            }
        }
    });
}

/* ФОРМИРОВАНИЕ СТРАНИЦЫ ДОБАВЛЕНИЯ КНИГИ, АВТОРА ИЛИ ЖАНРА */
function renderAdd(item) {
    var content = document.querySelector('.content');
    var fragment = document.createDocumentFragment();
    
    var header = document.createElement('h1');
    var form = document.createElement('form');
    var table = document.createElement('table');
    var button = document.createElement('button');
    
    switch(item) {
        case 'book':
            headerText = 'Новая книга';
            form.enctype = 'multipart/form-data';
        break;
        
        case 'author':
            headerText = 'Новый автор';
        break;
        
        case 'genre':
            headerText = 'Новый жанр';
        break;
    }
    
    header.textContent = headerText;
    form.classList.add('page_form');
    form.action = '';
    form.method = 'post';
        table.classList.add('pages_table');
            var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.classList.add('right');
                td.textContent = 'Наименование';
            tr.appendChild(td);
                var td = document.createElement('td');
                td.innerHTML = '<input class="left" type="text" name="name">';
            tr.appendChild(td);
        table.appendChild(tr);
        
        /* Если добавляется книга */
        if (item === 'book') {
            /* Цена */
            var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.classList.add('right');
                td.textContent = 'Цена, ' + currency;
            tr.appendChild(td);
                var td = document.createElement('td');
                td.innerHTML = '<input class="left" type="text" name="price">';
            tr.appendChild(td);
            table.appendChild(tr);
            
            /* Описание */
            var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.classList.add('right');
                td.textContent = 'Описание';
            tr.appendChild(td);
                var td = document.createElement('td');
                td.innerHTML = '<textarea name="about"></textarea>';
            tr.appendChild(td);
            table.appendChild(tr);
            
            /* Авторы */
            var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.classList.add('right');
                td.textContent = 'Авторы';
            tr.appendChild(td);
                var td = document.createElement('td');
                td.id = 'cell_authors';
                    var select = document.createElement('select');
                    select.classList.add('js_field');
                    select.classList.add('left');
                    select.name = 'authors[]';
                    td.appendChild(select);
                        getData({
                            item: 'author',
                            target: select,
                            action: 'addData',
                            queryOpt: null
                        });
                    
                    var btnAdd = document.createElement('button');
                    btnAdd.id = 'add_select';
                    btnAdd.type = 'button';
                    btnAdd.textContent = 'Добавить поле';
                    td.appendChild(btnAdd);
                    
                    var btnDel = document.createElement('button');
                    btnDel.id = 'del_select';
                    btnDel.type = 'button';
                    btnDel.textContent = 'Удалить поле';
                    btnDel.classList.add('del_fields');
                    td.appendChild(btnDel);
            tr.appendChild(td);
            table.appendChild(tr);
            
            /* Жанры */
            var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.classList.add('right');
                td.textContent = 'Жанры';
            tr.appendChild(td);
                var td = document.createElement('td');
                td.id = 'cell_genres';
                    var select = document.createElement('select');
                    select.classList.add('js_field');
                    select.classList.add('left');
                    select.name = 'genres[]';
                    td.appendChild(select);
                        getData({
                            item: 'genre',
                            target: select,
                            action: 'addData',
                            queryOpt: null
                        });
                    
                    var btnAdd = document.createElement('button');
                    btnAdd.id = 'add_select';
                    btnAdd.type = 'button';
                    btnAdd.textContent = 'Добавить поле';
                    td.appendChild(btnAdd);
                    
                    var btnDel = document.createElement('button');
                    btnDel.id = 'del_select';
                    btnDel.type = 'button';
                    btnDel.textContent = 'Удалить поле';
                    btnDel.classList.add('del_fields');
                    td.appendChild(btnDel);
            tr.appendChild(td);
            table.appendChild(tr);
                
            /* Фото */
            var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.classList.add('right');
                td.textContent = 'Фото книги';
            tr.appendChild(td);
                var td = document.createElement('td');
                td.id = 'btnimg';
                td.innerHTML = '<input class="left" type="file" name="img">';
            tr.appendChild(td);
            table.appendChild(tr);
        }
        /* ======== =========*/
    form.appendChild(table);
    
    button.type = 'button';
    button.textContent = 'Добавить';
    form.appendChild(button);
    
    
    fragment.appendChild(header);
    fragment.appendChild(form);
    
    content.innerHTML = '';
    content.appendChild(fragment);
}

/* ФОРМИРОВАНИЕ SELECT-ов ДЛЯ СТРАНИЦ ДОБАВЛЕНИЯ И РЕДАКТИРОВАНИЯ */
function renderSelect(arr, item, select) {
    for (var i = 0; i < arr.length; i++) {
        var option = document.createElement('option');
        option.textContent = arr[i]['name'];
        option.value = arr[i]['id'];
        select.appendChild(option);
    }
    
    var field = new Fields({
        parent: select.parentElement.id,
        maxFields: 3
    });
}

/* ФОРМИРОВАНИЕ СТРАНИЦЫ РЕДАКТИРОВАНИЯ КНИГИ, АВТОРА ИЛИ ЖАНРА */
function renderEdit(arr, item) {
    var content = document.querySelector('.content');
    var fragment = document.createDocumentFragment();
    
    var header = document.createElement('h1');
    var form = document.createElement('form');
    var table = document.createElement('table');
    var button = document.createElement('button');
    
    switch(item) {
        case 'book':
            headerText = 'Редактировать книгу';
            form.enctype = 'multipart/form-data';
        break;
        
        case 'author':
            headerText = 'Редактировать автора';
        break;
        
        case 'genre':
            headerText = 'Редактировать жанр';
        break;
    }
    
    header.textContent = headerText;
    form.classList.add('page_form');
    form.action = '';
    form.method = 'post';
        table.classList.add('pages_table');
            var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.classList.add('right');
                td.textContent = 'Наименование';
            tr.appendChild(td);
                var td = document.createElement('td');
                td.innerHTML = '<input class="left" type="text" name="name" value="' + arr['name'] + '">';
            tr.appendChild(td);
        table.appendChild(tr);
        
        /* Если редактируется книга */
        if (item === 'book') {
            /* Цена */
            var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.classList.add('right');
                td.textContent = 'Цена, ' + currency;
            tr.appendChild(td);
                var td = document.createElement('td');
                td.innerHTML = '<input class="left" type="text" name="price" value="' + arr['price'] + '">';
            tr.appendChild(td);
            table.appendChild(tr);
            
            /* Описание */
            var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.classList.add('right');
                td.textContent = 'Описание';
            tr.appendChild(td);
                var td = document.createElement('td');
                td.innerHTML = '<textarea name="about">' + arr['about'] + '</textarea>';
            tr.appendChild(td);
            table.appendChild(tr);
            
            /* Авторы */
            var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.classList.add('right');
                td.textContent = 'Авторы';
            tr.appendChild(td);
                var td = document.createElement('td');
                td.id = 'cell_authors';
                    var select = document.createElement('select');
                    select.classList.add('js_field');
                    select.classList.add('left');
                    select.name = 'authors[]';
                    td.appendChild(select);
                        getData({
                            item: 'author',
                            target: select,
                            action: 'addData',
                            queryOpt: null
                        });
                    
                    var btnAdd = document.createElement('button');
                    btnAdd.id = 'add_select';
                    btnAdd.type = 'button';
                    btnAdd.textContent = 'Добавить поле';
                    td.appendChild(btnAdd);
                    
                    var btnDel = document.createElement('button');
                    btnDel.id = 'del_select';
                    btnDel.type = 'button';
                    btnDel.textContent = 'Удалить поле';
                    btnDel.classList.add('del_fields');
                    td.appendChild(btnDel);
            tr.appendChild(td);
            table.appendChild(tr);
            
            /* Жанры */
            var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.classList.add('right');
                td.textContent = 'Жанры';
            tr.appendChild(td);
                var td = document.createElement('td');
                td.id = 'cell_genres';
                    var select = document.createElement('select');
                    select.classList.add('js_field');
                    select.classList.add('left');
                    select.name = 'genres[]';
                    td.appendChild(select);
                        getData({
                            item: 'genre',
                            target: select,
                            action: 'addData',
                            queryOpt: null
                        });
                    
                    var btnAdd = document.createElement('button');
                    btnAdd.id = 'add_select';
                    btnAdd.type = 'button';
                    btnAdd.textContent = 'Добавить поле';
                    td.appendChild(btnAdd);
                    
                    var btnDel = document.createElement('button');
                    btnDel.id = 'del_select';
                    btnDel.type = 'button';
                    btnDel.textContent = 'Удалить поле';
                    btnDel.classList.add('del_fields');
                    td.appendChild(btnDel);
            tr.appendChild(td);
            table.appendChild(tr);
                
            /* Фото */
            var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.classList.add('right');
                td.textContent = 'Фото книги';
            tr.appendChild(td);
                var td = document.createElement('td');
                td.id = 'btnimg';
                td.innerHTML = '<input class="left" type="file" name="img">';
            tr.appendChild(td);
            table.appendChild(tr);
        }
        /* ======== =========*/
    form.appendChild(table);
    
    button.type = 'button';
    button.textContent = 'Редактировать';
    button.dataset.id = arr['id'];
    button.dataset.item = item;
    form.appendChild(button);
    
    
    fragment.appendChild(header);
    fragment.appendChild(form);
    
    content.innerHTML = '';
    content.appendChild(fragment);
}