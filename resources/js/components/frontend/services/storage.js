function save(name, data) {
    return localStorage.setItem(name, JSON.stringify(data));
}
function read(name) {
    return JSON.parse(localStorage.getItem(name));
}
function remove(name) {
    return localStorage.removeItem(name);
}