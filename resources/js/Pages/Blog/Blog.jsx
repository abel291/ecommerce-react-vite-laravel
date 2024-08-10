
import { Head, Link, useForm } from '@inertiajs/react'
import React from 'react'
import CardPost from './CardPost'

import Pagination from '@/Components/Pagination'

import LayoutBlog from '@/Layouts/LayoutBlog'
import SectionList from "@/Components/Sections/SectionList"
import BannerText from '@/Components/Carousel/BannerText'
import Breadcrumb from '@/Components/Breadcrumb'
import Hero from '@/Components/Hero/Hero'

export default function Blog({ posts, page }) {

    const breadcrumb = [
        {
            title: "Blog",
        }]
    return (
        <LayoutBlog breadcrumb={breadcrumb}>
            <Head title={page.meta_title} />
            {posts.data.length ? (
                <>
                    <div className="mx-auto grid max-w-xl grid-cols-1 gap-x-10 gap-y-14 lg:max-w-none lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-2">
                        {posts.data.map((post) => (
                            <CardPost key={post.id} post={post} />
                        ))}
                    </div>

                    <div className="mt-20">
                        <Pagination paginator={posts.meta} />
                    </div>
                </>
            ) : (
                <div className="text-center mt-10">No se encontraron registros</div>
            )}
        </LayoutBlog>
    )
}
