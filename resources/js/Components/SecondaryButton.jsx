import Spinner from "./Spinner";

export default function SecondaryButton({ className = '', Icon = null, disabled, children, isLoading, ...props }) {
    return (
        <button
            {...props}
            className={
                `btn btn-secondary relative ${(disabled || isLoading) && 'opacity-40'
                } ` + className
            }
            disabled={disabled}
        >
            <div className={(isLoading ? 'invisible' : 'visible') + " flex items-center"}>

                {Icon && (<Icon aria-hidden="true" className="-ml-0.5 mr-1.5 size-5 text-gray-400" />)}
                {children}

            </div>
            {isLoading && (
                <div className="absolute flex justify-center items-center inset-0">
                    <Spinner />
                </div>
            )}

        </button>
    );
}
