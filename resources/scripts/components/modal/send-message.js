class SendMessage extends HTMLElement {
    constructor() {
        super()

        this.users = []
        this.translations = {}
        this.getTranslations = this.getTranslations.bind(this)
        this.getUsers = this.getUsers.bind(this)
        this.showDialog = this.showDialog.bind(this)
        this.addEventListener('click', this.showDialog)
    }

    getUsers() {
        fetch('/tinymvc/api/users')
            .then(response => response.json())
            .then(data => this.users = data.users)
    }

    getTranslations() {
        fetch('/tinymvc/api/translations')
            .then(response => response.json())
            .then(data => this.translations = data.translations)
    }

    connectedCallback() {
        if (this.getAttribute('type') === 'icon') {
            this.innerHTML = `
                <a class="btn text-dark p-1" href="#" title="${this.getAttribute('title')}">
                    ${this.getAttribute('content')}
                </a>
            `
        } else {
            this.innerHTML = `
                <button class="btn btn-outline-dark mr-2">
                    ${this.getAttribute('content')}
                </button>
            `
        }

        this.getTranslations()
        this.getUsers()
    }

    showDialog() {
        let element = document.createElement('div')
        element.id = 'send-message'
        element.setAttribute('tabindex', '-1')
        element.setAttribute('role', 'dialog')
        element.classList.add('modal', 'fade')
        element.innerHTML = `
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light text-dark align-items-center py-2">
                        <h5 class="modal-title">${this.getAttribute('modal_title')}</h5>
                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>

                    <form method="post" action="${this.getAttribute('action')}">
                        ${this.getAttribute('csrf_token')}
                        
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient">${this.translations.user}</label>
                                <select id="recipient" name="recipient" class="custom-select">
                                    <option selected disabled>${this.translations.select_user}</option>

                                    ${
                                        this.users.map(user => {
                                            return `<option value="${user.id}" ${user.id == this.getAttribute('recipient') ? 'selected' : ''}>${user.email}</option>`
                                        })
                                    }
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="message">${this.translations.message}</label>
                                <textarea id="message" name="message" rows="3" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-dark loading">${this.translations.submit}</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">${this.translations.cancel}</button>
                        </div>
                    </form>
                </div>
            </div>
        `

        document.body.appendChild(element)

        $('#send-message').modal({
            backdrop: 'static',
            keyboard: false, 
            show: true
        })

        $('#send-message').on('hidden.bs.modal', function (e) {
            document.body.removeChild(element)
        })
    }
}

export default SendMessage