import { useSelector, useDispatch } from 'react-redux'
import { closeContentModal, deleteContent, toggleGoTo } from '../../screens/dashboard/redux/actions'
const { Button, Modal, ToggleControl } = wp.components
const { Fragment } = wp.element

import styles from './style.css'

import ContentFields from '../content-fields'

const ContentModal = () => {

    const isOpen = useSelector(state => state.interface.content_modal.isOpen)
    const goTo = useSelector(state => state.interface.content_modal.goTo)
    const postType = useSelector(state => state.interface.content_modal.post_type)
    const postID = useSelector(state => state.interface.content_modal.post_id)
    const mode = useSelector(state => state.interface.content_modal.mode)
    const dispatch = useDispatch()

    const SwitchModal = () => {
        switch (mode) {
            case 'new':
                return (
                    <Modal
                        title={'New'}
                        onRequestClose={ () => dispatch(closeContentModal()) }>
                        <ContentFields postType={postType} className={styles.contentfields}/>
                        <div className={styles.actions}>
                            <ToggleControl
                                className={styles.toggle}
                                label='Go to editor'
                                checked={goTo}
                                onChange={() => dispatch(toggleGoTo())}
                            />
                            <Button isPrimary>Create</Button>
                        </div>
                    </Modal>
                )
                break;
            case 'edit':
                return (
                    <Modal
                        className={styles.settings}
                        title={'Edit'}
                        onRequestClose={ () => dispatch(closeContentModal()) }>
                        <ContentFields postType={postType} postID={postID} />
                        <div className={styles.actions}>
                            <ToggleControl
                                className={styles.toggle}
                                label='Go to editor'
                            />
                            <Button isPrimary>Update</Button>
                        </div>
                    </Modal>
                )
                break;
            case 'delete':
                return (
                    <Modal
                        title={'Delete'}
                        onRequestClose={ () => dispatch(closeContentModal()) }>
                        <Button isPrimary>Delete</Button>
                    </Modal>
                )
                break;
            default: 
                return (
                    <Modal
                        title="No action specified."
                        onRequestClose={ () => dispatch(closeContentModal()) }>
                        <Button isDefault onClick={ () => dispatch(closeContentModal()) }>
                            Error
                        </Button>
                    </Modal>
                )
        }
    }

    return (
        <Fragment>
            {isOpen && (
                <SwitchModal />
            )}
        </Fragment>
    )
}

export default ContentModal;