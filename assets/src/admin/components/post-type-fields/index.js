import { useSelector, useDispatch } from 'react-redux'
import { useEffect } from 'react'
import { getPostTypeFields, setPostTypeField, addPostTypeField, removePostTypeField, movePostTypeField, updatePostTypeFields } from '../../screens/distribution/redux/actions/postTypesActions'

import Card from '../card'
const { Button, ButtonGroup, TextControl, SelectControl, ToggleControl } = wp.components

import styles from './style.css'

const PostTypeFields = () => {

    const fieldsArray = useSelector(state => state.postTypes.modal.post_fields)
    const postTypeName = useSelector(state => state.postTypes.modal.post_type)
    const postType = useSelector(state => state.postTypes.post_types[postTypeName])
    const dispatch = useDispatch()

    const Fields = fieldsArray.map((field, index) => {

        if (field.is_meta === 'true') {
            field.is_meta = true
        } else if (field.is_meta === 'false') {
            field.is_meta = false
        }

        let isStart, isEnd = false

        if (index == 0) {
            isStart = true;
        }

        if (index == fieldsArray.length - 1) {
            isEnd = true;
        }

        return (
            <Card width={1}>
                <div className={styles.fieldactions}>
                    <div className={styles.fieldlabel}>{field.label}</div>
                    <ButtonGroup>
                        <Button disabled={isStart} isSmall onClick={ () => dispatch(movePostTypeField(index, index-1))}>
                            Up
                        </Button>
                        <Button disabled={isEnd} isSmall onClick={ () => dispatch(movePostTypeField(index, index+1))}>
                            Down
                        </Button>
                        <Button isSmall onClick={ () => dispatch(removePostTypeField(index))}>
                            Remove field
                        </Button>
                    </ButtonGroup>
                </div>
                <div className={styles.fieldrow}>
                    <div>
                    <TextControl 
                        label='Label'
                        value={field.label}
                        onChange={(val) => dispatch(setPostTypeField({
                            field_index: index, 
                            key: 'label', 
                            value: val
                        }))}
                    />
                    <SelectControl
                        label="Type"
                        value={ field.type }
                        onChange={(val) => dispatch(setPostTypeField({
                            field_index: index, 
                            key: 'type', 
                            value: val
                        }))}
                        options={ [
                            { label: 'Taxonomy', value: 'taxonomy' },
                            { label: 'Text', value: 'text' },
                            { label: 'Textarea', value: 'textarea' },
                            { label: 'Toggle', value: 'toggle' },
                            { label: 'Image', value: 'image' },
                            { label: 'Audio', value: 'audio' },
                            { label: 'Video', value: 'video' },
                            { label: 'Url', value: 'url' },
                        ] }
                    />
                    </div>
                    <div>
                        <TextControl 
                            label='Key'
                            value={field.key}
                            onChange={(val) => dispatch(setPostTypeField({
                                field_index: index, 
                                key: 'key', 
                                value: val
                            }))}
                        />
                        <TextControl 
                            label='Code'
                            value={field.eval}
                            onChange={(val) => dispatch(setPostTypeField({
                                field_index: index, 
                                key: 'eval', 
                                value: val
                            }))}
                        />
                        <ToggleControl
                            label="Is Meta Key"
                            checked={field.is_meta}
                            onChange={(val) => dispatch(setPostTypeField({
                                field_index: index, 
                                key: 'is_meta', 
                                value: val
                            }))}
                        />
                    </div>
                </div>
            </Card>
        )
    });

    useEffect(() => {
        dispatch(getPostTypeFields(postTypeName));        
    }, []);

    return (
        <div>
            {Fields}
            <div className={styles.fieldsfooter}>
                <Button isDefault onClick={ () => dispatch(addPostTypeField())}>
                    Add new field
                </Button>
                <Button isPrimary onClick={ () => dispatch(updatePostTypeFields(postTypeName, fieldsArray)) }>
                    {'Update ' + postType.labels.singular_name.toLowerCase() + ' type fields'}
                </Button>
            </div>
        </div>
    )
}

export default PostTypeFields;