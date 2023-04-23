import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import Layout from './Layout';

export default function Guest({ children }) {
	return (
		<Layout>
			<div className="pt-6 md:py-32 flex flex-col sm:justify-center items-center bg-gray-100 dark:bg-gray-900">
				<div>
					<Link href="/">
						<ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
					</Link>
				</div>

				<div className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
					{children}
				</div>
			</div>
		</Layout>
	);
}
