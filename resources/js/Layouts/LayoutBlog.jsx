import React from 'react'
import BannerWithTitle from '@/Components/Carousel/BannerWithTitle'
import Layout from '@/Layouts/Layout'
import Badge from '@/Components/Badge'
import TextInput from '@/Components/TextInput'
import PrimaryButton from '@/Components/PrimaryButton'
import { ServerStackIcon } from '@heroicons/react/24/outline'
import { MagnifyingGlassIcon } from '@heroicons/react/24/solid'
import { Link, useForm, usePage } from '@inertiajs/react'
import { useState } from 'react'
export default function LayoutBlog({ children }) {
	const { filters, categories_blog, recent_post } = usePage().props
	const { data, setData, get, processing } = useForm({
		q: filters?.q || ''
	})



	const handleSubmit = (e) => {
		e.preventDefault()
		get(route('blog'), {
			preserveScroll: true
		})
	}

	return (
		<Layout>

			{/* <BannerWithTitle image="/img/blog/banner-blog.jpg" title="Blog" /> */}
			<div className="container py-content">

				<div className="flex flex-col lg:flex-row gap-10">
					<div className="w-full lg:w-8/12 xl:w-9/12">

						{children}
					</div>
					<div className="w-full lg:w-4/12 xl:w-3/12">
						<div className="divide-y divide-gray-200">
							{route().current('blog') && (
								<div className="pb-5">
									<h3 className="font-medium text-xl ">Busqueda{filters?.q && (<span>: {filters?.q}</span>)}</h3>
									<div className="mt-4">
										<form onSubmit={handleSubmit} className="relative">
											<TextInput onChange={(e) => setData('q', e.target.value)} className="w-full pr-16 " value={data.q} />
											<div className="absolute right-0 inset-y-0">
												<PrimaryButton className=' rounded-r-md rounded-l-none' disabled={processing} isLoading={processing}>
													<MagnifyingGlassIcon className="w-6 h-6" />
												</PrimaryButton>
											</div>
										</form>
									</div>
								</div>
							)}

							<div className="py-5">
								<h3 className="font-medium text-xl ">Categorías {filters?.category && (<span>: {filters.category}</span>)}</h3>
								<div className="flex flex-wrap gap-3 mt-4">
									{categories_blog.map((item, index) => (
										<Link key={index} href={route('blog', { category: item.slug })}>
											<Badge color='indigo'>{item.name} ({item.posts_count})</Badge>
										</Link>
									))}
								</div>
							</div>

							<div className="py-5">
								<h3 className="font-medium text-xl ">Post Recientes</h3>
								<div className=" mt-4 space-y-4">
									{recent_post.map((post, index) => (
										<Link className="block" key={index} href={route('post', post.slug)}>
											<div className="flex items-center  gap-x-4">
												<div className="w-4/12">
													<img src={post.img} alt={post.title} className="rounded-md w-full object-cover object-center aspect-video " />
												</div>
												<div className="w-8/12 text-xs">
													<span className=" text-gray-400 uppercase">{post.date}</span>
													<h3 className="font-medium">{post.title}</h3>
												</div>
											</div>
										</Link>
									))}
								</div>
							</div>
							<div className="py-5">
								<a target='_blanck' href="https://rog.asus.com/co/laptops/rog-zephyrus/rog-zephyrus-g14-series/">
									<img src="/img/blog/banner_ad.jpg" alt="" className="w-full rounded-md" />
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</Layout>
	)
}
