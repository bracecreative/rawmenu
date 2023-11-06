const create_credit_button = document.querySelector('.add-order-credit');
const create_credit_form = document.querySelector('.order-credit-form');
if( create_credit_button ) {
    create_credit_button.addEventListener('click', function(e) {
        e.preventDefault();

        create_credit_form.style.display = 'block';
        create_credit_button.style.display = 'none';
    })
}