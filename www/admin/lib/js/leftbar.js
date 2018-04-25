function Leftbar(options) {
    var lb = document.getElementById(options.lbId);
    
    lb.addEventListener('click', function(event) {
        event.preventDefault();
        
        var target = event.target;
        var activeLink = lb.querySelector('.active');
        
        if (target.tagName === 'SPAN' && !target.classList.contains('active')) {
            activeLink.classList.remove('active');
            target.classList.add('active');
            
            var linkType = target.dataset.item;
            getData(linkType, target);
        }
    });
}

function renderTable(arr, item, link) {
    var content = document.querySelector('.content');
    var fragment = document.createDocumentFragment();
    
    var header = document.createElement('h1');
    header.textContent = link.dataset.name;
    
    var btnAddFirst = document.createElement('span');
    btnAddFirst.textContent = 'Добавить';
    btnAddFirst.classList.add('button');
    btnAddFirst.dataset.toro = 'add_' + item;
            
    /* начало формирование таблицы */
    var table = document.createElement('table');
    table.classList.add('pages_table');
    
    /* == строка шапки таблицы */
    var tr = document.createElement('tr');
    
    var th = document.createElement('th');
    th.textContent = '№';
    tr.appendChild(th);
    
    if (item === 'book') {
        var th = document.createElement('th');
        th.textContent = 'Фото';
        tr.appendChild(th);
    }
    
    var th = document.createElement('th');
    th.textContent = 'Наименование';
    tr.appendChild(th);
    var th = document.createElement('th');
    th.textContent = 'Действие';
    tr.appendChild(th);
    
    table.appendChild(tr);
    
    /* == остальные строки таблицы */
    if (arr) {
        for (var i = 0; i < arr.length; i++) {
            var tr = document.createElement('tr');
    
            var td = document.createElement('td');
            td.textContent = i + 1;
            tr.appendChild(td);
            
            if (item === 'book') {
                var td = document.createElement('td');
                td.innerHTML = '<img src="' + path + 'userfiles/book_img/baseimg/' + arr[i]['img'] + '">';
                tr.appendChild(td);
            }
            
            var td = document.createElement('td');
            td.textContent = arr[i]['name'];
            td.classList.add('left');
            tr.appendChild(td);
            
            var td = document.createElement('td');
            td.innerHTML = '<span data-id="' + arr[i]['id'] + '" class="edit">редактировать</span>\
            |\
            <span data-id="' + arr[i]['id'] + '" class="del">удалить</span>';
            tr.appendChild(td);
            
            table.appendChild(tr);
        }
    }
    /* конец формирования таблицы */
    
    var btnAddSecond = document.createElement('span');
    btnAddSecond.textContent = 'Добавить';
    btnAddSecond.classList.add('button');
    btnAddSecond.dataset.toro = 'add_' + item;
    
    fragment.appendChild(header);
    fragment.appendChild(btnAddFirst);
    fragment.appendChild(table);
    fragment.appendChild(btnAddSecond);
    
    content.innerHTML = '';
    content.appendChild(fragment);
}