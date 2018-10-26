'use strict';

function onAjaxGetCity($data) {
    $(".city option").remove();
    $.each($data.ville, function (index, value) {
        $(".city").append($('<option>', {value: value, text: value}));
    });
}

function onCpGetCity() {
    if ($(".cp").val().length === 5) {
        $.getJSON(
            Routing.generate('city', {cp: $(".cp").val()}),// URL vers  contrôleur
            onAjaxGetCity // Méthode appelée au retour de la réponse HTTP
        );
    } else {
        $(".city").val('');
    }
}


$(document).ready(function () {
    $(".cp").on('keyup', onCpGetCity);
});