document.addEventListener('DOMContentLoaded', function () {
    const streetInput = document.querySelector('input#announcement_street')

    let element = document.querySelector('input[type="tel"]');
    if (element) {
        let maskOptions = {
            mask: '+375 (00) 000-00-00',
        };
        IMask(element, maskOptions);
    }

    let elems = document.querySelectorAll('.sidenav');
    M.Sidenav.init(elems);

    M.Tabs.init(document.querySelectorAll('.tabs'));
    M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'));
    M.Modal.init(document.querySelectorAll('.modal'));
    M.FormSelect.init(document.querySelectorAll('select'));

    let carousel = document.querySelectorAll('.carousel');
    M.Carousel.init(carousel, {
        indicators: true
    });

    let streetInstance = M.Autocomplete.init(streetInput, {
        data: {}
    });

    M.CharacterCounter.init(document.querySelectorAll('.characterCounter'));

    let map = document.querySelector('#YMapsID')
    if (map) {
        if (map.clientWidth <= 550) {
            // map.style.height = map.clientWidth + 'px'
            map.style.height = '300px'
        } else {
            map.style.height = '550px'
        }
    }
    window.addEventListener(`resize`, event => {
        if (map) {
            if (map.clientWidth <= 550) {
                map.style.height = '300px'
                // map.style.height = map.clientWidth + 'px'
            } else {
                map.style.height = '550px'
            }
        }
    }, false);

    if (streetInput) {
        streetInput.addEventListener('input', (e) => {
            ymaps.suggest(`Беларусь, Минск, ${e.target.value}`, {results: 5}).then(function (items) {
                const newObj = Array.from(items, x => x.value)
                const streets = []
                const re = /(Беларусь, Минск, )|( улица )|( улица)|(улица )/g;
                for (let i = 0; i < newObj.length; i++) {
                    streets.push(newObj[i].replace(re, '').trim())
                }
                streetInstance.updateData(Object.assign(...streets.map((k, i) => ({
                    [k]: null
                }))));
            })
        })


        ymaps.ready(function () {
            let myMap = new ymaps.Map('YMapsID', {
                center: [53.9, 27.56],
                zoom: 11,
                controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
            });

            let myGeocoder = ymaps.geocode('Беларусь, Минск ')
            if (streetInput.value !== '') {
                myGeocoder = ymaps.geocode(`Беларусь, Минск,  ${streetInput.value}`)
                myGeocoder.then(function (res) {
                    myMap.geoObjects.add(res.geoObjects)
                })
            } else {
                myGeocoder.then(function (res) {
                    myMap.geoObjects.remove(res.geoObjects)
                });
            }

            streetInput.addEventListener('blur', (e) => {
                myGeocoder.then(function (res) {
                    myMap.geoObjects.remove(res.geoObjects)
                })

                if (e.target.value !== '') {

                    myGeocoder = ymaps.geocode(`Беларусь, Минск,  ${e.target.value}`, { results: 1 })

                    myGeocoder.then(function (res) {
                        myMap.geoObjects.add(res.geoObjects)
                    })
                }
            }, true)

            const dropdownEl = document.querySelector('ul.autocomplete-content.dropdown-content');
            dropdownEl.addEventListener('click', (e) => {
                const streetClick = e.target.textContent;

                myGeocoder.then(function (res) {
                    myMap.geoObjects.remove(res.geoObjects)
                })

                if (e.target.value !== '') {

                    myGeocoder = ymaps.geocode(`Беларусь, Минск,  ${streetClick}`, { results: 1 })

                    myGeocoder.then(function (res) {
                        myMap.geoObjects.add(res.geoObjects)
                    })
                }
            }, true)
        });
    }
});