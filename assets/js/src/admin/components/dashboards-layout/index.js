import { useSelector, useDispatch } from 'react-redux'
import { useState, useEffect } from 'react'
import { openDashboardsModal, closeDashboardsModal, deleteDashboard, getDashboards } from '../../screens/options/redux/actions/dashboardsActions'

const { Button, Modal, TextControl, TextareaControl, ToggleControl } = wp.components
const { Fragment } = wp.element

import Navigation from '../navigation'
import Grid from '../grid'
import Card from '../card'
import DashboardsModal from '../dashboards-modal'

import styles from './style.css'

const DashboardsLayout = () => {

    const newIsOpen = useSelector(state => state.dashboards.new_modal_is_open)
    const dashboards = useSelector(state => state.dashboards.dashboards)
    const dispatch = useDispatch()

    useEffect(() => {
        dispatch(getDashboards());
    }, [])

    const [name, setName] = useState('');
    const [description, setDescription] = useState('');

    const cards = dashboards.map((dashboard, index) =>
        <Card key={index} width={2}>
            <h1>{dashboard.name}</h1>
            <p>{dashboard.description}</p>
            <div className={styles.actions}>
                <Button isPrimary onClick={() => dispatch(openDashboardsModal('settings', dashboard))}>Settings</Button>
                <Button isDestructive onClick={() => dispatch(openDashboardsModal('delete', dashboard))}>Delete</Button>
            </div>
        </Card>
    )

    return (
        <Fragment>
            <DashboardsModal />
            <Navigation>
                <h1>Dashboards</h1>
                <Button isPrimary isLarge onClick={ () => dispatch(openDashboardsModal('new')) }>New Dashboard</Button>
            </Navigation>
            <Grid>
                {cards}
            </Grid>
        </Fragment>
    )
}

export default DashboardsLayout