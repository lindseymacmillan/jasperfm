import React from 'react'
import ReactDOM from 'react-dom'

import Attachment from './root/Attachment'

import { createStore, combineReducers } from 'redux'
import { Provider } from 'react-redux'

import { store } from './redux/store'

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
            const isAudio = document.querySelector('#audioTitle') === null ? false : true;
            if (visible && isAudio) {
                modifyModal(modal);
            }
        }
    }

    function modifyModal(modal) {
        console.log('modify this modal!', modal);

        const details = modal.querySelector('.attachment-details');

        if (details.getAttribute('data-modified') === 'true') {
            return;
        }

        details.innerHTML = null;

        ReactDOM.render(
            <Provider store={store}>
                <Attachment />
            </Provider>,
            details
        );

        details.setAttribute('data-modified', 'true');


        // const info = modal.querySelector('.attachment-info');
        // const elements = document.createDocumentFragment();

        

        // const settings = info.querySelector('.settings').children;
        // [...settings].forEach((setting) => {
        //     if (setting.classList.contains('setting')) {
        //         setting.setAttribute('style', 'display: none');
        //     }
        // });

        // const required = info.querySelector('.media-types.media-types-required-info');
        // required.setAttribute('style', 'display: none');

        //settings.innerHTML = null;
        //settings.appendChild(meta);

    }

})();