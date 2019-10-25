import { useSelector, useDispatch } from 'react-redux'

const { Button, Icon, Modal } = wp.components;
const { Fragment } = wp.element;

import Navigation from '../navigation';
import Grid from '../grid';
import Card from '../card';
import DashboardsLayout from '../dashboards-layout'
import PostTypesLayout from '../post-types-layout'


import styles from './style.css';

const ContentLayout = (props) => {

    const dispatch = useDispatch()

    const activeLayout = useSelector(state => state.interface.active_layout);

    const GeneralLayout = () => {
        return (
            <Fragment>
                <Navigation>
                    <h1>General</h1>
                </Navigation>
                <Grid>
                    <Card width='2' />
                </Grid>
            </Fragment>
        )
    }

    const ContributorsLayout = () => {
        return (
            <Fragment>
                <Navigation>
                    <h1>Contributors</h1>
                </Navigation>
                <Grid>
                    <Card width='3' />
                </Grid>
            </Fragment>
        )
    }

    const BulkActionsLayout = () => {
        return (
            <Fragment>
                <Navigation>
                    <h1>Bulk Actions</h1>
                </Navigation>
                <Grid>
                    <Card width='1' />
                </Grid>
            </Fragment>
        )
    }

    const Layout = () => {

        switch (activeLayout) {
            case 'general':
                return <GeneralLayout />
            case 'dashboards':
                return <DashboardsLayout />
            case 'post_types':
                return <PostTypesLayout />
            case 'contributors':
                return <ContributorsLayout />
            case 'bulk_actions':
                return <BulkActionsLayout />
            default:
                return <GeneralLayout />
        }

        return layout;
    }

    return (
        <Layout />
    )
}

export default ContentLayout;