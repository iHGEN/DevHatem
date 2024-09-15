function adjustLayout() {
  const container = document.getElementById('container');
  const aboutme = document.getElementById("About me");
  const elements = document.querySelectorAll('#title-text');

  if (window.innerWidth <= 600) {
    if(elements != null){
      elements.forEach(element => {
        element.style.top = "30%";
    });
    }
  
    aboutme.style.marginTop = "110px";
    container.style.flexDirection = "column"; // Stack elements vertically
  } else {
    container.style.flexDirection = "row"; // Arrange elements in a row
  }
}

adjustLayout();

window.addEventListener('resize', adjustLayout);