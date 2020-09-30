maximum_number_entries = 9;

$(document).ready(
    function() {
        $('#addPos').click(
            function(event) {
                event.preventDefault();
                if ( count_pos >= maximum_number_entries ) {
                    alert('Maximum of ' + maximum_number_entries + ' position entries exceeded');
                    return;
                }
                count_pos++;
                $('#position_fields').append(
                    '<div id="position' + count_pos + '">\n'
                    + '<p>Year: <input type="text" name="year' + count_pos + '">\n'
                    + '<input type="button" value="-" '
                    + 'onclick="$(\'#position' + count_pos + '\').remove(); return false;"></p>\n'
                    + '<textarea name="desc' + count_pos + '" rows="8" cols="80"></textarea>\n</div>\n'
                );
            }
        );
    }
);
