import { useSelector, useDispatch } from 'react-redux'
import { setQueryString, runQuery } from '../../screens/dashboard/redux/actions'

import styles from './style.css'
const { TextControl, Button } = wp.components;

const SearchBar = () => {

    const queryTerm = useSelector(state => state.query.query_term)
    const queryFilter = useSelector(state => state.query.query_filter)
    const queryString = useSelector(state => state.query.query_string)
    const dispatch = useDispatch()

    return (
        <div className={styles.searchBar}>
            <TextControl className={styles.searchInput} value={queryString} onChange={(val) => dispatch(setQueryString(val))} />
            <Button isDefault className={styles.button} onClick={() => dispatch(runQuery(queryTerm, queryFilter, queryString))}>Search</Button>
        </div>
    )
}

export default SearchBar;