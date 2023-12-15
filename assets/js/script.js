const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      modeSwitch = body.querySelector(".toggle-switch"),
      sunSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");




modeSwitch.addEventListener("click" , () =>{
    body.classList.toggle("dark");
    
    if(body.classList.contains("dark")){
        modeText.innerText = "Light mode";
    }else{
        modeText.innerText = "Dark mode";
        
    }
});