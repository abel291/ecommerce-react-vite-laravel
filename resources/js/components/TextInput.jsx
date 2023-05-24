import { forwardRef, useEffect, useRef } from 'react';

export default forwardRef(function TextInput({ type = 'text', className = '', isFocused = false, label = null, ...props }, ref) {
	const input = ref ? ref : useRef();

	useEffect(() => {
		if (isFocused) {
			input.current.focus();
		}
	}, []);

	return (
		<>

			<input
				{...props}
				type={type}
				className={'input-form ' + className}
				ref={input}
			/>
		</>
	);
});
