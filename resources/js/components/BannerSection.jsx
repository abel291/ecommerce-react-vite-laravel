import { Link } from "react-router-dom"

const BannerSection = ({img}) => {
    return (
        <Link to="/search">
            <div className="w-full">
                <img className="w-full rounded md:rounded-xl" src={img} alt={img} />
            </div>
        </Link>
    )
}

export default BannerSection
