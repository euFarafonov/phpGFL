/* === Работа с фото на странице редактирования книги === */
var cellImg = document.getElementById('cell_img'),
    bookImg = document.getElementById('book_img'),
    preview = document.getElementById('preview'),
    input = document.getElementById('butUpload'),
    id = +cellImg.dataset.idimg,
    fileReader = new FileReader();

if (bookImg) {
    bookImg.addEventListener('click', function() {
        var res = confirm("Подтвердите удаление");
        if (!res) return false;
        
        del_img(id);
    });
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
    
    xhr.open('POST', path + 'admin/?view=edit_book', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);
}

// загрузка фото
fileReader.addEventListener('load', function(){
    preview.src = fileReader.result;
});

if (input) {
    listenInput(input);
}

function listenInput(input) {
    input.addEventListener('change', function(){
        var file = input.files[0];
        
        if (input.files.length > 1) {
            alert('Можно выбрать только 1 фото книги!');
            return false;
        }
        
        if (file.size > 1024*1000*2) {
            alert('Максимальный размер фото - 2 мегабайта!');
            return false;
        }
        
        if (!inArray(file.type)) {
            alert('Можно выбрать только с расширением jpg, jpeg, png, gif!');
            return false;
        }
        
        fileReader.readAsDataURL(file);
    });
}