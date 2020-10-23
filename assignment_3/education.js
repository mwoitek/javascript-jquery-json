maximum_number_edu = 9;

function create_array_used_edu() {
    var i;
    var used_edu = [];
    for (i = 1; i <= count_edu; i++) {
        used_edu.push(i);
    }
    return used_edu;
}

function create_array_unused_edu() {
    var i;
    var unused_edu = [];
    for (i = maximum_number_edu; i > count_edu; i--) {
        unused_edu.push(i);
    }
    return unused_edu;
}

used_edu = create_array_used_edu();
unused_edu = create_array_unused_edu();

function cant_add_edu() {
    if (unused_edu.length == 0) {
        alert("Maximum of " + maximum_number_edu + " education entries exceeded");
        return true;
    }
    return false;
}

function print_used_edu() {
    var i;
    var number_used_edu = used_edu.length;
    var string_used_edu = "";
    if (number_used_edu > 0) {
        for (i = 0; i < number_used_edu - 1; i++) {
            string_used_edu += used_edu[i] + ",";
        }
        string_used_edu += used_edu[number_used_edu - 1];
    }
    return string_used_edu;
}

$("#used_edu").val(print_used_edu());

function remove_edu(edu) {
    $("#edu" + edu).remove();
    used_edu.splice(used_edu.indexOf(edu), 1);
    $("#used_edu").val(print_used_edu());
    unused_edu.push(edu);
}

function print_edu_div(edu) {
    var div_string = '<div id="edu' + edu + '">\n';
    div_string += '<p>Year: <input type="text" name="edu_year' + edu + '">\n';
    div_string +=
        '<input type="button" value="-" onclick="remove_edu(' +
        edu +
        '); return false;"></p>\n';
    div_string +=
        '<p>School: <input type="text" name="edu_school' +
        edu +
        '" size="80" class="school"></p>\n</div>\n';
    return div_string;
}

function add_edu() {
    var edu = unused_edu.pop();
    $("#edu_fields").append(print_edu_div(edu));
    used_edu.push(edu);
    $("#used_edu").val(print_used_edu());
}

$(document).ready(function () {
    $("#add_edu").click(function (event) {
        event.preventDefault();
        if (cant_add_edu()) {
            return;
        }
        add_edu();
    });
});

$(".school").autocomplete({
    source: "school.php",
});
