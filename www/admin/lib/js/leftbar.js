/*
var nameStorage = sessionStorage.getItem('name');
var idStorage = sessionStorage.getItem('id');

if (nameStorage && idStorage) {
    var activeLink = document.getElementById(nameStorage + '_' + idStorage);
    activeLink.classList.add('nav_active');
    activeLink.parentElement.parentElement.classList.add('nav_inner_active');
}
*/
function Leftbar(options) {
    var lb = document.getElementById(options.lbId);
    
    lb.addEventListener('click', function(event) {
        event.preventDefault();
        
        var target = event.target;
        
        if (target.tagName === 'A') {
            var linkName = target.dataset.name;
            var content = document.querySelector('.content');
            
            var fragment = document.createDocumentFragment();
            
            var header = document.createElement('h1');
            header.textContent = linkName;
            
            var btnAddFirst = document.createElement('a');
            btnAddFirst.textContent = 'Добавить';
            btnAddFirst.classList.add('button');
            btnAddFirst.href = '#';
            
            /* формирование таблицы */
            var table = document.createElement('table');
            table.classList.add('pages_table');
            
            var tr = document.createElement('tr');
            
            var th = document.createElement('th');
            th.textContent = '№';
            tr.appendChild(th);
            var th = document.createElement('th');
            th.textContent = 'Наименование';
            tr.appendChild(th);
            var th = document.createElement('th');
            th.textContent = 'Действие';
            tr.appendChild(th);
            
            table.appendChild(tr);
            /* конец формирования таблицы */
            
            var btnAddSecond = document.createElement('a');
            btnAddSecond.textContent = 'Добавить';
            btnAddSecond.classList.add('button');
            btnAddSecond.href = '#';
            
            fragment.appendChild(header);
            fragment.appendChild(btnAddFirst);
            fragment.appendChild(table);
            fragment.appendChild(btnAddSecond);
            
            
            content.innerHTML = '';
            content.appendChild(fragment);
            
            getBook();
            //console.log(linkName);
            /*
            var navInner = target.nextElementSibling;
            var itemOpen = navInner.classList.contains('nav_inner_active');
            
            closeAllInner();
            
            if (!itemOpen) {
                navInner.classList.add('nav_inner_active');
            }
            */
        }
        /*
        if (target.classList.contains('js_nav_storage')) {
            sessionStorage.setItem('name', target.dataset.name);
            sessionStorage.setItem('id', target.dataset.id);
        }
        */
    });
    /*
    function closeAllInner(){
        var arrInner = document.querySelectorAll('.nav_inner_active');
        
        if (arrInner) {
            for (let i = 0; i < arrInner.length; i++) {
                arrInner[i].classList.remove('nav_inner_active');
            }
        }
    }
    */
}