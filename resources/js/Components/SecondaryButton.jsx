import Spinner from "./Spinner";

export default function SecondaryButton({ className = '', disabled, children, isLoading, ...props }) {
	return (
		<button
			{...props}
			className={
				`btn btn-secondary relative ${(disabled || isLoading) && 'opacity-40'
				} ` + className
			}
			disabled={disabled}
		>
			<div className={(isLoading ? 'invisible' : 'visible')}>{children}</div>
			{isLoading && (
				<div className="absolute flex justify-center items-center inset-0">
					<Spinner />
				</div>
			)}

		</button>
	);
}