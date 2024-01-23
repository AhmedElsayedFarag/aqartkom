let sellBtn = document.getElementById("sellBtn");
let rentBtn = document.getElementById("rentBtn");
let nonFurnitureBtn = document.getElementById("nonFurnitureBtn");
let furnitureBtn = document.getElementById("furnitureBtn");
let city = document.getElementById("country");
let sortSelect = document.getElementById("order");
let neighborhoodSelect = document.getElementById("neighborhood");
const searchForm = {
    type: "",
    neighborhood: "",
    city: "",
    is_furniture: false,
    sort: "",
};
const searchFormArray = {
    category_array: [],
    prices: [],
    area: [],
    age: [],
    bedroom: [],
};
let ageButtons = document.querySelectorAll(".ageBtn");
ageButtons.forEach((btn) => {
    btn.addEventListener("click", changeAgeFilter);
});
const setFilters = () => {
    const searchParams = new URLSearchParams(decodeURI(location.search));
    for (const [key, value] of searchParams) {
        if (key.indexOf("[]") > -1) {
            searchFormArray[key.replace("[]", "")].push(parseInt(value));
        } else searchForm[key] = value;
    }
    setTypeFilter();
    setCategoryFilter();
    setFurnitureFilter();
    setAgeFilter();
    setBedroomFilter();
    if (searchForm.city != "") setNeighborhood();
    if (sortSelect) setOrder();
    setSliderAttributes(pricesSlider, searchFormArray.prices);
    setSliderAttributes(areaSlider, searchFormArray.area);
};
const isCompany = () => location.href.search("company") > -1;
const isMarketer = () => location.href.search("marketer") > -1;
if (isCompany()) {
    const pathSplit = location.pathname.split("/");
    searchForm.company = pathSplit[pathSplit.length - 1];
}
if (isMarketer()) {
    const pathSplit = location.pathname.split("/");
    searchForm.marketer = pathSplit[pathSplit.length - 1];
}
/* chnage functions section*/
const changeType = (type) => {
    searchForm.type = type;
    currentPage = 1;
    getAds(!isCompany());
};
const changeFurniture = (status) => {
    searchForm.is_furniture = !!status;

    setFurnitureFilter();
    currentPage = 1;
    getAds(!isCompany());
};
const changeArrayFilter = (arrayName, value) => {
    if (searchFormArray[arrayName].indexOf(value) > -1) {
        searchFormArray[arrayName] = searchFormArray[arrayName].filter(
            (item) => item != value
        );
    } else searchFormArray[arrayName].push(value);
    currentPage = 1;
    getAds(!isCompany());
};

function changeAgeFilter(event) {
    const buttonDataset = event.target.dataset;
    searchFormArray.age = [buttonDataset.min, buttonDataset.max];
    currentPage = 1;
    getAds(!isCompany());
}
const changeNeighborhood = () => {
    searchForm.neighborhood = neighborhoodSelect.value;
    searchForm.city = city.value;
    currentPage = 1;
    getAds(!isCompany());
};
const changeOrder = () => {
    searchForm.sort = sortSelect.value;
    currentPage = 1;
    getAds(!isCompany());
};

/*set functions section*/
const setTypeFilter = () => {
    if (searchForm.type == "sell") {
        sellBtn.checked = true;
        rentBtn.checked = false;
    } else if (searchForm.type == "rent") {
        rentBtn.checked = true;
        sellBtn.checked = false;
    }
};
const setCategoryFilter = () => {
    let categoryBtns = document.querySelectorAll(".categoryBtn");
    categoryBtns.forEach((btn) => {
        if (searchFormArray.category_array.indexOf(parseInt(btn.value)) > -1) {
            btn.checked = true;
        }
    });
};
const setFurnitureFilter = () => {
    if (searchForm.is_furniture) {
        furnitureBtn.checked = true;
        nonFurnitureBtn.checked = false;
    } else {
        nonFurnitureBtn.checked = true;
        furnitureBtn.checked = false;
    }
};
const setAgeFilter = () => {
    ageButtons.forEach((btn) => {
        if (
            searchFormArray.age[0] == btn.dataset.min &&
            searchFormArray.age[1] == btn.dataset.max
        ) {
            btn.checked = true;
        }
    });
};
const convertArraysToSearch = () => {
    let newSearchParams = new URLSearchParams();
    for (const [key, value] of Object.entries(searchFormArray)) {
        value.forEach((val) => {
            if (val) newSearchParams.append(`${key}[]`, val);
        });
    }
    for (const [key, value] of Object.entries(searchForm)) {
        if (typeof value == "string" && value.length)
            newSearchParams.append(`${key}`, value);
    }
    newSearchParams.append("is_furniture", searchForm.is_furniture);
    return newSearchParams.toString();
};
const getSearchParams = () => {
    let searchParamsObj = {};
    for (const [key, value] of Object.entries(searchFormArray)) {
        value.forEach((val) => {
            if (val) {
                if (!searchParamsObj[key]) searchParamsObj[key] = [];
                searchParamsObj[key].push(val);
            }
        });
    }
    console.log(Object.entries(searchForm));
    for (const [key, value] of Object.entries(searchForm)) {
        if (typeof (value + "") == "string" && (value + "").length)
            searchParamsObj[key] = value;
    }
    searchParamsObj.center = searchForm.center;
    searchParamsObj.second_point = searchForm.second_point;
    return searchParamsObj;
};
const setBedroomFilter = () => {
    let bedroomBtns = document.querySelectorAll(".bedroomBtn");
    bedroomBtns.forEach((btn) => {
        if (searchFormArray.bedroom.indexOf(parseInt(btn.value)) > -1) {
            btn.checked = true;
        }
    });
};
const setNeighborhood = () => {
    city.value = searchForm.city;

    // console.log(city.selectedOptions[0].dataset.lat);
    // console.log(city.selectedOptions[0].dataset.lng);
    getNeighborhoods();
};
const setOrder = () => {
    sortSelect.value = searchForm.sort;
};

/**/
const getNeighborhoods = () => {
    let cityId = city.value;
    changeCenter(
        parseFloat(city.selectedOptions[0].dataset.lat),
        parseFloat(city.selectedOptions[0].dataset.lng)
    );
    searchForm.city = cityId;
    getAds();
    // getDefaultCity(null, null, cityId);
    axios
        .get(`/api/v1/city/${cityId}/neighborhood`)
        .then((res) => res.data)
        .then((res) => {
            let neighborhoods = res.data;

            neighborhoodSelect.innerHTML = "";
            let option = document.createElement("option");
            option.value = " ";
            option.innerText = "اختر الحي";
            neighborhoodSelect.appendChild(option);
            neighborhoods.forEach((neighborhood) => {
                let option = document.createElement("option");
                option.value = neighborhood.id;
                option.innerText = neighborhood.name;
                neighborhoodSelect.appendChild(option);
            });
            if (searchForm.neighborhood != "")
                neighborhoodSelect.value = searchForm.neighborhood;
        });
};
setFilters();
