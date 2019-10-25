import { useSelector, useDispatch } from 'react-redux'
import { useState } from 'react'
import { createPostType } from '../../screens/distribution/redux/actions/postTypesActions'

import styles from './style.css'
const { Button, TextControl, ToggleControl } = wp.components
const { Fragment } = wp.element

const NewPostType = () => {

    const [name, setName] = useState('');
    const [pluralName, setPluralName] = useState('');
    const [inAdminMenu, setInAdminMenu] = useState(false);

    const args = {
        name: name.toLowerCase(),
        singular_name: name,
        plural_name: pluralName,
        in_admin_menu: inAdminMenu
    }

    const dispatch = useDispatch()

    return (
        <div>
            <TextControl 
                label="Name"
                value={name}
                onChange={(val) => setName(val)}
                />
            <TextControl 
                label="Plural Name"
                value={pluralName}
                onChange={(val) => setPluralName(val)}
                />
            <ToggleControl
                label="Show in admin menu"
                checked={inAdminMenu}
                onChange={() => setInAdminMenu(!inAdminMenu)}
                />
            <div className={styles.actions}>
                <Button isPrimary onClick={() => dispatch(createPostType(args))}>Create</Button>
            </div>
        </div>
    )
}

export default NewPostType;