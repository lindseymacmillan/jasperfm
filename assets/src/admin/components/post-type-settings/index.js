import { useSelector, useDispatch } from 'react-redux'
import { useState } from 'react'
import { updatePostType } from '../../screens/distribution/redux/actions/postTypesActions'

import styles from './style.css'
const { Button, TextControl, ToggleControl } = wp.components
const { Fragment } = wp.element

const PostTypeSettings = () => {

    const postTypeName = useSelector(state => state.postTypes.modal.post_type)
    const postType = useSelector(state => state.postTypes.post_types[postTypeName])

    if (postType.show_in_menu == 'false') {
        postType.show_in_menu = false
    } else if (postType.show_in_menu == 'true') {
        postType.show_in_menu = true
    }

    const [name, setName] = useState(postType.labels.singular_name);
    const [pluralName, setPluralName] = useState(postType.labels.name);
    const [inAdminMenu, setInAdminMenu] = useState(postType.show_in_menu);

    const args = {
        name: postTypeName,
        singular_name: name,
        plural_name: pluralName,
        show_in_menu: inAdminMenu
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
                <Button isPrimary onClick={() => dispatch(updatePostType(args))}>Save</Button>
            </div>
        </div>
    )
}

export default PostTypeSettings;