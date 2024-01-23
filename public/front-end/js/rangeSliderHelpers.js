const getOptionsValues = (target) => {
    let valuesSet = new Set();
    document.querySelectorAll(`${target} option`).forEach((option) => {
        if (option.value != "") valuesSet.add(parseInt(option.value));
    });
    return Array.from(valuesSet);
};
const getValues = (target) => {
    let valuesSet = new Set();
    document.querySelectorAll(`${target} option`).forEach((option) => {
        if (option.value != "") valuesSet.add(parseInt(option.value));
    });
    return Array.from(valuesSet);
};
const changeSliderSelect = (values, slider, attributes) => {
    if (values == slider.state) return;
    slider.state = values;
    values = values.split(",");
    if (slider.selects.lowest.value != values[0]) {
        slider.selects.lowest.value = values[0];
        document.getElementById(slider.select2.lowest).innerHTML =
            values[0] + attributes.unit;
        removeLessValues(slider, attributes, false);
        // return;
    }
    if (slider.selects.highest.value != values[1]) {
        slider.selects.highest.value = values[1];
        document.getElementById(slider.select2.highest).innerHTML =
            values[1] + attributes.unit;
        removeHighestValues(slider, attributes, false);
        // return;
    }
};
const removeLessValues = (slider, attributes, isSelectInput = true) => {
    let min = parseInt(slider.selects.lowest.value);
    let currentValue = slider.selects.highest.value;
    returnToInitStatus(slider.values.highest, slider.selects.highest);
    document
        .querySelectorAll(`${attributes.selectIds.highest} option`)
        .forEach((option) => {
            if (parseInt(option.value) <= min) {
                option.remove();
            }
        });
    slider.selects.highest.value = currentValue;
    // if (isSelectInput)
    setSliderValues(slider);
};
const removeHighestValues = (slider, attributes, isSelectInput = true) => {
    let max = parseInt(slider.selects.highest.value);
    let currentValue = slider.selects.lowest.value;
    returnToInitStatus(slider.values.lowest, slider.selects.lowest);
    document
        .querySelectorAll(`${attributes.selectIds.lowest} option`)
        .forEach((option) => {
            if (parseInt(option.value) >= max) {
                option.remove();
            }
        });
    slider.selects.lowest.value = currentValue;
    // if (isSelectInput)
    setSliderValues(slider);
};
const returnToInitStatus = (values, element) => {
    element.innerHTML = "";
    values.forEach((value) => {
        let option = document.createElement("option");
        option.value = value;

        option.innerHTML =
            value.toLocaleString(undefined, {
                minimumFractionDigits: 2,
            }) + "ر.س";
        element.appendChild(option);
    });
};

const setSliderValues = (slider, reload = true) => {
    searchFormArray[slider.formKey] = [
        slider.selects.lowest.value,
        slider.selects.highest.value,
    ];
    slider.rangeSlider.setValues(
        parseInt(slider.selects.lowest.value),
        parseInt(slider.selects.highest.value)
    );
    if (reload) getAds();
};

const setSliderAttributes = (slider, values) => {
    slider.selects.lowest.value = values[0];
    slider.selects.highest.value = values[1];
    setSliderValues(slider, false);
};
