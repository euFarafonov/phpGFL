/* === Подтверждение удаления === */
var delArr = document.querySelectorAll('.delete');
if (delArr.length > 0) {
    for (var i = 0; i < delArr.length; i++) {
        delArr[i].addEventListener('click',function(event) {
            event.preventDefault();
            var url = this.href;
            var res = confirm("Подтвердите удаление");
            
            if(!res) return false;
            window.location = url;
        });
    }
}
/* === Подтверждение удаления === */

/* === Проверка на наличие элемента в массиве === */
function inArray(type) {
    var mimeType = ["image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"];
    
    return (mimeType.indexOf(type) === -1) ? false : true;
}
/* === Проверка на наличие элемента в массиве === */

/* === Добавление или удаление полей SELECT для авторов и жанров === */
function Fields(options) {
    var parentEl = document.getElementById(options.parent),
    addSelect = parentEl.querySelector('#add_select'),
    delSelect = parentEl.querySelector('#del_select'),
    max = options.maxFields,
    min = 1;
    
    var allSelect = parentEl.querySelectorAll('.js_field');
    var allSelectCnt = allSelect.length;
    
    checkFilds();
    
    // кнопка добавить поле
    addSelect.addEventListener('click', function() {
        if (addSelect.classList.contains('btn_off')) return false;
        
        var selectTemplate = parentEl.firstElementChild;
        var select = selectTemplate.cloneNode(true);
        parentEl.insertBefore(select, addSelect);
        
        allSelectCnt++;
        checkFilds();
    });
    // кнопка удалить поле
    delSelect.addEventListener('click', function() {
        if (delSelect.classList.contains('btn_off')) return false;
        
        allSelect = parentEl.querySelectorAll('.js_field');
        allSelectCnt = allSelect.length;
        var lastFields = allSelect[allSelectCnt - 1];
        parentEl.removeChild(lastFields);
        
        allSelectCnt--;
        checkFilds();
    });
    
    // вкл./выкл. кнопок
    function checkFilds() {
        if (allSelectCnt >= max) {
            addSelect.classList.add('btn_off');
        } else {
            addSelect.classList.remove('btn_off');
        }
        
        if (allSelectCnt <= min) {
            delSelect.classList.add('btn_off');
        } else {
            delSelect.classList.remove('btn_off');
        }
    }
}
/* === Добавление или удаление полей SELECT для авторов и жанров === */