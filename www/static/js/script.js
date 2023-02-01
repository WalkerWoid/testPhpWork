class SendForm {
    constructor(formClass) {
        this.formClass = formClass
        this.form = ''
        this.submitBtn = ''
        this.inputName = ''
        this.inputEmail = ''
        this.inputSite = ''

        this.validation = new Validation()

        this.#formInit()
    }
    #formInit() {
        this.form = document.querySelector(`.${this.formClass}`)
        this.submitBtn = this.form.querySelector(`.submitForm`)
        this.inputName = this.form.querySelector('#name')
        this.inputEmail = this.form.querySelector('#mail')
        this.inputSite = this.form.querySelector('#site')

        this.#eventsHandler()
    }
    #eventsHandler() {
        this.submitBtn.addEventListener('click', () => this.#sendForm())
    }
    #sendForm() {
        this.validation.init();

        if (this.validation.validationForm() === false) {
            return console.log('form non valid')
        }

        const name = this.inputName.value
        const email = this.inputEmail.value
        const site = this.inputSite.value

        console.log('sendForm');
        fetch('http://localhost:8080/send', {
            method: 'POST',
            headers: new Headers({
                'content-type': 'application/json',
            }),
            body: JSON.stringify({
                name: name,
                email: email,
                site: site
            })
        })
            // .then(response => response.json())
            // .then(data => {
            //     console.log(data)
            // })
            .catch(error => {
                console.log(error)
            })
    }
}
class Validation {
    constructor() {
        this.inputClass = 'requiredInput'
        this.inputsRqwArr = []
        this.inputsArr = []
        this.validationInputs = [];
    }
    init() {
        this.inputsRqwArr = []
        this.inputsArr = []

        this.inputsRawArr = [...document.querySelectorAll(`.${this.inputClass}`)]
        this.inputsRawArr.forEach(el => {
            this.inputsArr.push(new RequiredInput(el))
        })

        console.log(this.inputsRawArr)
        console.log(this.inputsArr)
    }
    validationForm() {
        const nonValid = this.inputsArr.filter(el => {
            return el.isValid === false;
        });
        console.log('nonvalid')
        console.log(nonValid)

        return nonValid.length === 0;
    }
}
class RequiredInput {
    constructor(el) {
        this.incorrectClass = 'incorrect-input'
        this.el = el;

        this.input = ''
        this.value = ''
        this.name = ''

        this.isValid = false

        this.#init()
    }
    #init() {
        this.name = this.el.getAttribute('id')
        this.input = document.getElementById(`${this.name}`)
        this.value = this.input.value

        this.#setValid();
    }
    #setValid() {
        if (this.value) {
            this.input.classList.remove(`${this.incorrectClass}`)
            this.isValid = true
        }

        if (!this.value) {
            this.input.classList.add(`${this.incorrectClass}`)
            this.isValid = false
        }
    }
}
if(document.querySelector('.form')) {
    const sendForm = new SendForm('form')
}