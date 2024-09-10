import { Head } from '@inertiajs/react'
import React from 'react'

const MetaTag = ({ metaTag }) => {
    return (
        <Head title={metaTag.meta_title}>
            <meta name="description" content={metaTag.meta_description} />
        </Head>
    )
}

export default MetaTag
