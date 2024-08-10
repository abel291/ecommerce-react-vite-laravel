import BannerWithTitle from '@/Components/Carousel/BannerWithTitle'
import Layout from '@/Layouts/Layout'
import React from 'react'
import ContactAddress from './ContactAddress'
import { Head } from '@inertiajs/react'
import ContactForm from './ContactForm'
import BannerText from '@/Components/Carousel/BannerText'
import Breadcrumb from '@/Components/Breadcrumb'
import Hero from '@/Components/Hero/Hero'

export default function Contact({ page }) {
	return (
		<Layout>
			<Head title={page.meta_title} />
			<Breadcrumb data={[
				{
					title: 'Contáctenos',

				}]} />

			<div className="container ">
				<Hero title="Contáctenos" />
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
