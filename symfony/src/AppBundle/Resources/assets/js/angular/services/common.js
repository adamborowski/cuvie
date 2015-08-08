app.service('common', function () {
    this.myUtils = function () {
        alert("my util works");
        if (0) {
            common.myUtils();
        }
    }
});