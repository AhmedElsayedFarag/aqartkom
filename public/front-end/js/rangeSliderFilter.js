const priceSliderAttributes = {
    selectIds: {
        lowest: "#lowestPrice",
        highest: "#highestPrice",
    },
    optionClass: ".priceSelect",
    sliderTarget: "#priceSlider",
    unit: "ر.س",
};
const pricesSlider = {
    values: {
        lowest: getValues(priceSliderAttributes.selectIds.lowest),
        highest: getValues(priceSliderAttributes.selectIds.highest),
        all: getOptionsValues(priceSliderAttributes.optionClass),
    },
    selects: {
        lowest: document.querySelector(priceSliderAttributes.selectIds.lowest),
        highest: document.querySelector(
            priceSliderAttributes.selectIds.highest
        ),
    },
    state: null,
    select2: {
        lowest: "select2-lowestPrice-container",
        highest: "select2-highestPrice-container",
    },
    formKey: "prices",
};
pricesSlider.selects.lowest.value = pricesSlider.values.all[0];
pricesSlider.selects.highest.value =
    pricesSlider.values.all[pricesSlider.values.all.length - 1];
pricesSlider.state =
    pricesSlider.selects.lowest.value +
    "," +
    pricesSlider.selects.highest.value;
pricesSlider.rangeSlider = new rSlider({
    target: priceSliderAttributes.sliderTarget,
    values: pricesSlider.values.all,
    range: true,
    tooltip: true,
    scale: true,
    labels: true,
    set: pricesSlider.state.split(","),
    onChange: (values) => {
        changeSliderSelect(values, pricesSlider, priceSliderAttributes);
    },
});

const areaSliderAttributes = {
    selectIds: {
        lowest: "#lowestArea",
        highest: "#highestArea",
    },
    optionClass: ".areaSelect",
    sliderTarget: "#areaSlider",
    unit: "ر.س",
};
const areaSlider = {
    values: {
        lowest: getValues(areaSliderAttributes.selectIds.lowest),
        highest: getValues(areaSliderAttributes.selectIds.highest),
        all: getOptionsValues(areaSliderAttributes.optionClass),
    },
    selects: {
        lowest: document.querySelector(areaSliderAttributes.selectIds.lowest),
        highest: document.querySelector(areaSliderAttributes.selectIds.highest),
    },
    state: null,
    select2: {
        lowest: "select2-lowestArea-container",
        highest: "select2-highestArea-container",
    },
    formKey: "area",
};
areaSlider.selects.lowest.value = areaSlider.values.all[0];
areaSlider.selects.highest.value =
    areaSlider.values.all[areaSlider.values.all.length - 1];
areaSlider.state =
    areaSlider.selects.lowest.value + "," + areaSlider.selects.highest.value;
areaSlider.rangeSlider = new rSlider({
    target: areaSliderAttributes.sliderTarget,
    values: areaSlider.values.all,
    range: true,
    tooltip: true,
    scale: true,
    labels: true,
    set: areaSlider.state.split(","),
    onChange: (values) => {
        changeSliderSelect(values, areaSlider, areaSliderAttributes);
    },
});
