import styles from './style.css'

const { Button } = wp.components

const Header = (props) => {

    const Link = props.linkHref != 'none' ? <a className={'page-title-action ' + styles.marginleft} href={props.linkHref}>{props.linkText}</a> : null;
    
    return (
        <div className={styles.header}>
            <div>
                <h1 className='wp-heading-inline'>{props.title}</h1>
                { Link }
            </div>
            {props.children}
        </div>
    )
}

export default Header;