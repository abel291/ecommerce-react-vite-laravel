
import { Head, Link, useForm } from '@inertiajs/react'
import React from 'react'
import CardPost from './CardPost'

import Pagination from '@/Components/Pagination'

import LayoutBlog from '@/Layouts/LayoutBlog'
import SectionList from "@/Components/Sections/SectionList"

export default function Blog({ posts }) {

	return (
		<LayoutBlog>
			<Head title="Blog" />
			<SectionList title="Desde el blog" entry="Este es el blog donde encontrarás todo lo que necesitas para cuidar y mejorar tu computadora!" />
			{posts.data.length ? (
				<>
					<div className="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-12 lg:max-w-none lg:grid-cols-2">
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
