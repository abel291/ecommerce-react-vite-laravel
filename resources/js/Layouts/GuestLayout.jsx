import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import Layout from './Layout';

export default function Guest({ children }) {
	return (
		<Layout>
			<div className="px-3 md:px-0 bg-gray-100 dark:bg-gray-900">
				<div className="py-32 flex flex-col sm:justify-center items-center ">
					<div className="hidden lg:block">

						<ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />

					</div>

					<div className="w-full sm:max-w-md mt-6 px-6 pb-4 pt-6 rounded-md bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
						{children}
					</div>
				</div>
			</div>
		</Layout>
	);
}
