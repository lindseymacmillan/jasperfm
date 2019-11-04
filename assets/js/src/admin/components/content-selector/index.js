import qs from 'qs';
import axios from 'axios';

import { useState, useEffect } from 'react'
const { SelectControl } = wp.components

const ContentSelector = (props) => {
    const [content, setContent] = useState([{label: 'None', value: 'none'}])
    const [selected, setSelected] = useState(props.value ? props.value : 'none')

    useEffect(() => {
        const request = axios.post(wpApiSettings.root + 'jasperfm/v1/content',
            qs.stringify({
                'action': 'content_selector_query',
                'payload': {
                    'query_type': 'any'
                }
            }),
            {headers: {'X-WP-Nonce': wpApiSettings.nonce} }
        )
        .then(function (response) {
            const options = content.slice(0)
            response.data.return.forEach((post) => {
                const option = {
                    label: post.post_title,
                    value: post.ID
                }
                options.push(option)
            })

            setContent(options)
        })
    }, [])

    return (
        <SelectControl
            label={props.label}       
            options={content}
            value={selected}
            onChange={(val) => {
                setSelected(val)
                props.onSelect(val)
            }}
        />
    )
}

export default ContentSelector;