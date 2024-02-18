const buttonDataUser = document.querySelector('#data_user');
const buttonDataTransaction = document.querySelector('#data_transaction');
const childDataUser = document.querySelector('#child_data_user');
const childDataTransaction = document.querySelector('#child_data_transaction');

if (buttonDataUser) {
    buttonDataUser.addEventListener('click', function() {
        buttonDataUser.classList.toggle('active');
        childDataUser.classList.toggle('active');
    });
}

if (buttonDataTransaction) {
    buttonDataTransaction.addEventListener('click', function() {
        buttonDataTransaction.classList.toggle('active');
        childDataTransaction.classList.toggle('active');
    });
}