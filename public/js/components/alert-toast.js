class AlertToast extends HTMLElement {
    constructor() {
        super()

        this.toastIcon = this.toastIcon.bind(this)
    }

    toastIcon() {
        switch(this.getAttribute('type')) {
            case 'primary':
                return '<i class="fa fa-info-circle text-primary fa-2x"></i>'
            case 'danger':
                return '<i class="fa fa-exclamation-circle text-danger fa-2x"></i>'
            case 'warning':
                return '<i class="fa fa-exclamation-triangle text-warning fa-2x"></i>'
            default:
                return '<i class="fa fa-check-circle text-success fa-2x"></i>'
        }
    }

    connectedCallback() {
        let element = document.createElement('div')
        element.id = 'alert-toast'
        element.setAttribute('tabindex', '-1')
        element.setAttribute('role', 'dialog')
        element.classList.add('fade')
        element.innerHTML = `
            <div class="modal-dialog position-absolute shadow rounded" style="top: 0; right: .8em">
                <div class="modal-content">
                    <div class="modal-body d-flex justify-content-around align-items-center">
                        ${this.toastIcon()}

                        <p class="modal-title mx-3">${this.getAttribute('message')}</p>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        `

        document.body.appendChild(element)

        $('#alert-toast').modal({
            backdrop: false,
            keyboard: false,
            show: true
        })

        $('#alert-toast').on('shown.bs.modal', function (e) {
            window.setTimeout(function () {
                $('#alert-toast').modal('hide');
            }, 3000)
        })
    }
}

window.customElements.define('alert-toast', AlertToast)