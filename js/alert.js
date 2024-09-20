
setTimeout(function() {
  const alertBox = document.getElementById('alert-box');
  if (alertBox) {
    alertBox.style.transition = "opacity 0.5s ease"; 
    alertBox.style.opacity = "0";  
    setTimeout(function() {
      alertBox.style.display = "none";  
    }, 500); 
  }
}, 3000);
