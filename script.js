
$(document).ready(function () {
    $(".delete-link").click(function (e) {
      e.preventDefault(); // Empêche le comportement par défaut du lien
  
      var deleteUrl = $(this).attr("href"); // Récupère l'URL de suppression du lien
      var bulbId = $(this).data("bulb-id"); // Récupère l'ID de l'ampoule associée au lien
  
      $("#deleteLink").attr("href", deleteUrl); // Définit l'URL de suppression dans le lien de confirmation
      $("#deleteBulbId").text(bulbId); // Affiche l'ID de l'ampoule dans le texte de confirmation
      $("#confirmationModal").modal("show"); // Affiche la boîte de dialogue de confirmation
    });
  
    $("#confirmationModal").on("hide.bs.modal", function () {
      $("#deleteLink").attr("href", "#"); // Réinitialise l'URL de suppression dans le lien de confirmation
      $("#deleteBulbId").text(""); // Efface le texte de l'ID de l'ampoule dans le texte de confirmation
    });
  });
  

  