import styles from './style.css'

const { Button } = wp.components

const Navigation = (props) => {
    
    return (
        <div className={styles.nav}>
            {props.children}
        </div>
    )
}

export default Navigation;