function SSP_SpaceshipPicker_ToggleList() {
    const colorList = document.querySelector('ul.spaceship-list');
    colorList.classList.toggle('inativo');
}

function SSP_SpaceshipPicker_OnItemSelect(id, description, value) {
    SSP_SpaceshipPicker_ToggleList();

    const select = document.querySelector('.spaceship-picker');

    select.querySelector('input[name="spaceship_plugin_value"]').value = id;
    select.querySelector('.spaceship-name').innerHTML = description;
    select.querySelector('.spaceship-color-sample').style.backgroundColor = value;
}