
import { Head, Link, useForm } from '@inertiajs/react'
import React from 'react'
import CardPost from './CardPost'

import Pagination from '@/Components/Pagination'

import LayoutBlog from '@/Layouts/LayoutBlog'

export default function Blog({ posts }) {

	return (
		<LayoutBlog>
			<Head title="Blog" />
			<div className="pb-12 mb-12 border-b">
				<h2 className="text-3xl font-semibold tracking-tight text-gray-900 sm:text-4xl">
					Desde el blog
				</h2>
				<p className="mt-2 text-lg leading-8 text-gray-600">
					Este es el blog donde encontrarás todo lo que necesitas para cuidar y mejorar tu computadora!
				</p>
			</div>
			{posts.data.length ? (
				<>
					<div className="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2">
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
