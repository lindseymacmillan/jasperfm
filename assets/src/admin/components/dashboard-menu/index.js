import { useSelector, useDispatch } from 'react-redux'

const { Button } = wp.components;

import styles from './style.css';

const DashboardMenu = (props) => {

    const dashboardFilters = useSelector(state => state.filters);

    return (
        <div className={styles.menu}>
            <Button isDefault className={styles.button}>Help</Button>
            <Button isPrimary className={styles.button}>Settings</Button>
        </div>
    )
}

export default DashboardMenu;