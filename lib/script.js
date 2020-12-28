'use strict'
const hamburger = document.getElementById('hamburger');
const navUL = document.getElementById('nav-ul');
console.log(hamburger);
console.log(navUL);

hamburger.addEventListener('click', () => {
    // ボタンが押されたらcssをチェンジ
    navUL.classList.toggle('show');
})