import { useSelector, useDispatch } from 'react-redux'
import { setLayout } from '../../screens/options/redux/actions/interfaceActions'

const { Button } = wp.components;

import styles from './style.css';

const ContentMenu = (props) => {

    const layouts = useSelector(state => state.interface.layouts)
    const activeLayout = useSelector(state => state.interface.active_layout)
    const dispatch = useDispatch()

    const menuItems = layouts.map((layout) => {
        let isActive = layout.slug == activeLayout ? true : false
        const attrs = {
            isPrimary: isActive,
            isTertiary: !isActive
        }
        return (
            <Button {...attrs} onClick={() => { dispatch(setLayout(layout.slug)) }}>{layout.label}</Button>
        )
    });

    return (
        <div className={styles.menu}>
            {menuItems}
        </div>
    )
}

export default ContentMenu;