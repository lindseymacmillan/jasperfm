import { useSelector, useDispatch } from 'react-redux'
import { closeDashboardsModal, deleteDashboard } from '../../screens/options/redux/actions/dashboardsActions'
const { Button, Modal } = wp.components
const { Fragment } = wp.element

import styles from './style.css'

import NewDashboard from '../dashboard-new'
import DashboardSettings from '../dashboard-settings'

const DashboardsModal = () => {

    const isOpen = useSelector(state => state.dashboards.modal.is_open)
    const mode = useSelector(state => state.dashboards.modal.mode)
    const dashboard = useSelector(state => state.dashboards.modal.dashboard)
    const postTypes = useSelector(state => state.postTypes.post_types)
    const dispatch = useDispatch()

    const SwitchModal = () => {
        switch (mode) {
            case 'new':
                return (
                    <Modal
                        title="New dashboard"
                        onRequestClose={ () => dispatch(closeDashboardsModal()) }>
                        <NewDashboard />
                    </Modal>
                )
                break;
            case 'settings':
                return (
                    <Modal
                        className={styles.settings}
                        title={dashboard.name + ' Settings'}
                        onRequestClose={ () => dispatch(closeDashboardsModal()) }>
                        <DashboardSettings dashboard={dashboard} postTypes={postTypes} />
                    </Modal>
                )
                break;
            case 'delete':
                return (
                    <Modal
                        title={'Delete ' + dashboard.name}
                        onRequestClose={ () => dispatch(closeDashboardsModal()) }>
                        <Button isPrimary onClick={ () => dispatch(deleteDashboard(dashboard.term_id)) }>
                            Delete
                        </Button>
                    </Modal>
                )
                break;
            default: 
                return (
                    <Modal
                        title="No action specified."
                        onRequestClose={ () => dispatch(closeDashboardsModal()) }>
                        <Button isDefault onClick={ () => dispatch(closeDashboardsModal()) }>
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

export default DashboardsModal;