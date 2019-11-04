import styles from './style.css'

const Grid = (props) => {

    const Link = props.linkHref ? <a className={'page-title-action ' + styles.marginleft} href={props.linkHref}>{props.linkText}</a> : null;
    
    return (
        <div className={styles.grid}>
            {props.children}
        </div>
    )
}

export default Grid;