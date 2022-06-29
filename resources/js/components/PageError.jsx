import Notifications from "./Notifications"

const PageError = () => {
    return (
        <div className="container py-content">
        <Notifications type='error' errors={'Al parecer hubo un error , intentelo mas tarde'} /></div>
    )
}

export default PageError
