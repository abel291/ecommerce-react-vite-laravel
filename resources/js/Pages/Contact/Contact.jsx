import BannerWithTitle from '@/Components/Carousel/BannerWithTitle'
import Layout from '@/Layouts/Layout'
import React from 'react'
import ContactAddress from './ContactAddress'
import { Head } from '@inertiajs/react'
import ContactForm from './ContactForm'

export default function Contact({ page }) {
	return (
		<Layout>
			<Head title={page.meta_title} />
			<BannerWithTitle title="Contáctenos" image="/img/contact-us/banner.jpg" />
			<div className="container ">
				<div className="py-content flex flex-col lg:flex-row ">
					<div className="w-full lg:w-5/12  my-8  lg:my-0 lg:mr-8">
						<ContactAddress />
					</div>
					<div className="w-full lg:w-7/12  ">
						<ContactForm />
					</div>
				</div>
			</div>
		</Layout>
	)
}
