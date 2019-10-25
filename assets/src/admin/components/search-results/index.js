import { useSelector, useDispatch } from 'react-redux'
import { useEffect } from 'react'
const { Fragment } = wp.element
import { runQuery, openContentModal } from '../../screens/dashboard/redux/actions'

import Card from '../card'
const { Button } = wp.components

const SearchResults = () => {

    const queryFilter = useSelector(state => state.query.query_filter)
    const queryTerm = useSelector(state => state.query.query_term)
    const queryString = useSelector(state => state.query.query_string)
    const queryResults = useSelector(state => state.query.query_results)
    const dispatch = useDispatch()

    const Cards = queryResults.map((result) => {
        return (
            <Card width={1}>
                <h3>{result.post_title}</h3>
                <Button isPrimary onClick={() => dispatch(openContentModal('edit', {post_type: result.post_type, post_id: result.ID}))}>Edit</Button>
                <Button isDestructive onClick={() => dispatch(openContentModal('delete', {post_type: result.post_type, post_id: result.ID}))}>Delete</Button>
            </Card>
        )
    });

    useEffect(() => {
        dispatch(runQuery(queryTerm, queryFilter, queryString));        
    }, [queryTerm, queryFilter, queryString]);

    return (
        <Fragment>
            {Cards}
        </Fragment>
    )
}

export default SearchResults;