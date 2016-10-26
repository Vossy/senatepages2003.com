function askToConfirm()
{
   shade = document.getElementById("ConfirmShade");
   popup = document.getElementById("ConfirmPopup");

   shade.style.display = "block";
   popup.style.display = "block";

};

function closeConfirm()
{
   shade = document.getElementById("ConfirmShade");
   popup = document.getElementById("ConfirmPopup");

   shade.style.display = "none";
   popup.style.display = "none";
};
