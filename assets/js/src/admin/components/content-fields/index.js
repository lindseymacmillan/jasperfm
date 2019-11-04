import { useSelector, useDispatch } from 'react-redux'
import { useState, useEffect } from 'react'
import { getContentFields, setContentField } from '../../screens/dashboard/redux/actions'

import styles from './style.css'

const { TextControl, TextareaControl, Button } = wp.components
const { Fragment } = wp.element

const ContentFields = (props) => {

    const postType = props.postType
    const postID = props.postID
    const fields = useSelector(state => state.interface.content_modal.content_fields)

    const dispatch = useDispatch()

    useEffect(() => {
        dispatch(getContentFields(postType, postID));        
    }, []);

    const Fields = fields.map((field, index) => {

        switch (field.type) {
            case 'text':
                return (
                    <TextControl
                        label={field.label}
                        value={field.value}
                        onChange={(val) => dispatch(setContentField({field_index: index, field_value: val}))}
                    />
                )
                break;
            case 'textarea':
                return (
                    <TextareaControl
                        label={field.label}
                        value={field.value}
                    />
                )
                break;
            default: 
                return (
                    <h3>Error loading field.</h3>
                )
        }
    })

    return (
        <div className={styles.fields}>
            {Fields}
        </div>
    )
}

export default ContentFields;