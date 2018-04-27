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
                
                case 'del':
                    if (!confirm("Подтвердите удаление")) return false;
                    var id = target.dataset.id;
                    
                    delData({
                        item: item,
                        id: id
                    });
                break;
                
                case 'edit':
                    var id = target.dataset.id;
                    
                    var p = new Promise(function(resolve, reject){
                        getData({
                            item: item,
                            target: null,
                            action: 'editData',
                            queryOpt: {
                                whereName: 'id',
                                whereValue: id
                            }
                        });
                        resolve();
                    });
                    /*
                    p.then(function(){
                        getData({
                            item: 'book_author',
                            target: null,
                            action: 'get_author_id',
                            queryOpt: {
                                whatName: 'author_id',
                                whereName: 'book_id',
                                whereValue: id,
                                order: false
                            }
                        });
                    });
                    
                    p.then(function(){
                        getData({
                            item: 'book_genre',
                            target: null,
                            action: 'get_genre_id',
                            queryOpt: {
                                whatName: 'genre_id',
                                whereName: 'book_id',
                                whereValue: id,
                                order: false
                            }
                        });
                    });
                    
                    p.then(function(){
                        //loadimage();
                    });
                    */
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
    button.dataset.todo = 'add_' + item;
    button.addEventListener('click', function(event) {
        var target = event.target;
        addItem(target);
    });
    form.appendChild(button);
    
    
    fragment.appendChild(header);
    fragment.appendChild(form);
    
    content.innerHTML = '';
    content.appendChild(fragment);
}

/* ФУНКЦИЯ ДОБАВЛЕНИЯ НОВЫХ КНИГ, АВТОРОВ, ЖАНРОВ */
function addItem(target) {
    var todoArr = target.dataset.todo.split('_');
    var action = todoArr[0]; // add/edit/del
    var item = todoArr[1]; // book/author/genre
    
    if (action === 'add') {
        var name = document.querySelector('input[name="name"]').value;
        
        if (!name) {
            alert('Должно быть название');
            return false;
        }
        
        addData({
            item: item,
            name: name,
            data: null
        });
    }
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
                    var span = document.createElement('span');
                    span.classList.add('small');
                    span.textContent = 'Для удаления картинки кликните по ней.';
                td.appendChild(span);
            tr.appendChild(td);
                var td = document.createElement('td');
                td.id = 'cell_img';
                td.dataset.idimg = arr['id'];
                
                if (arr['img']) {
                    td.innerHTML = '<img id="book_img" src="' + path + 'userfiles/book_img/baseimg/' + arr['img'] + '">';
                } else {
                    td.innerHTML = '<input id="butUpload" class="left" type="file" name="img">';
                }
            tr.appendChild(td);
            table.appendChild(tr);
            
            /* Превью фото: */
            var tr = document.createElement('tr');
                var td = document.createElement('td');
                td.classList.add('right');
                td.textContent = 'Превью фото';
            tr.appendChild(td);
                var td = document.createElement('td');
                td.innerHTML = '<img id="preview" src="">';
            tr.appendChild(td);
            table.appendChild(tr);
        }
        /* ======== =========*/
    form.appendChild(table);
    
    button.type = 'button';
    button.textContent = 'Редактировать';
    button.dataset.id = arr['id'];
    button.dataset.todo = 'edit_' + item;
    button.addEventListener('click', function(event) {
        var target = event.target;
        editItem(target);
    });
    form.appendChild(button);
    
    
    fragment.appendChild(header);
    fragment.appendChild(form);
    
    content.innerHTML = '';
    content.appendChild(fragment);
}

/* ФУНКЦИЯ РЕДАКТИРОВАНИЯ ДАННЫХ: КНИГ, АВТОРОВ, ЖАНРОВ */
function editItem(target) {
    var todoArr = target.dataset.todo.split('_');
    var action = todoArr[0]; // add/edit/del
    var item = todoArr[1]; // book/author/genre
    var id = +target.dataset.id;
    
    if (action === 'edit') {
        var name = document.querySelector('input[name="name"]').value;
        
        if (!name) {
            alert('Должно быть название');
            return false;
        }
        
        editData({
            item: item,
            name: name,
            id: id,
            data: null
        });
    }
}