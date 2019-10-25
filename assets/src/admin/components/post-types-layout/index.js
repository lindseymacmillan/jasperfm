import { useSelector, useDispatch } from 'react-redux'
import { useEffect, useState } from 'react'
import { openPostTypesModal, getPostTypes, createPostType, deletePostType } from '../../screens/distribution/redux/actions/postTypesActions'

const { Button, ButtonGroup, TextControl, Modal, ToggleControl } = wp.components
const { Fragment } = wp.element

import Navigation from '../navigation'
import Grid from '../grid'
import Card from '../card'
import PostTypesModal from '../post-types-modal'

import styles from './style.css'

const PostTypesLayout = () => {

    const postTypes = useSelector(state => state.postTypes.post_types)
    const dispatch = useDispatch()

    useEffect(() => {
        dispatch(getPostTypes());
    }, [])

    const [slug, setSlug] = useState('');
    const [singularName, setSingularName] = useState('');
    const [pluralName, setPluralName] = useState('');
    const [showAdvanced, setAdvanced] = useState(false);

    const cards = Object.entries(postTypes).map((postType, index) => {
        const canEdit = postType[1].name.includes('jasperfm_')
        return (
            <Card key={index} width={1}>
                <h1>{postType[1].labels.singular_name}</h1>
                <p>{postType[1].labels.plural_name}</p>
                <div className={styles.typeactions}>
                    {canEdit ? (
                        <Fragment>
                            <ButtonGroup>
                                <Button isPrimary onClick={() => dispatch(openPostTypesModal('settings', postType[1].name))}>Settings</Button>
                                <Button isDefault onClick={() => dispatch(openPostTypesModal('fields', postType[1].name))}>Fields</Button>
                            </ButtonGroup>
                            <Button isDestructive onClick={() => dispatch(openPostTypesModal('delete', postType[1].name))}>Delete</Button>
                        </Fragment>
                    ) : (
                        <Button isDefault onClick={() => dispatch(openPostTypesModal('fields', postType[1].name))}>Fields</Button>
                    )}
                </div>
            </Card>
        )
    })

    return (
        <Fragment>
            <PostTypesModal />
            <Navigation>
                <h1>Post Types</h1>
                <Button isPrimary isLarge onClick={ () => dispatch(openPostTypesModal('new')) }>New Post Type</Button>
            </Navigation>
            <Grid>
                {cards}
            </Grid>
        </Fragment>
    )
}

export default PostTypesLayout