const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e)=>{
    e.preventDefault(); //Prevent's form from submitting 
}


inputField.focus();
sendBtn.onclick = ()=> {
    scrollToBottom();
    //Ajax Starts
    let xhr = new XMLHttpRequest(); //Creating XML object.
    xhr.open("POST", "./php/insert-chat.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                inputField.value = ""; //clear input field;
            }
        }
    }
    //Sending form data to php throught Ajax
    let formData = new FormData(form); // Creating new formData Onject
    xhr.send(formData); //Sending the form data to php
}

setInterval(()=> {
    //Ajax Starts
    let xhr = new XMLHttpRequest(); //Creating XML object.
    xhr.open("POST", "./php/get-chat.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                // console.log(data);
                chatBox.innerHTML = data;
            }
        }
    }
    //Sending form data to php throught Ajax
    let formData = new FormData(form); // Creating new formData Onject
    xhr.send(formData); //Sending the form data to php
}, 500); //this function will run frequently after 500ms

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}