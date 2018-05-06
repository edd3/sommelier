function logout() {
    $.post("/site/logout", function (data) {
        window.location.replace("/");
    });
}