    <script src="{{ asset('front-end/js/dynamicAttributes.js') }}"></script>
    <script>
        let oldCategory = "{{ old('estate.category') }}";
        @if (isset($model))
            let oldCity = "{{ $model->estate->city_id }}";
        @else
            let oldCity = "{{ old('estate.city') }}";
        @endif
        let oldIsBuilding = "{{ old('is_building') }}";
        @if (isset($model))
            let oldNeighborhood = "{{ $model->estate->neighborhood_id }}";
        @else
            let oldNeighborhood = "{{ old('estate.neighborhood') }}";
        @endif
        let categorySelect = document.getElementById('category-select');
        let citySelect = document.getElementById('city-select');
        let ageInput = document.getElementById('age-input');
        let bedroomInput = document.getElementById('bedroom-input');
        let furnitureInput = document.getElementById('furniture-input');
        let isBuildingInput = document.getElementById('is_building');
        if (oldCategory.length)
            getCategoryAttributes(oldCategory);

        if (oldCity.length)
            getCityNeighborhoods(oldCity)

        if (oldIsBuilding.length)
            checkIsBuilding(oldIsBuilding);

        categorySelect.onchange = event => {
            let selectedOption = categorySelect.selectedOptions[0];
            let isBuilding = parseInt(selectedOption.dataset.check);
            let categoryID = parseInt(selectedOption.value);
            isBuildingInput.value = isBuilding;
            getCategoryAttributes(categoryID);
            checkIsBuilding(isBuilding);
        }
        citySelect.onchange = event => {
            let selectedOption = citySelect.selectedOptions[0];
            let cityID = parseInt(selectedOption.value);
            getCityNeighborhoods(cityID);

        }

        function checkIsBuilding(isBuilding) {
            if (isBuilding) {
                ageInput.classList.remove('hidden');
                bedroomInput.classList.remove('hidden');
                furnitureInput.classList.remove('hidden');
            } else {
                ageInput.classList.add('hidden');
                bedroomInput.classList.add('hidden');
                furnitureInput.classList.add('hidden');
            }
        }

        function getCategoryAttributes(categoryID) {
            let attributesContainer = document.getElementById('details');
            fetch(`/api/v1/category/${categoryID}/attributes`)
                .then((response) => response.json())
                .then((data) => {
                    let attributes = data.data;
                    let attributeContent = '';
                    attributesContainer.innerHTML = '';
                    attributes.forEach((attribute, index) => {
                        attributeContent = '';
                        if (attribute.type == 'number')
                            attributeContent = generateNumberInput(attribute, index);
                        if (attribute.type == "string")
                            attributeContent = generateStringInput(attribute, index);
                        if (attribute.type == 'radio')
                            attributeContent = generateRadioInput(attribute, index);
                        if (attribute.type == "select")
                            attributeContent = generateSelectInput(attribute, index);
                        attributesContainer.innerHTML += attributeContent;
                    });
                })

        }



        function getCityNeighborhoods(cityID) {
            let neighborhoodContainer = document.getElementById('neighborhood');
            neighborhoodContainer.classList.remove('hidden');
            fetch(`/api/v1/city/${cityID}/neighborhood`)
                .then((response) => response.json())
                .then((data) => {
                    let attributes = data.data;
                    let options = '<option></option>';
                    attributes.forEach((attribute, index) => {
                        if (oldNeighborhood == attribute.id)
                            options += `<option value="${attribute.id}" selected>${attribute.name}</option>`;
                        else
                            options += `<option value="${attribute.id}">${attribute.name}</option>`;
                    });
                    neighborhoodContainer.innerHTML = ` <label for="neighborhood-select" class="form-label">الواجهة</label>
                        <select data-placeholder="اختر" name="estate[neighborhood]"
                            class="tom-select w-full" required> ${options} </select>`;
                })

        }
    </script>
