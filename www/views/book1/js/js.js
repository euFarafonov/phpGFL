// создание объекта XHR
function getXHR(){
    if(window.XMLHttpRequest){
        return new XMLHttpRequest();
    }else if(window.ActiveXObject){
        return new ActiveXObject("Microsoft.XMLHTTP");
    }else {
        return;
    }
}

// очистка sessionStorage
var clearStorage = document.querySelectorAll('.js_clear_storage');
for (let i = 0; i < clearStorage.length; i++) {
    clearStorage[i].addEventListener('click', function(){
        sessionStorage.clear();
    });
}

/* ======================================== ПОИСК ======================================== */
var searchWrap = document.querySelector('.header_search');
var searchInput = searchWrap.querySelector('.search_input');
var searchList = searchWrap.querySelector('.search_list');
var windowHeight = document.documentElement.clientHeight;

searchInput.addEventListener('keydown', checkKey);

searchInput.addEventListener('focus', function(){
    var childs = searchList.children;
    if(childs.length > 0){
        searchList.style.display = 'block';
    }
});

searchInput.addEventListener('input', function(){
    var str = this.value;
    var strLength = str.length;
    if(strLength < 3){
        return false;
    }
    
    var strEncode = encodeURIComponent(str);
    data = "str=" + strEncode + "&search=search";
    var xhr = getXHR();
    
    xhr.onreadystatechange = function(){
        if(xhr.readyState === 4){
            var answer = JSON.parse(xhr.response);
            
            if(answer["state"] === "OK"){
                var books = answer["result"];
                var res = '';
                for(var i = 0; i < books.length; i++){
                    var bookName = books[i]["name"];
                    var newBookName = bookName.replace(new RegExp(str,'i'), '<span class="bold">' + '$&' + '</span>');
                    
                    res += '<li><a href="' + path + '?view=book&book_id=' + books[i]["id"] + '">' + newBookName + '</a></li>';
                }
                searchList.innerHTML = res;
                searchList.style.display = 'block';
            }else{
                searchList.innerHTML = '';
                searchList.style.display = '';
            }
        }
    };
    
    xhr.open('POST', path, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send(data);
});

searchList.addEventListener('mouseleave', function(){
    this.style.display = '';
    searchInput.blur();
});

function checkKey(event){
    if(event.keyCode == 13) event.preventDefault();
}