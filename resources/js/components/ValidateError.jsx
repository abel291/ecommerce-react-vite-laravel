export default function ValidaterErrors(errors = null) {
    let errorsArray = []
    let defaultMsg = "Al parecer hubo un error!"

    if (!errors) {
        return defaultMsg
    }
    if ("data" in errors) {
        if (errors.status === 422) {
            if ("errors" in errors.data) {
                let errorMsg = errors.data.errors

                errorsArray = Object.values(errorMsg).map((el) => el[0])
            } else if ("error" in errors.data) {
                errorsArray = errors.data.error
            }
        } else {
            errorsArray = defaultMsg
        }
    }

    return errorsArray
}
