(function() {
    'use strict';

    const pageAlerts = document.querySelectorAll('.alert-pagegroup-container [role="alert"]');
    if (pageAlerts.length >= 1) {
        pageAlerts.forEach(function (element) {
            let severity = element.dataset.severity;
            if (severity !== 'danger') {
                setTimeout(function () {
                    let closebtn = element.querySelector('button[data-dismiss="alert"]');
                    if (closebtn) {
                        console.log('click');
                        closebtn.click();
                    }
                }, 5000);
            }
        });
    }

})();
