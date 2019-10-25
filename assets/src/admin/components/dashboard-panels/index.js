import { useSelector, useDispatch } from 'react-redux'
import { openContentModal } from '../../screens/dashboard/redux/actions'

const { Fragment } = wp.element
const { Button } = wp.components

import Card from '../card'

import styles from './style.css'

const DashboardPanels = () => {
    const activeFilter = useSelector(state => state.interface.active_filter)
    const supportedTypes = useSelector(state => state.interface.supported_types)
    const linkText = useSelector(state => state.interface.linked_content.label)
    const linkHref = useSelector(state => state.interface.linked_content.href)
    const dispatch = useDispatch()

    const TypeButtons = supportedTypes.map((type) => {
        return (
            <Button isTertiary onClick={() => dispatch(openContentModal('new', {post_type: type.name}))}>Create {type.label}</Button>
        )
    });

    return (
        <Fragment>
            { activeFilter == 'any' ? (
                <Fragment>
                    <Card width={3}>
                        <div className={styles.introCard}>
                            <div>
                                <h3>Getting Started</h3>
                                <p>Jump into things by customizing the show, or creating new content.</p>
                                <Button isLarge isPrimary href={linkHref}>{linkText}</Button>
                            </div>
                            <div>
                                <h3>Create Content</h3>
                                <div className={styles.typeButtons}>
                                    {TypeButtons}
                                </div>
                            </div>
                        </div>
                    </Card>
                    <Card width={1}>
                        <h3>Dashboard Panel</h3>
                    </Card>
                </Fragment>
            ) : (
                <Card width={1}>
                    <h3>New {activeFilter}</h3>
                    <Button isPrimary onClick={() => dispatch(openContentModal('new', {post_type: activeFilter}))}>Create {activeFilter}</Button>
                </Card>
            )}
        </Fragment>
    )
}

export default DashboardPanels;