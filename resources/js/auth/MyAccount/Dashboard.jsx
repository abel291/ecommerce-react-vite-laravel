import { useMatch } from "react-router"
import { Link } from "react-router-dom"


const Dashboard = () => {
    //let { url } = useMatch()

    return (
        <div className="space-y-2">
            <h3 className="font-bold text-2xl mb-6">Dashboard</h3>
            <div>
                Desde el panel de control de su cuenta, puede ver sus , administrar los
                <Link to={"order"} className="font-bold underline px-1 ">
                    pedidos recientes
                </Link>
                , administrar los
                <Link to={"account-details"} className="font-bold underline px-1 ">
                    detalles de su cuenta
                </Link>
                y
                <Link to={"change-password"} className="font-bold underline px-1 ">
                    cambiar su contraseña.
                </Link>
                .
            </div>
        </div>
    )
}

export default Dashboard
