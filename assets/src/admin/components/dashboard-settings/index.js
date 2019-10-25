import { useSelector, useDispatch } from 'react-redux'
import { useState, useEffect } from 'react'

import { updateDashboard } from '../../screens/options/redux/actions/dashboardsActions'

import styles from './style.css'

const { Button, TextControl, TextareaControl, ToggleControl, ColorPicker } = wp.components
const { Fragment } = wp.element

import ContentSelector from '../content-selector'

const DashboardSettings = (props) => {

    const dashboard = props.dashboard
    const postTypes = props.postTypes

    if (dashboard.dashboard_settings.supported_post_types == null) {
        dashboard.dashboard_settings.supported_post_types = [];
    }

    const [name, setName] = useState(dashboard.name)
    const [description, setDescription] = useState(dashboard.description)
    const [color, setColor] = useState('#333333')
    const [supportedPostTypes, setSupportedPostTypes] = useState(dashboard.dashboard_settings.supported_post_types)
    const [linkedContent, setLinkedContent] = useState(dashboard.dashboard_settings.linked_content)

    const dispatch =  useDispatch()

    const postTypeControls = Object.entries(postTypes).map((postType, index) => {
        postType = postType[1]
        const isChecked = supportedPostTypes.includes(postType.name)

        return (
            <ToggleControl
                className={styles.toggle}
                label={postType.labels.name}
                checked={ isChecked }
                onChange={ () => {
                    const supported = supportedPostTypes.slice(0)
                    if (isChecked) {
                        const index = supported.indexOf(postType.name)
                        supported.splice(index, 1)
                    } else {
                        supported.push(postType.name)
                    }
                    setSupportedPostTypes(supported)
                } }
            />
        )
    })

    const selectLinkedContent = (val) => {
        console.log('linked!', val)
        setLinkedContent(val)
    }

    return (
        <Fragment>
            <div className={styles.fieldrow}>
                <div>
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
                    <ContentSelector label='Linked content' value={linkedContent} onSelect={(val) => selectLinkedContent(val)}/>
                </div>
                <div>
                    <p>Supported Content</p>
                    <div className={styles.supported}>
                        {postTypeControls}
                    </div>
                </div>
            </div>
            <div className={styles.actions}>
                <Button isPrimary onClick={() => dispatch(updateDashboard(dashboard.term_id, {name, description, supportedPostTypes, linkedContent}))}>Update</Button>
            </div>
        </Fragment>
    )
}

export default DashboardSettings;