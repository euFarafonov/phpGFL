var nameStorage = sessionStorage.getItem('name');
var idStorage = sessionStorage.getItem('id');

if (nameStorage && idStorage) {
    var activeLink = document.getElementById(nameStorage + '_' + idStorage);
    activeLink.classList.add('nav_active');
    activeLink.parentElement.parentElement.classList.add('nav_inner_active');
}

function Accordion(options) {
    var accordion = document.getElementById(options.navId);
    
    accordion.addEventListener('click', function(event) {
        var target = event.target;
        
        if (target.classList.contains(options.navHeader)) {
            var navInner = target.nextElementSibling;
            var itemOpen = navInner.classList.contains('nav_inner_active');
            
            closeAllInner();
            
            if (!itemOpen) {
                navInner.classList.add('nav_inner_active');
            }
        }
        
        if (target.classList.contains('js_nav_storage')) {
            sessionStorage.setItem('name', target.dataset.name);
            sessionStorage.setItem('id', target.dataset.id);
        }
    });
    
    function closeAllInner(){
        var arrInner = document.querySelectorAll('.nav_inner_active');
        
        if (arrInner) {
            for (let i = 0; i < arrInner.length; i++) {
                arrInner[i].classList.remove('nav_inner_active');
            }
        }
    }
}