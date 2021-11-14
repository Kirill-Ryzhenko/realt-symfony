alert('alert');

document.addEventListener('DOMContentLoaded', function () {
    const streetInput = document.querySelector('input#street')
    const pagination = document.querySelector('#pagination')
    const countOnPage = document.querySelector('#countOnPage')

    let element = document.querySelector('input[type="tel"]');
    if (element) {
        let maskOptions = {
            mask: '+375 (00) 000-00-00',
        };
        IMask(element, maskOptions);
    }

    M.Tabs.init(document.querySelectorAll('.tabs'));
    let drop = document.querySelectorAll('.dropdown-trigger');
    M.Dropdown.init(drop);

    M.Modal.init(document.querySelectorAll('.modal'));

    let selects = document.querySelectorAll('select');
    M.FormSelect.init(selects);

    let carousel = document.querySelectorAll('.carousel');
    M.Carousel.init(carousel, {
        fullWidth: true,
        indicators: true
    });


    let streetInstance = M.Autocomplete.init(streetInput, {
        data: {}
    });

});