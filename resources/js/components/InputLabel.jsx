const InputLabel = ({
    name = "",
    autoComplete = "off",
    required = false,
    type = "text",
    value = "",
    onChange = () => "",
    label = "",
    placeholder = "",
}) => {
    return (
        <>
            <label htmlFor="email" className="text-sm font-semibold">
                {label}
            </label>
            <input
                className="mt-1 w-full text-sm "
                name={name}
                autoComplete={autoComplete}
                required={required ? "required" : undefined}
                type={type}
                value={value}
                placeholder={placeholder}
                
                onChange={onChange}
            />
        </>
    )
}

export default InputLabel
