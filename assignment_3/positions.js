maximum_number_entries = 9;

function create_array_used_positions() {
    var i;
    var used_positions = [];
    for (i = 1; i <= count_pos; i++) {
        used_positions.push(i);
    }
    return used_positions;
}

function create_array_unused_positions() {
    var i;
    var unused_positions = [];
    for (i = maximum_number_entries; i > count_pos; i--) {
        unused_positions.push(i);
    }
    return unused_positions;
}

used_positions = create_array_used_positions();
unused_positions = create_array_unused_positions();

function cant_add_position() {
    if (unused_positions.length == 0) {
        alert('Maximum of ' + maximum_number_entries + ' position entries exceeded');
        return true;
    }
    return false;
}

function print_used_positions() {
    var i;
    var number_used_positions = used_positions.length;
    var string_used_positions = '';
    if (number_used_positions > 0) {
        for (i = 0; i < number_used_positions - 1; i++) {
            string_used_positions += used_positions[i] + ',';
        }
        string_used_positions += used_positions[number_used_positions - 1];
    }
    return string_used_positions;
}

$('#used_positions').val(print_used_positions());

function remove_position(pos) {
    $('#position' + pos).remove();
    used_positions.splice(used_positions.indexOf(pos), 1);
    $('#used_positions').val(print_used_positions());
    unused_positions.push(pos);
}

function print_position_div(pos) {
    var div_string = '<div id="position' + pos + '">\n';
    div_string += '<p>Year: <input type="text" name="year' + pos + '">\n';
    div_string += '<input type="button" value="-" onclick="remove_position(' + pos + '); return false;"></p>\n';
    div_string += '<textarea name="desc' + pos + '" rows="8" cols="80"></textarea>\n</div>\n';
    return div_string;
}

function add_position() {
    var pos = unused_positions.pop();
    $('#position_fields').append(print_position_div(pos));
    used_positions.push(pos);
    $('#used_positions').val(print_used_positions());
}

$(document).ready(
    function() {
        $('#add_pos').click(
            function(event) {
                event.preventDefault();
                if (cant_add_position()) {
                    return;
                }
                add_position();
            }
        );
    }
);
