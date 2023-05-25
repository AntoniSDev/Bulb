// Exécuter le code lorsque le document est prêt
$(document).ready(function () {
    // Ajouter un gestionnaire d'événements pour les clics sur les éléments avec la classe 'delete-link'
    $(".delete-link").click(function (e) {
        e.preventDefault(); // Empêcher le comportement par défaut du lien (redirection vers l'URL du lien)

        // Récupérer l'URL de suppression du lien sur lequel l'utilisateur a cliqué
        const deleteUrl = $(this).attr("href");
        // Récupérer l'ID de l'ampoule associée au lien sur lequel l'utilisateur a cliqué
        const bulbId = $(this).data("bulb-id");

        // Définir l'URL de suppression dans le lien de confirmation de la boîte de dialogue
        $("#deleteLink").attr("href", deleteUrl);
        // Afficher l'ID de l'ampoule dans le texte de confirmation de la boîte de dialogue
        $("#deleteBulbId").text(bulbId);
        // Afficher la boîte de dialogue de confirmation
        $("#confirmationModal").modal("show");
    });

    // Ajouter un gestionnaire d'événements pour la fermeture de la boîte de dialogue de confirmation
    $("#confirmationModal").on("hide.bs.modal", function () {
        // Réinitialiser l'URL de suppression dans le lien de confirmation
        $("#deleteLink").attr("href", "#");
        // Effacer le texte de l'ID de l'ampoule dans le texte de confirmation
        $("#deleteBulbId").text("");
    });
});

// Exécuter le code lorsque le document est prêt
$(document).ready(function () {
    // Sélectionner tous les éléments avec la classe 'toast' et les stocker dans une liste
    const toastElList = [].slice.call(document.querySelectorAll('.toast'));

    // Créer une liste de toasts en utilisant les éléments sélectionnés précédemment
    const toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl);
    });

    // Afficher chaque toast dans la liste
    toastList.forEach(function (toast) {
        toast.show();
    });
});
