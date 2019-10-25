import { useState } from 'react'
import { useDispatch } from 'react-redux'

import { createDashboard } from '../../screens/options/redux/actions/dashboardsActions'
import styles from './style.css'

const { Button, TextControl, TextareaControl, ToggleControl } = wp.components
const { Fragment } = wp.element

const NewDashboard = () => {

    const [name, setName] = useState('')
    const [description, setDescription] = useState('')
    const [goTo, setGoTo] = useState(false)

    const dispatch = useDispatch()

    return (
        <Fragment>
            <TextControl
                label='Name'
                value={name}
                onChange={(val) => setName(val)}
                />
            <TextareaControl
                label='Description'
                value={description}
                onChange={(val) => setDescription(val)}
                />
            <div className={styles.actions}>
                <ToggleControl
                    className={styles.toggle}
                    label='Go to dashboard'
                    checked={goTo}
                    onChange={() => setGoTo(!goTo)}
                    />
                <Button isPrimary onClick={() => dispatch(createDashboard({name: name, description: description, goTo: goTo}))}>
                    Create
                </Button>
            </div>
        </Fragment>
    )
}

export default NewDashboard;