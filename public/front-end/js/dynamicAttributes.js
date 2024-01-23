function generateRadioInput(attribute, index) {
    let options = "";
    attribute.values.forEach((value) => {
        options += `<option value="${value.id}">${value.name}</option>`;
    });
    return `<div class="mt-3">
                        <label for="city-select" class="form-label">${attribute.name}</label>
                        <input type="hidden" name="details[${index}][attribute]" value="${attribute.id}" />
                        <select data-placeholder="اختر" name="details[${index}][value]"
                            class="tom-select w-full"> ${options} </select>
                    </div>`;
}

function generateStringInput(attribute, index) {
    return `<div class="input-form ">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                            ${attribute.name}
                        </label>
                        <input type="hidden" name="details[${index}][attribute]" value="${attribute.id}" />
                        <input id="validation-form-1" type="text" name="details[${index}][value]" class="form-control"
                            placeholder="" min="1" required>
                    </div>
                    `;
}

function generateSelectInput(attribute, index) {
    let options = "";
    attribute.values.forEach((value) => {
        options += `<option value="${value.id}">${value.name}</option>`;
    });
    return `<div class="mt-3">
                        <label for="city-select" class="form-label">${attribute.name}</label>
                        <input type="hidden" name="details[${index}][attribute]" value="${attribute.id}" />
                        <select data-placeholder="اختر" name="details[${index}][value]"
                            class="tom-select w-full"> ${options} </select>
                    </div>`;
}

function generateNumberInput(attribute, index) {
    return `<div class="input-form ">
                        <label for="validation-form-1" class="form-label w-full flex flex-col sm:flex-row">
                            ${attribute.name}
                        </label>
                        <input type="hidden" name="details[${index}][attribute]" value="${attribute.id}" />
                        <input id="validation-form-1" type="number" name="details[${index}][value]" class="form-control"
                            placeholder="" min="1" required>
                    </div>
                    `;
}
