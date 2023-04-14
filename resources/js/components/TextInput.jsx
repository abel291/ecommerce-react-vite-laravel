import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function TextInput({ type = 'text', className = '', isFocused = false, ...props }, ref) {
	const input = ref ? ref : useRef();

	useEffect(() => {
		if (isFocused) {
			input.current.focus();
		}
	}, []);

	return (
		<input
			{...props}
			type={type}
			className={
				'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-md shadow-sm ' +
				className
			}
			ref={input}
		/>
	);
});
