import ApplicationLogo from '@/Components/ApplicationLogo';
import Navbar from '@/Layouts/Navbar/Navbar';
import { Link, usePage } from '@inertiajs/react';
import Footer from './Footer/Footer';

export default function Layout({ children }) {
	const { auth } = usePage().props
	return (

		<>
			<Navbar auth={auth} />
			<main>{children}</main>
			<Footer />
		</>
	);
}