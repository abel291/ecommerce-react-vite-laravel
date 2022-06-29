import SpinnerLoad from "./SpinnerLoad"

const TextLoadingSpinner = ({ isLoading, text, textLoading }) => {
    return isLoading ? (
        <div className="flex items-center justify-center">
            <SpinnerLoad />
            {textLoading && <span>{textLoading}</span>}
        </div>
    ) : (
        text
    )
}

export default TextLoadingSpinner
