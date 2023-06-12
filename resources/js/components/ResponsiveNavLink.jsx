import { Link } from '@inertiajs/react';

export default function ResponsiveNavLink({ active = false, className = '', children, ...props }) {
	return (
		<Link
			{...props}
			className={`w-full flex items-start pl-3 pr-4 py-2 border-l-4 ${active
				? 'border-primary-400 dark:border-primary-600 text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/50 focus:text-primary-800 dark:focus:text-primary-200 focus:bg-primary-100 dark:focus:bg-primary-900 focus:border-primary-700 dark:focus:border-primary-300'
				: 'border-transparent text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600'
				} text-base font-medium focus:outline-none transition duration-150 ease-in-out ${className}`}
		>
			{children}
		</Link>
	);
}
