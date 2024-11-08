import Spinner from "./Spinner";

export default function PrimaryButton({ className = '', Icon = null, disabled, children, isLoading, ...props }) {
    return (
        <button
            {...props}
            className={
                `btn btn-primary relative  ${(disabled || isLoading) && 'opacity-70'
                } ` + className
            }
            disabled={disabled}
        >
            <div className={(isLoading ? 'invisible' : 'visible')}>
                {Icon ? (
                    <div className="flex items-center">
                        <Icon aria-hidden="true" className="-ml-0.5 mr-1.5 size-5" />
                        {children}
                    </div>
                ) : (
                    children
                )}

            </div>
            {isLoading && (
                <div className="absolute flex justify-center items-center inset-0">
                    <Spinner />
                </div>
            )}

        </button>
    );
}
