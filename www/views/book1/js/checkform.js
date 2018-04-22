/* Проверка формы заказа */
var bookForm = document.getElementById('book_order');
bookForm.addEventListener('submit', function(event){
    event.preventDefault();
    
    var errors = 0;
    var inputArr = bookForm.querySelectorAll('.label_text input');
    var inputCnt = bookForm.querySelector('.label_cnt input');
    var bookCnt = +inputCnt.value;
    
    for (let i = 0; i < inputArr.length; i++) {
        let curInput = inputArr[i];
        
        if (curInput.value === '') {
            errors++;
            curInput.parentElement.classList.add('label_text_error');
            
            curInput.addEventListener('keydown', function(){
                curInput.parentElement.classList.remove('label_text_error');
            });
        }
    }
    
    if (bookCnt < 1 || bookCnt > 10 || isNaN(bookCnt)) {
        errors++;
        inputCnt.parentElement.classList.add('label_cnt_error');
    }
    
    if (!errors) {
        bookForm.submit();
    }
});