const buttonDataUser = document.querySelector('#data_user');
const buttonDataReport = document.querySelector('#data_report');
const buttonDataTransaction = document.querySelector('#data_transaction');
const childDataUser = document.querySelector('#child_data_user');
const childDataReport = document.querySelector('#child_data_report');
const childDataTransaction = document.querySelector('#child_data_transaction');
const buttonNotification = document.querySelector('.button-notification');
const popupNotification = document.querySelector('.popup-notification');
const buttonProfile = document.querySelector('.button-profile');
const popupProfile = document.querySelector('.popup-profile');
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

if (buttonNotification) {
    buttonNotification.addEventListener('click', function() {
        popupProfile.classList.remove('active');
        popupNotification.classList.toggle('active');
    });
}

if (buttonProfile) {
    buttonProfile.addEventListener('click', function() {
        popupNotification.classList.remove('active');
        popupProfile.classList.toggle('active');
    });
}
