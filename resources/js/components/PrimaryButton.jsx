export default function PrimaryButton({ className = '', disabled, children, ...props }) {
	return (
		<button
			{...props}
			className={
				`inline-flex items-center px-4 py-2 bg-red-600 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-red-500 dark:hover:bg-white focus:bg-red-500 dark:focus:bg-white active:bg-red-700 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 ${disabled && 'opacity-25'
				} ` + className
			}
			disabled={disabled}
		>
			{children}
		</button>
	);
}
