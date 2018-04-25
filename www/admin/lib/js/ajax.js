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
function getData(item, link) {
    var data = "item=" + item + "&check=ajax";
    var xhr = getXHR();
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            var answer = JSON.parse(xhr.response);
            
            if (answer["state"] === "OK") {
                renderTable(answer['res'], item, link);
            } else {
                console.log('error');
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