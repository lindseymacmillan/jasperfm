import React from 'react'
import ReactDOM from 'react-dom'

import Distribution from './root/Distribution'

import { createStore, combineReducers } from 'redux'
import { Provider } from 'react-redux'

import { store } from './redux/store'

ReactDOM.render(
    <Provider store={store}>
        <Distribution />
    </Provider>,
    document.getElementById('root')
);