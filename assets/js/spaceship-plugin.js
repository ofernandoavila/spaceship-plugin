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

const estrelas = document.querySelectorAll('.SSP_SpaceshipRating i.fa-star');
const input = document.getElementById('spaceship_plugin_dificuldade_value');

window.onload = () => {
    if(input) {
        SSP_SpaceshipRating_Picker_OnUpdateRating(input.value);
    }
}

estrelas.forEach( estrela => {
    estrela.addEventListener('mouseover', SSP_SpaceshipRating_Picker_OnHover);
    estrela.addEventListener('mouseout', SSP_SpaceshipRating_Picker_OnOut);
    estrela.addEventListener('click', SSP_SpaceshipRating_Picker_OnClick);
});

function SSP_SpaceshipRating_Picker_OnHover(estrela) {
    SSP_SpaceshipRating_Picker_OnUpdateRating(parseInt(estrela.target.getAttribute("data-value"), 10));
}

function SSP_SpaceshipRating_Picker_OnOut(estrela) {
    SSP_SpaceshipRating_Picker_OnUpdateRating(input.value);
}

function SSP_SpaceshipRating_Picker_OnClick(estrela) {
    input.value = parseInt(estrela.target.getAttribute("data-value"), 10);
}

function SSP_SpaceshipRating_Picker_OnUpdateRating(quantidade) {
    estrelas.forEach( estrela => {
        estrela.classList.add('fa-regular');
        estrela.classList.remove('fa');
    });

    for(let i = 0; i < quantidade; i++) {
        estrelas[i].classList.add('fa');
        estrelas[i].classList.remove('fa-regular');
    }
}