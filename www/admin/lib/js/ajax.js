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

// ПОЛУЧЕНИЕ ВСЕХ КНИГ
function getBook() {
    data = "item=book&check=ajax";
    var xhr = getXHR();
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            var answer = JSON.parse(xhr.response);
            
            if (answer["state"] === "OK") {
                console.log(answer);
                
                //cellImg.innerHTML = '<input id="butUpload" class="left" type="file" name="img">';
                //input = document.getElementById('butUpload');
                //listenInput(input);
            } else {
                console.log(answer);
                //return false;
            }
        }
    };
    
    xhr.open('POST', path + 'admin/index.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);
}





/*================================================================================================*/

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

