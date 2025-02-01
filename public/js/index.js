(()=>{document.addEventListener("DOMContentLoaded",()=>{document.querySelectorAll(".spinner")?.forEach(e=>{e.addEventListener("click",e=>{e.target.innerHTML='<span class="spinner-border spinner-border-sm" role="status"></span>'})})}),document.addEventListener("DOMContentLoaded",()=>{document.querySelector("#password-toggle")?.addEventListener("click",e=>{"password"===document.querySelector("#password").type?(document.querySelector("#password").type="text",e.target.innerHTML=`<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                        <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                        <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                    </svg>`):(document.querySelector("#password").type="password",e.target.innerHTML=`<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                      <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                      <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                    </svg>`)})});class e extends HTMLElement{constructor(){super(),this.icon=this.icon.bind(this)}icon(){switch(this.getAttribute("type")){case"primary":return'<i class="fa fs-4 fa-info-circle text-primary"></i>';case"danger":return'<i class="fa fs-4 fa-times-circle text-danger"></i>';case"warning":return'<i class="fa fs-4 fa-exclamation-triangle text-warning"></i>';default:return'<i class="fa fs-4 fa-check-circle text-success"></i>'}}connectedCallback(){let e=document.createElement("div");e.id="alert-toast",e.classList.add("fade"),e.innerHTML=`
            <div class="modal-dialog position-absolute shadow-sm rounded" style="top: -0.3em; right: .8em; z-index: 11111">
                <div class="modal-content">
                    <div class="modal-body d-flex justify-content-around align-items-center">
                        ${this.icon()}

                        <div class="d-flex flex-column px-2">
                            <p class="modal-title mb-0">${this.getAttribute("message")}</p>
                        </div>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        `,document.body.appendChild(e);let t=new bootstrap.Modal(e,{backdrop:!1,keyboard:!1});e.addEventListener("shown.bs.modal",()=>{window.setTimeout(()=>{t.hide()},3500)}),e.addEventListener("hidden.bs.modal",()=>{document.body.removeChild(e)}),t.show()}}window.customElements.define("alert-toast",e),window.addEventListener("beforeunload",()=>{document.body.className="page-loading"})})();
//# sourceMappingURL=index.js.map
