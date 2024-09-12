
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'mdb-ui-kit';

(function() {
    "use strict";


    /**
     * Easy selector helper function
     */
    const select = (el, all = false) => {
        el = el.trim()
        if (all) {
            return [...document.querySelectorAll(el)]
        } else {
            return document.querySelector(el)
        }
    }

    /**
     * Easy event listener function
     */
    const on = (type, el, listener, all = false) => {
        if (all) {
            select(el, all).forEach(e => e.addEventListener(type, listener))
        } else {
            select(el, all).addEventListener(type, listener)
        }
    }

    /**
     * Easy on scroll event listener
     */
    const onscroll = (el, listener) => {
        el.addEventListener('scroll', listener)
    }

    /**
     * Sidebar toggle
     */
    if (select('.toggle-sidebar-btn')) {
        on('click', '.toggle-sidebar-btn', function(e) {
            select('body').classList.toggle('toggle-sidebar')
        })
    }

    /**
     * Search bar toggle
     */
    if (select('.search-bar-toggle')) {
        on('click', '.search-bar-toggle', function(e) {
            select('.search-bar').classList.toggle('search-bar-show')
        })
    }

    /**
     * Navbar links active state on scroll
     */
    let navbarlinks = select('#navbar .scrollto', true)
    const navbarlinksActive = () => {
        let position = window.scrollY + 200
        navbarlinks.forEach(navbarlink => {
            if (!navbarlink.hash) return
            let section = select(navbarlink.hash)
            if (!section) return
            if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
                navbarlink.classList.add('active')
            } else {
                navbarlink.classList.remove('active')
            }
        })
    }
    window.addEventListener('load', navbarlinksActive)
    onscroll(document, navbarlinksActive)

    /**
     * Toggle .header-scrolled class to #header when page is scrolled
     */
    let selectHeader = select('#header')
    if (selectHeader) {
        const headerScrolled = () => {
            if (window.scrollY > 100) {
                selectHeader.classList.add('header-scrolled')
            } else {
                selectHeader.classList.remove('header-scrolled')
            }
        }
        window.addEventListener('load', headerScrolled)
        onscroll(document, headerScrolled)
    }

    /**
     * Back to top button
     */
    let backtotop = select('.back-to-top')
    if (backtotop) {
        const toggleBacktotop = () => {
            if (window.scrollY > 100) {
                backtotop.classList.add('active')
            } else {
                backtotop.classList.remove('active')
            }
        }
        window.addEventListener('load', toggleBacktotop)
        onscroll(document, toggleBacktotop)
    }

    /**
     * Initiate tooltips
     */
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    /**
     * Initiate quill editors
     */
    if (select('.quill-editor-default')) {
        new Quill('.quill-editor-default', {
            theme: 'snow'
        });
    }

    if (select('.quill-editor-bubble')) {
        new Quill('.quill-editor-bubble', {
            theme: 'bubble'
        });
    }

    if (select('.quill-editor-full')) {
        new Quill(".quill-editor-full", {
            modules: {
                toolbar: [
                    [{
                        font: []
                    }, {
                        size: []
                    }],
                    ["bold", "italic", "underline", "strike"],
                    [{
                        color: []
                    },
                        {
                            background: []
                        }
                    ],
                    [{
                        script: "super"
                    },
                        {
                            script: "sub"
                        }
                    ],
                    [{
                        list: "ordered"
                    },
                        {
                            list: "bullet"
                        },
                        {
                            indent: "-1"
                        },
                        {
                            indent: "+1"
                        }
                    ],
                    ["direction", {
                        align: []
                    }],
                    ["link", "image", "video"],
                    ["clean"]
                ]
            },
            theme: "snow"
        });
    }

    /**
     * Initiate TinyMCE Editor
     */

    const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;

    tinymce.init({
        selector: 'textarea.tinymce-editor',
        plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion',
        editimage_cors_hosts: ['picsum.photos'],
        menubar: 'file edit view insert format tools table help',
        toolbar: "undo redo | accordion accordionremove | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | save print | pagebreak anchor codesample | ltr rtl",
        autosave_ask_before_unload: true,
        autosave_interval: '30s',
        autosave_prefix: '{path}{query}-{id}-',
        autosave_restore_when_empty: false,
        autosave_retention: '2m',
        image_advtab: true,
        link_list: [{
            title: 'My page 1',
            value: 'https://www.tiny.cloud'
        },
            {
                title: 'My page 2',
                value: 'http://www.moxiecode.com'
            }
        ],
        image_list: [{
            title: 'My page 1',
            value: 'https://www.tiny.cloud'
        },
            {
                title: 'My page 2',
                value: 'http://www.moxiecode.com'
            }
        ],
        image_class_list: [{
            title: 'None',
            value: ''
        },
            {
                title: 'Some class',
                value: 'class-name'
            }
        ],
        importcss_append: true,
        file_picker_callback: (callback, value, meta) => {
            /* Provide file and text for the link dialog */
            if (meta.filetype === 'file') {
                callback('https://www.google.com/logos/google.jpg', {
                    text: 'My text'
                });
            }

            /* Provide image and alt text for the image dialog */
            if (meta.filetype === 'image') {
                callback('https://www.google.com/logos/google.jpg', {
                    alt: 'My alt text'
                });
            }

            /* Provide alternative source and posted for the media dialog */
            if (meta.filetype === 'media') {
                callback('movie.mp4', {
                    source2: 'alt.ogg',
                    poster: 'https://www.google.com/logos/google.jpg'
                });
            }
        },
        height: 600,
        image_caption: true,
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
        noneditable_class: 'mceNonEditable',
        toolbar_mode: 'sliding',
        contextmenu: 'link image table',
        skin: useDarkMode ? 'oxide-dark' : 'oxide',
        content_css: useDarkMode ? 'dark' : 'default',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
    });

    /**
     * Initiate Bootstrap validation check
     */
    var needsValidation = document.querySelectorAll('.needs-validation')

    Array.prototype.slice.call(needsValidation)
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })

    /**
     * Initiate Datatables
     */
    const datatables = select('.datatable', true)
    datatables.forEach(datatable => {
        new simpleDatatables.DataTable(datatable, {
            perPageSelect: [5, 10, 15, ["All", -1]],
            columns: [{
                select: 2,
                sortSequence: ["desc", "asc"]
            },
                {
                    select: 3,
                    sortSequence: ["desc", "asc"]
                },
                {
                    select: 4,
                    sortSequence: ["desc", "asc"]
                },
                {
                    select: 5,
                    sortSequence: ["desc", "asc"]
                },
                {
                    select: 5,
                    cellClass: "green",
                    headerClass: "red"
                }
            ]
        });
    })

    /**
     * Autoresize echart charts
     */
    const mainContainer = select('#main');
    if (mainContainer) {
        setTimeout(() => {
            new ResizeObserver(function() {
                select('.echart', true).forEach(getEchart => {
                    echarts.getInstanceByDom(getEchart).resize();
                })
            }).observe(mainContainer);
        }, 200);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const openModalBtn = document.getElementById('open-modal-btn');
        const modal = document.getElementById('modal');
        const closeModalBtn = document.getElementById('close-modal-btn');

        // Open the modal
        if (openModalBtn) {
            openModalBtn.addEventListener('click', function () {
                modal.style.display = 'block';
            });
        }

        // Close the modal
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', function () {
                modal.style.display = 'none';
            });
        }

        // Close the modal if the user clicks outside of the modal content
        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });


    });
    document.addEventListener('DOMContentLoaded', function () {
        const openModalBtn = document.getElementById('open-modal-btn');
        const modal = document.getElementById('modal');
        const closeModalBtn = document.getElementById('close-modal-btn');

        // Open the modal
        if (openModalBtn) {
            openModalBtn.addEventListener('click', function () {
                modal.style.display = 'block';
            });
        }

        // Close the modal
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', function () {
                modal.style.display = 'none';
            });
        }

        // Close the modal if the user clicks outside of the modal content
        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });


    });

    document.addEventListener('DOMContentLoaded', function() {
        const yesVisit = document.getElementById('yesvi');
        const noVisit = document.getElementById('novi');
        const dateViContainer = document.getElementById('datevicontainer');
        const dateViInput = document.getElementById('datevi');

        const yesDis = document.getElementById('yesdis');
        const noDis = document.getElementById('nodis');
        const dateDisContainer = document.getElementById('datediscontainer');
        const dateDisInput = document.getElementById('datedis');

        function toggleDateInput() {
            if (noVisit.checked) {
                dateViContainer.style.display = 'none';
                dateViInput.removeAttribute('required');
            } else {
                dateViContainer.style.display = 'block';
                dateViInput.setAttribute('required', 'required');
            }
        }

        function toggleDateInput2() {
            if (noDis.checked) {
                dateDisContainer.style.display = 'none';
                dateDisInput.removeAttribute('required');
            } else {
                dateDisContainer.style.display = 'block';
                dateDisInput.setAttribute('required', 'required');
            }
        }

        yesVisit.addEventListener('change', toggleDateInput);
        noVisit.addEventListener('change', toggleDateInput);
        yesDis.addEventListener('change', toggleDateInput2);
        noDis.addEventListener('change', toggleDateInput2);

        toggleDateInput2();
        toggleDateInput(); // Initialize visibility on page load
    });

    // script.js

    let currentTab = 0;
    showTab(currentTab);

    function showTab(n) {
        const tabs = document.getElementsByClassName("tab");
        tabs[n].style.display = "block";

        document.getElementById("prevBtn").style.display = n === 0 ? "none" : "inline";
        document.getElementById("nextBtn").innerHTML = n === (tabs.length - 1) ? "Submit" : "Next";

        updateStepIndicator(n);
    }

    function nextPrev(n) {
        const tabs = document.getElementsByClassName("tab");

        if (n === 1 && !validateForm()) return false;

        tabs[currentTab].style.display = "none";
        currentTab += n;

        if (currentTab >= tabs.length) {
            document.getElementById("createForm").submit();
            return false;
        }

        showTab(currentTab);
    }

    function validateForm() {
        const inputs = document.getElementsByClassName("tab")[currentTab].getElementsByTagName("input");
        let valid = true;

        for (let i = 0; i < inputs.length; i++) {
            if (inputs[i].hasAttribute('required') && inputs[i].value === "") {
                inputs[i].className += " invalid";
                valid = false;
            }
            else {
                inputs[i].className = inputs[i].className.replace(" invalid", "");
            }
        }

        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }

        return valid;
    }

    function updateStepIndicator(n) {
        const steps = document.getElementsByClassName("step");
        for (let i = 0; i < steps.length; i++) {
            steps[i].className = steps[i].className.replace(" active", "");
        }
        steps[n].className += " active";
    }



})();

document.addEventListener('DOMContentLoaded', function() {
    // Get the form element
    const form = document.getElementById('myForm');

    // Add an event listener for the form submit event
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Perform the AJAX request or other actions here
        // For example, using Fetch API to submit the form
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Call your JavaScript function here
                    myFunction();
                } else {
                    // Handle form submission error
                    console.error('Form submission failed');
                }
            })
            .catch(error => {
                // Handle network error
                console.error('Network error:', error);
            });
    });
});

// Define your JavaScript function

