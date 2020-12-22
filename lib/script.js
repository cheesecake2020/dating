'use strict'
const form = document.getElementById('form');
const  blood = document.getElementById('blood_type');
const  state = document.getElementById('state');
const  school = document.getElementById('school_career');
const  work = document.getElementById('work');
const hobby = document.getElementById('hobby');
const personality = document.getElementById('personality');
const message = document.getElementById('message');

form.addEventListener('submit', (e) => {

    checkInputs();
});

function checkInputs() {
    // inputの値を取得
    const bloodValue = blood.value.trim();
    const stateValue =state.value.trim();
    const schoolValue =school.value.trim();
    const workValue =work.value.trim();
    const hobbyValue =hobby.value.trim();
    const personalityValue =personality.value.trim();
    const messageValue = message.value.trim();
    
    if (bloodValue === '') {
        // エラーメッセージ表示
        // 失敗CSS
        setErrorFor(bloodValue,'血液型を選択してください')
    } else {
        // 成功CSS
        setSuccessFor(bloodValue);
    }
}

function setErrorFor(input, message) {
    const formControl =input.parentElement;/**form-control */
    console.log('formControl:',formControl);
    const small = formControl.querySelector('small');
    // エラーメッセージ追加
    small.innerText = message;
// エラーcss追加
    formControl.className = 'form-control error';

}