import ApplicationLogo from '@/Components/ApplicationLogo';
import Navbar from '@/Layouts/Navbar/Navbar';
import { Link, usePage } from '@inertiajs/react';
import Footer from './Footer/Footer';
import NotificationToast from '@/Components/NotificationToast';

export default function Layout({ children }) {
	const { auth } = usePage().props
	return (
		<>
			<NotificationToast />

			<Navbar auth={auth} />
			<main>{children}</main>
			<Footer />

		</>
	);
}