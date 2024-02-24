const buttonDataUser = document.querySelector('#data_user');
const buttonDataReport = document.querySelector('#data_report');
const buttonDataTransaction = document.querySelector('#data_transaction');
const childDataUser = document.querySelector('#child_data_user');
const childDataReport = document.querySelector('#child_data_report');
const childDataTransaction = document.querySelector('#child_data_transaction');
const hamburger = document.querySelector('.hamburger');
const sidebar = document.querySelector('.sidebar');

if (buttonDataUser) {
    buttonDataUser.addEventListener('click', function() {
        buttonDataUser.classList.toggle('active');
        childDataUser.classList.toggle('active');
    });
}

if (buttonDataReport) {
    buttonDataReport.addEventListener('click', function() {
        buttonDataReport.classList.toggle('active');
        childDataReport.classList.toggle('active');
    });
}

if (buttonDataTransaction) {
    buttonDataTransaction.addEventListener('click', function() {
        buttonDataTransaction.classList.toggle('active');
        childDataTransaction.classList.toggle('active');
    });
}

if (hamburger) {
    hamburger.addEventListener('click', function() {
        sidebar.classList.toggle('show');
    });
}