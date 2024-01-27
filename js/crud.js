function update_note(id) {
    var title = jQuery('#note-' + id)
        .find('.note-title')
        .text()
    var description = jQuery('#note-' + id)
        .find('.note-description ')
        .text()

    jQuery('#list-notes-wrap').hide()
    jQuery('#title-warning').hide()
    jQuery('#add-note-wrap').show()
    jQuery('#note_id').val(id)
    jQuery('#title').val(title)
    jQuery('#description').val(description)
}

function insert_note() {
    var note_id = jQuery('#note_id').val()
    var title = jQuery('#title').val()
    var description = jQuery('#description').val()
    /*Check if title is empty */
    if (title == '') {
        jQuery('#title-warning').show()
        return false
    }
    /* When Updating a Note Via AJAX */
    if (note_id) {
        jQuery.ajax({
            url: 'update.php',
            type: 'post',
            data: {
                id: note_id,
                title: title,
                description: description,
            },
            success: function (response) {
                if (!isNaN(response)) {
                    jQuery('#list-notes-wrap').show()
                    jQuery('#add-note-wrap').hide()

                    jQuery('#note-' + note_id)
                        .find('.note-title')
                        .text(title)
                    jQuery('#note-' + note_id)
                        .find('.note-description')
                        .text(description)
                } else {
                    // show error if not deleted
                    console.log(response)
                }
                return true
            },
        })
    } else if (title == '') {
        jQuery('#title-warning').show()
        return false
    } else {
        /* When Inserting a Note Via AJAX */
        jQuery.ajax({
            url: 'insert.php',
            type: 'post',
            data: {
                title: title,
                description: description,
            },
            success: function (response) {
                // You will get response from your PHP page (what you echo or print)
                if (!isNaN(response)) {
                    var note_id = response
                    jQuery('#list-notes-body').append(
                        '<tr id=note-' +
                            note_id +
                            '>\
                        <th>' +
                            note_id +
                            '</th>\
                        <td class="note-title">' +
                            title +
                            '</td>\
                        <td class="note-description">' +
                            description +
                            '</td>\
                        <td> \
                            <a onclick="update_note(' +
                            note_id +
                            ')">\
                                <button class="btn btn-lg btn-primary">Update</button>\
                            </a>\
                            <a onclick="delete_note(' +
                            note_id +
                            ')">\
                                <button class="btn btn-lg btn-danger">Delete</button>\
                            </a>\
                        </td>\
                    </tr>'
                    )
                    jQuery('#list-notes-wrap').show()
                    jQuery('#add-note-wrap').hide()
                } else {
                    // show error if not deleted
                    console.log(response)
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('error in AJAX request: ' + errorThrown)
            },
        })
    }
}

function show_list_note() {
    jQuery('#list-notes-wrap').show()
    jQuery('#add-note-wrap').hide()
}

function show_insert_note() {
    // Empty the note id, title and desc before insert form display
    jQuery('#title').val('')
    jQuery('#description').val('')
    jQuery('#note_id').val('')

    jQuery('#list-notes-wrap').hide()
    jQuery('#title-warning').hide()
    jQuery('#add-note-wrap').show()
}

function delete_note(id) {
    jQuery.ajax({
        url: 'delete.php?delete_id=' + id,
        type: 'get',
        success: function (response) {
            // You will get response from your PHP page (what you echo or print)
            if (response == 1) {
                jQuery('#note-' + id).remove()
            } else {
                // show error if not deleted
                console.log(response)
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('error in AJAX request: ' + errorThrown)
        },
    })
}
