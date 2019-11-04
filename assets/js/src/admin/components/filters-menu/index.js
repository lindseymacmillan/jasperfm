import { useSelector, useDispatch } from 'react-redux'
import { setActiveFilter } from '../../screens/dashboard/redux/actions'

const { Button, Icon } = wp.components;
import styles from './style.css'

const FiltersMenu = () => {

    const filtersArray = useSelector(state => state.interface.filters)
    const activeFilter = useSelector(state => state.interface.active_filter)

    console.log(activeFilter)

    const Filters = filtersArray.map((filter) => {

        let isActive = filter.post_type == activeFilter ? true : false
        const dispatch = useDispatch()

        const attrs = {
            isPrimary: isActive,
            isDefault: !isActive
        }

        return (
            <Button {...attrs} className={styles.button} onClick={() => dispatch(setActiveFilter(filter.post_type))}>{filter.label}</Button>
        )
    });

    return (
        <div className={styles.menu}>
            {Filters}
            <Button isTertiary className={styles.iconButton}>
                <Icon icon="grid-view" />
            </Button>
            <Button isTertiary className={styles.iconButton}>
                <Icon icon="excerpt-view" />
            </Button>
            <Button isTertiary className={styles.iconButton}>
                <Icon icon="calendar-alt" />
            </Button>
        </div>
    )
}

export default FiltersMenu;