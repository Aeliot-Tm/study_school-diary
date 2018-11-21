if ("undefined" === typeof window.app) {
    var App = function () {
        this.modules = {};
    };
    App.prototype.addModule = function (name, callable) {

        if (this.modules[name]) {
            throw Error('Module ' + name + ' has initiated.');
        }

        this.modules[name] = callable;
    };

    window.app = new App();
}