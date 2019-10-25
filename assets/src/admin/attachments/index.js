(function () {

    window.addEventListener('load', function () {
        addListeners();
    });

    function addListeners() {
        window.addEventListener('click', checkModal);
    }

    function checkModal () {
        const modal = document.querySelector('.media-modal.wp-core-ui');
        if (modal != null) {
            const visible = window.getComputedStyle(modal.parentElement).display === "none" ? false : true;
            const details = modal.querySelector('.attachment-details') === null ? false : true;
            const isSidebar = modal.querySelector('.media-sidebar') === null ? false : true;
            const isAudio = document.querySelector('#audioByline') === null ? false : true;
            if (visible && details) {
                modifyModal(modal, isSidebar, isAudio);
            }
        }
    }

    function modifyModal(modal, isSidebar, isAudio) {
        console.log('modify this modal!', isSidebar, isAudio);

        const details = modal.querySelector('.attachment-details');
        if (details.getAttribute('data-modified') === 'true') {
            return;
        }

        if (isAudio) {
            const settings = modal.querySelectorAll('.setting');
            [...settings].forEach((setting) => {
                if (setting.getAttribute('data-setting') != 'title') {
                    setting.setAttribute('style', 'display: none');
                }
            });
            const required = modal.querySelector('.media-types.media-types-required-info');
            required.setAttribute('style', 'display: none');
        }

        if (isSidebar === true) {
            console.log('is sidebar!');
            modal.querySelector('.thumbnail.thumbnail-audio').remove();
        } else {
            const info = details.querySelector('.attachment-info');
            const specs = info.querySelector('.details').cloneNode(true);
            info.querySelector('.details').remove();
            info.insertBefore(specs, info.querySelector('.actions'));
        }

        details.setAttribute('data-modified', 'true');

    }

})();