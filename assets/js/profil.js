/**
 * Met à jour le nombre de caractères restants possibles pour l'édition de la description du profil utilisateur.
 * @param {*} event 
 */
function onKeyupUpdateCountDescription(event) {
    descriptionTextarea = document.querySelector("textarea#profil_description_description");
    document.querySelector('span#js-caracteres-restants').textContent = descriptionTextarea.maxLength - descriptionTextarea.value.length;
}

/**
 * Fonction qui remplace la zone de playlist du profil par son formulaire d'edition.
 * @param {*} event 
 */
function onClickGetPlaylistForm(event) {
    event.preventDefault();

    document.querySelectorAll('a.js-playlist-form-link').forEach(function (link) {
        link.style.display = 'none';
    });

    playlistForm = document.querySelector('div#js-playlist-form').style.display = "block";
}

/**
 * Ferme le formulaire d'édition de la source de la playlist.
 * @param {*} event 
 */
function onClickClosePlaylistForm(event) {
    event.preventDefault();
    // on ferme le formulaire
    document.querySelector('input#profil_playlist_playlistLink').value = '';
    document.querySelector('div#js-playlist-form').style.display = "none";
    // on affiche de nouveau l'icone d'edition
    document.querySelectorAll('a.js-playlist-form-link').forEach(function (link) {
        link.style.display = 'inline';
    });
}

/**
 * Fonction qui remplace la zone de description du profil par son formulaire d'edition.
 * @param {*} event 
 */
function onClickGetDescriptionForm(event) {
    event.preventDefault();

    descriptionArea = document.querySelector("div#js-profil-description");
    descriptionArea.style.display = "none";

    descriptionTextarea = document.querySelector("textarea#profil_description_description");
    document.querySelector('span#js-caracteres-restants').textContent = descriptionTextarea.maxLength - descriptionTextarea.value.length;
    descriptionForm = document.querySelector("div#js-description-form");
    descriptionForm.style.display = "block";
}

/**
 * Fonction qui traite dynamiquement la submission du formulaire d'edition de la playlist du profil.
 * @param {*} event 
 */
function onSubmitEditPlaylist(event) {
    event.preventDefault();

    formData = new FormData(this);

    axios.post(this.action, formData).then(function (response) {
        // on ferme le formulaire
        document.querySelector('input#profil_playlist_playlistLink').value = '';
        document.querySelector('div#js-playlist-form').style.display = "none";

        container = document.querySelector('div#js-profil-playlist');

        // on met la playlist a jour
        if (response.data.newPlaylist == '') {

            console.log('pas de nouvelle playlist');

            if (!document.querySelector('div#js-profil-playlist-empty-case')) {

                console.log('pas de div empty');

                // on n'affiche plus le code du cas ou il y avait une playlist avant
                document.querySelector('div#js-profil-playlist-filled-case').style.display = 'none';

                contentDiv = document.createElement('div');
                contentDiv.classList.add('has-text-centered');
                contentDiv.id = "js-profil-playlist-empty-case";

                textSpan = document.createElement('span');
                textSpan.textContent = "Partagez vos morceaux favoris en ajoutant une playlist Youtube !";

                nbsp = document.createTextNode("\u00A0\u00A0\u00A0");

                iconsA = document.createElement('a');
                iconsA.classList.add('js-playlist-form-link');
                iconsA.addEventListener('click', onClickGetPlaylistForm);

                plusI = document.createElement('i');
                plusI.classList.add('fas', 'fa-plus');
                musicI = document.createElement('i');
                musicI.classList.add('fas', 'fa-music');

                iconsA.append(plusI);
                iconsA.append(musicI);

                contentDiv.append(textSpan);
                contentDiv.append(nbsp);
                contentDiv.append(iconsA);

                container.append(contentDiv);

            } else {

                console.log('div empty');
                // si il y a avait une playlist avant, on efface sa div
                if (myVar = document.querySelector('div#js-profil-playlist-filled-case')) {
                    myVar.style.display = "none";
                }

                document.querySelector('div#js-profil-playlist-empty-case').style.display = "block";
            }

        } else {

            console.log('nouvelle playlist');

            if (filledCaseDiv = document.querySelector('div#js-profil-playlist-filled-case')) {

                console.log('div filled');

                if (myVar = document.querySelector('div#js-profil-playlist-empty-case')) {
                    console.log('disparition de empty case');
                    myVar.style.display = "none";
                }

                document.querySelector('iframe#js-profil-playlist-iframe').src = response.data.newPlaylist;

                filledCaseDiv.style.display = "block";

            } else {

                console.log('pas de div filled');

                if (myVar = document.querySelector('div#js-profil-playlist-empty-case')) {
                    myVar.style.display = 'none';
                }

                contentDiv = document.createElement('div');
                contentDiv.id = "js-profil-playlist-filled-case";

                figure = document.createElement('figure');
                figure.classList.add('image', 'is-16by9');

                playlistIframe = document.createElement('iframe');
                playlistIframe.id = "js-profil-playlist-iframe";
                playlistIframe.classList.add('has-ratio', 'has-shadow');
                playlistIframe.width = "640";
                playlistIframe.height = "360";
                playlistIframe.src = response.data.newPlaylist;
                playlistIframe.frameborder = "0";
                playlistIframe.setAttribute("allowfullscreen", "");

                figure.append(playlistIframe);

                iconsDiv = document.createElement('div');
                iconsDiv.classList.add('has-text-centered');
                iconsDiv.style.marginTop = "1rem";

                iconsA = document.createElement('a');
                iconsA.classList.add('js-playlist-form-link');
                iconsA.addEventListener('click', onClickGetPlaylistForm);

                penI = document.createElement('i');
                penI.classList.add('fas', 'fa-pen');
                musicI = document.createElement('i');
                musicI.classList.add('fas', 'fa-music');

                iconsA.append(penI);
                iconsA.append(musicI);

                iconsDiv.append(iconsA);

                contentDiv.append(figure);
                contentDiv.append(iconsDiv);


                container.append(contentDiv);
            }
        }

        // on affiche de nouveau l'icone d'edition
        document.querySelectorAll('a.js-playlist-form-link').forEach(function (link) {
            link.style.display = 'inline';
        });

    }).catch(function (error) {
        if (error.response.status === 403) { // cas ou on est deconnecte
            window.alert('Vous devez vous connecter pour modifier votre description.');
        } else if (error.response.status === 400) {
            window.alert('Formulaire invalide !');
        } else {
            window.alert('Une erreur s\'est produite, réessayez plus tard.');
        }
    });
}

/**
 * Traite dynamiquement la submission du formulaire d'edition de la description du profil.
 * @param {*} event 
 */
function onSubmitEditDescription(event) {
    event.preventDefault();

    formData = new FormData(this);

    axios.post(this.action, formData).then(function (response) {

        descriptionForm = document.querySelector("div#js-description-form"); // form wrapper
        descriptionForm.style.display = 'none';

        descriptionArea = document.querySelector("div#js-profil-description"); // description wrapper
        newDescription = document.querySelector('textarea#profil_description_description').value;

        if (newDescription == '') {

            while (descriptionArea.firstChild) {
                descriptionArea.removeChild(descriptionArea.firstChild);
            }
            descriptionContainer = document.createElement('div');
            descriptionContainer.classList.add('has-text-centered');

            penIcon = document.createElement('i');
            penIcon.classList.add('fas', 'fa-pen-fancy');

            formLink = document.createElement('a');
            formLink.classList.add('js-profil-description-form-link');
            formLink.addEventListener('click', onClickGetDescriptionForm);

            nbsp = document.createTextNode("\u00A0\u00A0\u00A0");

            formLinkText = document.createElement('span');
            formLinkText.textContent = "Commencez à rédiger votre description !";

            formLink.append(formLinkText);
            formLink.append(nbsp);
            formLink.append(penIcon);

            descriptionContainer.append(formLink);

            descriptionArea.append(descriptionContainer);

        } else {

            descriptionContainer = document.querySelector('span#js-description');

            // si le container de la description existe (c'est-à-dire qu'avant l'édition il y avait déjà une description avant
            if (descriptionContainer) {
                descriptionContainer.textContent = newDescription;

                // sinon on crée le container de la description avec la mise en page associée
            } else {

                while (descriptionArea.firstChild) {
                    descriptionArea.removeChild(descriptionArea.firstChild);
                }

                leftQuoteP = document.createElement('p');
                leftQuoteP.classList.add('has-text-left');

                leftQuoteI = document.createElement('i');
                leftQuoteI.classList.add('fas', 'fa-quote-left', 'fa-2x');

                leftQuoteP.append(leftQuoteI);

                intoQuotesDiv = document.createElement('div');
                intoQuotesDiv.classList.add('has-text-justified');
                intoQuotesDiv.id = "intoQuotes";

                intoQuotesP = document.createElement('p');

                intoQuotesDiv.append(intoQuotesP);

                descriptionSpan = document.createElement('span');
                descriptionSpan.id = "js-description";
                descriptionSpan.textContent = newDescription;

                nbsp = document.createTextNode("\u00A0\u00A0\u00A0");

                formLinkA = document.createElement('a');
                formLinkA.classList.add('js-profil-description-form-link');
                formLinkA.addEventListener('click', onClickGetDescriptionForm);

                penIcon = document.createElement('i');
                penIcon.classList.add('fas', 'fa-pen-fancy');

                intoQuotesP.append(descriptionSpan);
                intoQuotesP.append(nbsp);
                intoQuotesP.append(formLinkA);

                formLinkA.append(penIcon);

                rightQuoteP = document.createElement('p');
                rightQuoteP.classList.add('has-text-right');

                rightQuoteI = document.createElement('i');
                rightQuoteI.classList.add('fas', 'fa-quote-right', 'fa-2x');

                rightQuoteP.append(rightQuoteI);

                descriptionArea.append(leftQuoteP);
                descriptionArea.append(intoQuotesDiv);
                descriptionArea.append(rightQuoteP)

                pseudoP = document.createElement('p');
                pseudoP.classList.add('subtitle', 'has-text-centered', 'is-italic');
                pseudoP.textContent = response.data.pseudo; // erreur a cause de twig/js et du linter mais ça marche...

                descriptionArea.append(pseudoP);
            }
        }

        descriptionArea.style.display = "block";

    }).catch(function (error) {
        if (error.response.status === 403) { // cas ou on est deconnecte
            window.alert('Vous devez vous connecter pour modifier votre description.')
        } else if (error.response.status === 400) {
            window.alert('Formulaire invalide !');
        } else {
            window.alert('Une erreur s\'est produite, réessayez plus tard.');
        }
    });
}

function onChangeSubmitProfileForm(event) {
    event.preventDefault();

    $profileForm = document.querySelector('form.js-profile-form-object');

    formData = new FormData($profileForm);

    axios.post($profileForm.action, formData).then(function (response) {
        $profileImg = document.querySelector('div#js-profile-img');

        if ($profileImg) {
            console.log('image changed');
            $profileImg.style.backgroundImage = "uploads/users_pp/" + response.data.newPicture;
        } else {
            console.log('no image');
        }
    }).catch(function (error) {
        if (error.response.status === 403) { // cas ou on est deconnecte
            window.alert('Vous devez vous connecter pour modifier votre description.')
        } else if (error.response.status === 400) {
            window.alert('Formulaire invalide !');
        } else {
            window.alert('Une erreur s\'est produite, réessayez plus tard.');
        }
    });
}

// Toggle le modal d'info du champ de l'url du formulaire de la playlist
function onClickTogglePlaylistInfoModal(event) {
    document.querySelector('div#js-playlist-info-modal').classList.toggle('is-active');
}

// affichage des formulaires a partir des icones
document.querySelectorAll('a.js-profil-description-form-link').forEach(function (link) {
    link.addEventListener('click', onClickGetDescriptionForm);
});

document.querySelectorAll('a.js-playlist-form-link').forEach(function (link) {
    link.addEventListener('click', onClickGetPlaylistForm);
})

// fermeture du formulaire de playlist
document.querySelector('button#js-playlist-form-close').addEventListener('click', onClickClosePlaylistForm);

// traitement de la submission des formulaires
document.querySelector('.js-description-form-object').addEventListener('submit', onSubmitEditDescription);
document.querySelector('.js-playlist-form-object').addEventListener('submit', onSubmitEditPlaylist);
document.querySelector('input#profil_picture_profilPictureFile').addEventListener('input', onChangeSubmitProfileForm);

// affichage nombre de caractères restants pour l'édition de la description
document.querySelector('textarea#profil_description_description').addEventListener('input', onKeyupUpdateCountDescription);

// affichage/fermeture du modal d'info de l'url a mettre pour la playlist
document.querySelectorAll('.js-toggle-playlist-info-modal').forEach(function (link) {
    link.addEventListener('click', onClickTogglePlaylistInfoModal);
});