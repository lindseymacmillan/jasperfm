import React from 'react'
import { useSelector, useDispatch } from 'react-redux'

const { Button } = wp.components
import styles from './style.css'

const Distribution = () => {

    const dispatch = useDispatch()

    return (
        <div className='wrap'>
            <h2>Distribution</h2>
        </div>
    )
}

export default Distribution