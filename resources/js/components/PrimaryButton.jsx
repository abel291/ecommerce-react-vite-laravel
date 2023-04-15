export default function PrimaryButton({ className = '', disabled, children, ...props }) {
	return (
		<button
			{...props}
			className={
				`btn-primary ${disabled && 'opacity-25'
				} ` + className
			}
			disabled={disabled}
		>
			{children}
		</button>
	);
}
