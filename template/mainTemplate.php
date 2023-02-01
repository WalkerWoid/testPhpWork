<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="/static/css/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            outline: 0;
            border: none;
            list-style-type: none;
            background-color: transparent;
            box-sizing: border-box;
            text-decoration: none;
            color: inherit;
        }
        .container {
            max-width: 980px;
            width: 100%;
            margin: 20px auto 0;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
        }

        nav {
            padding: 10px;
        }
        nav ul {
            display: flex;
            align-items: center;
        }
        nav a {
            display: inline-block;
            padding: 10px 20px;
            text-transform: uppercase;
            font-weight: 500;
            font-size: 13px;
            line-height: 100%;
            color: #303030;
        }
        nav a:hover {
            background-color: #303030;
            color: white;
        }
        header, footer {
            background-color: #F8F8F8;
            padding: 10px 10px;
        }
        header h1, footer, .list-container h2 {
            font-weight: 400;
            font-size: 36px;
            line-height: 100%;
            color: #303030;
            text-align: center;
        }
        .form {
            max-width: 100%;
            width: 100%;
            padding: 10px 10px 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        label {
            max-width: calc(33.333333% - 10px*2/3);
            width: 100%;
        }
        .form-input {
            display: inline-block;
            max-width: 100%;
            width: 100%;
            padding: 10px;
            border: 1px solid #303030;
            color: black;
        }
        .incorrect-input {
            border: 2px solid red;
        }
        .submitForm {
            text-align: center;
            margin-top: 10px;
            color: white;
            background-color: #303030;
            width: 200px;
            padding: 10px;
            cursor: pointer;
        }
        .list-container {
            padding: 10px 10px 0;
        }
        .list-container h2 {
            font-size: 20px;
            text-align: left;
            font-weight: bold;
        }
        .list {
            margin-top: 10px;
        }
        .list__user {
            color: #303030;
            font-size: 16px;
        }
        .list__user_span span {
            font-size: 20px;
            font-weight: bold;
        }
        footer {
            margin-top: 10px;
            font-size: 20px;
        }

        @media screen and (max-width: 980px) {
            body {
                padding: 0 20px;
            }
            header h1 {
                font-weight: 400;
                font-size: 20px;
                line-height: 100%;
                color: #303030;
                text-align: center;
            }
            .form {
                flex-direction: column;
            }
            label {
                max-width: 100%;
                margin-top: 10px;
                width: 100%;
            }
            label:first-of-type {
                margin-top: 0;
            }
            .list__user {
                border-bottom: 1px solid #303030;
                padding: 10px 0;
                display: flex;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <?=$nav?>
    <?=$header?>
    <?=$form?>
    <?=$footer?>
</div>

<script>
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
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                })
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
        }
        validationForm() {
            const nonValid = this.inputsArr.filter(el => {
                return el.isValid === false;
            });

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
</script>
</body>
</html>