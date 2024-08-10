import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import Layout from './Layout';

export default function Guest({ children, title = "" }) {
	return (
		<Layout>
			<div className="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
				<div className="sm:mx-auto sm:w-full sm:max-w-sm">

					<h2 className="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
						{title}
					</h2>
				</div>

				<div className="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
					{children}

				</div>
			</div>
		</Layout>
	);
}



