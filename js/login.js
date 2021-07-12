const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-txt");

form.onsubmit = (e)=>{
    e.preventDefault(); //Prevents form from submitting.
}

continueBtn.onclick = ()=>{
    //Ajax Starts
    let xhr = new XMLHttpRequest(); //Creating XML object.
    xhr.open("POST", "./php/login.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(data == "success"){
                    location.href = "users.php";
                }else{
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    }
    //Sending form data to php throught Ajax
    let formData = new FormData(form); // Creating new formData Onject
    xhr.send(formData); //Sending the form data to php
}