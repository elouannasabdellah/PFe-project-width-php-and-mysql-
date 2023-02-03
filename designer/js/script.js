// Get the modal
// var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//     if (event.target == modal) {
//         modal.style.display = "none";
//     }
// }
// Get the modal
// var modal = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
//     if (event.target == modal1) {
//         modal.style.display = "none";
//     }
// }

// validation de form de inscription

var inscription_form = document.getElementById('inscription_form');
inscription_form.addEventListener('submit',(error)=>{

  var password= document.getElementById('password');
  var tele = document.getElementById('tele');

  if(password.value.length<6){
   
    // alert('more the 6 caractere');
    password.style.borderColor="red";
   document.getElementById('password_error').innerHTML="mot de passe doit etre au moins 6 caractère";
  
    error.preventDefault();
  }
  if(tele.value.length<10){
    tele.style.borderColor= "red";
    document.getElementById('tele_error').innerHTML = "télèphone doit etre   10 nombres ";

    error.preventDefault();
  }


});


