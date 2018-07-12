export default class Error {
    constructor() {
        this.errors = {};
    }

    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }

    has(field) {
        return this.errors.hasOwnProperty(field);
    }

    any() {
        return Object.keys(this.errors).length > 0;
    }

    clear(field) {
        delete this.errors[field];
    }

    record(errors) {
        this.errors = errors;
        console.log(this.errors)
    }
}