const validationRegex = {
    email: /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
    phone: /^5(5|0|3|6|4|9|1|8|7)([0-9]{7})$/,
    password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,120}$/,
    name: /^[\u0621-\u064A\u0660-\u0669 ]+$/,
};

const isValidEmail = (email) => {
    return validationRegex.email.test(email);
};

const isValidPhone = (phone) => {
    return validationRegex.phone.test(phone);
};
const isValidName = (name) => {
    return validationRegex.name.test(name);
};

const isValidLength = (value, min, max) => {
    return value.length >= min && value.length <= max;
};

const isValidPassword = (password) => {
    return validationRegex.password.test(password);
};

const isSame = (password, confirmPassword) => {
    return password === confirmPassword;
};
const isValidAdvertisement = (advertisement) => {
    return /^[0-9]{3,120}$/.test(advertisement);
};
