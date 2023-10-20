let new_note_button = document.querySelector('.new-private-note');
if( new_note_button ) {
    new_note_button.addEventListener('click', function(e) {
        e.preventDefault();

        var private_notes_wrapper = document.getElementById('private-notes');
        let private_notes_count = private_notes_wrapper.querySelectorAll('textarea').length;
            private_notes_count++;

        let new_private_field = document.createElement("textarea");
            new_private_field.setAttribute('rows', '2');
            new_private_field.setAttribute('cols', '30');
            new_private_field.setAttribute('name', 'wc_private_notes_'+private_notes_count);
            new_note_button.parentElement.insertBefore(new_private_field, new_note_button);
    });
}