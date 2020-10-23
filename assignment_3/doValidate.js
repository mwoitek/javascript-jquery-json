// Function for performing login data validation:
function doValidate() {
    try {
        // Get email and password:
        email = document.getElementById("email").value;
        pw = document.getElementById("pw").value;
        // Check if email and password were provided by the user:
        if (email == null || email == "" || pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
        // Check if the email contains an at-sign (@):
        if (email.indexOf("@") == -1) {
            alert("Invalid email address");
            return false;
        }
        return true;
    } catch (e) {
        return false;
    }
}
