import styles from './style.css'

const Card = (props) => {
    
    return (
        <div className={styles.card} style={{gridColumn: 'span ' + props.width}}>
            {props.children}
        </div>
    )
}

export default Card;