const key = document.getElementById('name')
const options = document.getElementById('options')


function filter (e) {
    let search = e.target.value
    let cards = document.querySelectorAll('.card')

    filterElements(search, cards)
    
}

function choice (e) {
    let option = e.target.value
    let cards = document.querySelectorAll('.card')

    filterElements(option, cards)

}

function filterElements (letters, elements) {
    if (letters.length > 2) {
        for (let i = 0; i < elements.length; i++) {
            if (elements[i].textContent.toLowerCase().includes(letters)) {
                elements[i].style.display = 'block'
            } else {
                elements[i].style.display = 'none'
            }
        }
    }
}

key.addEventListener('keyup', filter)
options.addEventListener('change', choice)