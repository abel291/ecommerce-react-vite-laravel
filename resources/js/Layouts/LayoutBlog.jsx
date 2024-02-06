import React from 'react'
import Layout from '@/Layouts/Layout'
import Badge from '@/Components/Badge'
import TextInput from '@/Components/Form/TextInput'
import PrimaryButton from '@/Components/PrimaryButton'
import { MagnifyingGlassIcon } from '@heroicons/react/24/solid'
import { Head, Link, useForm, usePage } from '@inertiajs/react'
import Breadcrumb from '@/Components/Breadcrumb'
import BannerText from '@/Components/Carousel/BannerText'
import Hero from '@/Components/Hero/Hero'

export default function LayoutBlog({ children, breadcrumb = [], bannerText = null }) {
    const { filters, categories_blog, recent_post, page, banner } = usePage().props
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
            <Breadcrumb data={breadcrumb} />
            <div className="container ">
                {page && (
                    <Hero title={page.title} entry="Este es el blog donde encontrarás todo lo que necesitas para cuidar y mejorar tu computadora!" />
                )}
                <div className='py-content'>
                    <div className="flex flex-col 2xl:flex-row gap-10">
                        <div className="w-full  2xl:w-9/12">
                            {children}
                        </div>
                        <div className="w-full  2xl:w-3/12">
                            <div className="divide-y divide-gray-200">
                                {route().current('blog') && (
                                    <div className="pb-5">
                                        <h3 className="font-medium text-xl ">Busqueda{filters?.q && (<span>: {filters?.q}</span>)}</h3>
                                        <div className="mt-4">
                                            <form onSubmit={handleSubmit} className="flex items-stretch">
                                                <TextInput onChange={(e) => setData('q', e.target.value)} className="w-full -mr-4 " value={data.q} />
                                                <div className="">
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
                                                    <div className="w-8/12 ">
                                                        <span className=" text-gray-500 capitalize text-xs">{post.date}</span>
                                                        <h3 className="font-medium mt-1 text-sm">{post.title}</h3>
                                                    </div>
                                                </div>
                                            </Link>
                                        ))}
                                    </div>
                                </div>
                                {banner && (
                                    <div className="py-5">
                                        <a target='_blanck' href="https://rog.asus.com/co/laptops/rog-zephyrus/rog-zephyrus-g14-series/">
                                            <img src={banner.img} alt="" className="w-full rounded-md" />
                                        </a>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Layout >
    )
}
