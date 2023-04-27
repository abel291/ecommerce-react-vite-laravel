
import { Head, Link, useForm } from '@inertiajs/react'
import React from 'react'
import CardPost from './CardPost'

import Pagination from '@/Components/Pagination'

import LayoutBlog from '@/Layouts/LayoutBlog'

export default function Blog({ categories_blog, posts, recent_post, filters }) {

	return (
		<LayoutBlog>
			<Head title="Blog" />
			{posts.data.length ? (
				<>
					<div className="grid  grid-cols-1 xl:grid-cols-2 gap-12 md:gap-8">
						{posts.data.map((post) => (
							<CardPost key={post.id} post={post} />
						))}
					</div>

					<div className="mt-8">
						<Pagination paginator={posts.meta} />
					</div>
				</>
			) : (
				<div className="text-center mt-10 durac">No se encontraron registros</div>
			)}
		</LayoutBlog>
	)
}
