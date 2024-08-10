import { formatDate } from '@/Helpers/helpers'
import Layout from '@/Layouts/Layout'
import LayoutBlog from '@/Layouts/LayoutBlog'
import { Head } from '@inertiajs/react'
import React from 'react'
import AuthorPost from './AuthorPost'

export default function Post({ post }) {
    const breadcrumb = [
        {
            title: "Blog",
            path: route("blog")

        },
        {
            title: post.title,
        }
    ]
    return (
        <LayoutBlog breadcrumb={breadcrumb}>
            <Head title={post.meta_title} />
            <article >
                <div>


                    <div className="capitalize text-gray-500 text-sm">
                        <time dateTime={post.created_at} className="">{post.date}</time>
                    </div>

                    <h1 className="mt-2 text-2xl md:text-4xl font-extrabold leading-tight tracking-tight text-gray-900 lg:text-4xl dark:text-white">{post.title}</h1>

                    <div className="mt-4">
                        <AuthorPost author={post.author} />
                    </div>

                    <img src={post.img} alt="" className="w-full rounded-lg aspect-video object-cover object-center mt-10" />

                </div>
                <p className="lead mt-8 text-xl font-medium md:text-2xl  text-gray-800">{post.entry}</p>
                <div className="mt-4 leading-relaxed tracking-wide text-gray-800 ">
                    <p className="mt-3">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>

                    <h3 className=" text-2xl mt-8 font-medium">Why do we use it?</h3>
                    <p className="mt-3">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>


                    <h3 className=" text-2xl mt-8 font-medium">Where does it come from?</h3>
                    <p className="mt-3">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
                </div>
            </article>
        </LayoutBlog>
    )
}
