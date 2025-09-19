(function($) {
    // Funcție utilitară pentru parsarea unei date în format YYYY-MM-DD
    function parseDate(str) {
        if (!str) return null;
        let parts = str.split("-");
        if (parts.length !== 3) return null;
        return new Date(parts[0], parts[1] - 1, parts[2]); // YYYY, MM-1, DD
    }

    // Afișează mesaj de eroare în #errorBox (toast stilizat)
    function showError(message) {
        let box = jQuery("#errorBox");
        box.stop(true, true).text(message).fadeIn();
        setTimeout(() => box.fadeOut(), 5000);
    }

    // ✅ Expunem global funcția validateDates, vizibilă pentru pluginEvents
    window.validateDates = function(e) {        
         let $row = jQuery(e.target).closest("tr");
        
          // Dynamically get the row prefix from the input id that triggered the event
    let inputId = jQuery(e.target).attr('id'); // e.g., "vehicle-0-start_date"
        console.log('id '+inputId);
    let prefix = inputId.split('-')[0]+'-'+inputId.split('-')[1];
        
    // Use the prefix to select the start and end inputs in the same row
    let startDate = parseDate($(`#${prefix}-start_date`).val());
    let endDate = parseDate($(`#${prefix}-end_date`).val());  
        if (startDate && endDate && startDate > endDate) {
           alert("⚠️ Atenție: Data Încărcare nu poate fi mai mare decât Data Descărcare.");
        }
    };

    // Inițializează click personalizat pentru linkuri
    function initCustomClick() {
        jQuery(document).off("click", ".custom-click").on("click", ".custom-click", function(e) {
            e.preventDefault();
            let url = jQuery(this).attr("href");
            let title = jQuery(this).text();

            jQuery("#modal").modal("show")
                .find("#modalContent")
                .load(url);

            jQuery("#modalTitle").text(title);
        });
    }

    // Inițializează popoverele Bootstrap 5
    function initPopovers() {
        document.querySelectorAll(".regno-popover").forEach(function(el) {
            let pop = new bootstrap.Popover(el, { trigger: "manual" });
            el._bsPopover = pop;

            el.addEventListener("mouseenter", function() {
                pop.show();
                fetch(el.getAttribute("data-url") + "?id=" + el.getAttribute("data-id"))
                    .then(r => r.text())
                    .then(data => {
                        let popInstance = bootstrap.Popover.getInstance(el);
                        if (popInstance && popInstance.tip) {
                            let body = popInstance.tip.querySelector(".popover-body");
                            if (body) body.innerHTML = data;
                        }
                    })
                    .catch(err => console.error("Popover AJAX error:", err));
            });

            el.addEventListener("mouseleave", function() {
                pop.hide();
            });
        });
    }
function initVehicleUI() {
    // Initialize Bootstrap popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function(el) {
        return new bootstrap.Popover(el);
    });

    // Example: reapply Select2 or any other dynamic plugin if needed
    // $('.select2').select2({ ... }); // if you use Select2 outside EditableColumn
}
    // Init pe încărcarea paginii
    jQuery(function() {
        initCustomClick();
        initPopovers();
        initVehicleUI();
    });

    // Re-init după PJAX
    jQuery(document).on("pjax:success", function() {
        initCustomClick();
        initPopovers();
    });
    // Re-initialize after every PJAX request
jQuery(document).on('pjax:end', function() {
    initVehicleUI();
});

})(jQuery);
