// создание объекта XHR
function getXHR() {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else if(window.ActiveXObject) {
        return new ActiveXObject("Microsoft.XMLHTTP");
    } else {
        return;
    }
}

// ПОЛУЧЕНИЕ ДАННЫХ ИЗ БД: КНИГ, АВТОРОВ ИЛИ ЖАНРОВ
function getData(options) {
    var item = encodeURIComponent(options.item); // book/author/genre
    var link = options.target; // кнопка
    var action = options.action; // showData/addData/editData
    var queryOpt = options.queryOpt; // объект параметров для запроса
    
    var data = "item=" + item + "&check=ajax";
    
    if (queryOpt) {
        if (queryOpt.whatName) {
            data += "&what=" + encodeURIComponent(queryOpt.whatName);
        }
        
        if (queryOpt.whereName) {
            data += "&whereName=" + encodeURIComponent(queryOpt.whereName) + "&whereValue=" + encodeURIComponent(queryOpt.whereValue);
        }
        
        if (queryOpt.order === false) {
            data += "&order=no";
        }
    }
    
    var xhr = getXHR();
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            var answer = JSON.parse(xhr.response);
            
            if (answer["state"] === "OK") {
                switch(action) {
                    case 'showData':
                        renderTable(answer['res'], item, link);
                    break;
                    
                    case 'addData':
                        renderSelect(answer['res'], item, link);
                    break;
                    
                    case 'editData':
                        renderEdit(answer['res'][0], item);
                    break;
                    
                    case 'get_author_id':
                        saveAuthorsId(answer['res']);
                    break;
                    
                    case 'get_genre_id':
                        saveGenresId(answer['res']);
                    break;
                }
            } else {
                console.log('error_ajax');
            }
        }
    };
    
    xhr.open('POST', path + 'admin/index.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);
}

// удаление фото
function del_img(id) {
    data = "img_id=" + id + "&check=dell_img";
    var xhr = getXHR();
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            var answer = JSON.parse(xhr.response);
            
            if (answer["state"] === "OK") {
                cellImg.innerHTML = '<input id="butUpload" class="left" type="file" name="img">';
                input = document.getElementById('butUpload');
                listenInput(input);
            } else {
                return false;
            }
        }
    };
    xhr.open('POST', path + 'admin/index.php', true);
    //xhr.open('POST', path + 'admin/?view=del_img', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);
}