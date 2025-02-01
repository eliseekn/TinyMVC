document.addEventListener('DOMContentLoaded', () => {
    document
        .querySelectorAll('.spinner')
        ?.forEach(el => {
            el.addEventListener('click', event => {
                event.target.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span>'
            })
        })
})
