export default {
    save(name, data) {
        return localStorage.setItem(name, JSON.stringify(data));
    },
    read(name) {
        return JSON.parse(localStorage.getItem(name));
    },
    remove(name) {
        return localStorage.removeItem(name);
    }
}