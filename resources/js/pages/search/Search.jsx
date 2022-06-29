import { createSearchParams, useLocation, useNavigate, useSearchParams } from "react-router-dom"
import { useEffect } from "react"
import ListCardProducts from "../../components/ListCardProducts"

import { useRef, useState } from "react"

import FilterCheckbox from "./FilterCheckbox"
import FilterPrice from "./FilterPrice"
import apiClient from "../../auth/apiClient"

import Pagination from "../../components/Pagination"
import LoadingPage from "../../components/LoadingPage"
import FiltersList from "./FiltersList"
import FilterRadio from "./FilterRadio"

import { useQuery } from "react-query"
import { useData } from "../../hooks/useData"
import PageError from "../../components/PageError"
import { Transition } from "@headlessui/react"

const offers = [
    {
        name: "Desde 10%",
        slug: "10",
    },
    {
        name: "Desde 20%",
        slug: "20",
    },
    {
        name: "Desde 30%",
        slug: "30",
    },
    {
        name: "Desde 40%",
        slug: "40",
    },
]
const Search = () => {
    const {
        data: { categories, brands },
    } = useData()

    const filtersInitialise = {
        categories: [],
        brands: [],
        offers: "",
        price_min: "",
        price_max: "",
        q: "",
        sortBy: "",
        page: 1,
    }

    const titleRef = useRef()
    const location = useLocation();

    const [filtersActive, setFiltersActive] = useState(null)
    const [filtersNoEmpty, setFiltersNoEmpty] = useState(null)
    const [searchParams, setSearchParams] = useSearchParams();

    const handleChangeSort = (e) => {
        let target = e.target
        let newFiltersActive = filtersActive
        if (target.value) {
            newFiltersActive.sortBy = target.value
        } else {
            delete newFiltersActive.sortBy
        }
        setFiltersActive({ ...newFiltersActive })
    }

    const handleClickChangePage = (page) => {
        setFiltersActive({
            ...filtersActive,
            page: page,
        })
    }

    const dataFromStateLocations = () => {
        let filters = filtersInitialise

        if (location.state?.categories) {
            filters.categories = [location.state.categories]
        }
        if (location.state?.q) {
            filters.q = location.state.q
        }
        if (location.state?.brands) {
            filters.brands = [location.state.brands]
        }
        if (location.state?.offers) {
            filters.offers = "10"
        }
        setFiltersActive({ ...filters, page: 1 })
    }

    //URL TO STATE filtersActive
    useEffect(() => {
        if (location.state !== null) {
            dataFromStateLocations()
            return
        }

        let newFiltersActive = filtersInitialise

        for (const property in filtersInitialise) {
            let data = searchParams.get(property)
            if (data) {
                switch (property) {
                    case "categories":
                    case "brands":
                        newFiltersActive[property] = data.split(",")
                        break

                    default:
                        newFiltersActive[property] = data
                        break
                }
            }
        }

        setFiltersActive({ ...newFiltersActive })
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])

    useEffect(() => {

        if (filtersActive !== null && location.state !== null) {

            dataFromStateLocations()
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [location.state])


    useEffect(() => {
        if (filtersActive !== null) {
            let newfiltersNoEmpty = {}

            for (const property in filtersActive) {
                let data = filtersActive[property]

                let isEmpty = false
                switch (property) {
                    case "categories":
                    case "brands":
                        isEmpty = data.length === 0
                        break
                    case "page":
                        isEmpty = parseInt(data) === 1
                        break
                    default:
                        isEmpty = data === ""
                        break
                }

                if (!isEmpty) {
                    newfiltersNoEmpty[property] = data
                }
            }

            setFiltersNoEmpty({ ...newfiltersNoEmpty })

            let newParams = new URLSearchParams(newfiltersNoEmpty)
            setSearchParams(newParams)



        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [filtersActive])

    const fecthSearchProducts = async () => {
        const response = await apiClient
            .get("/search", {
                params: {
                    ...filtersNoEmpty,
                },
            })
            .then((res) => {
                return res.data.products
            })

        return response
    }

    const {
        data: products,
        error,
        isFetching,
    } = useQuery(["SEARCH_PRODUCTS", { ...filtersNoEmpty }], fecthSearchProducts, {
        enabled: filtersNoEmpty !== null,
        keepPreviousData: true,
    })

    if (products === undefined) return <LoadingPage />

    if (error) return <PageError />

    return (
        <div className="container ">
            <div className="flex md:flex-row flex-col-reverse ">
                <div className="w-full md:w-3/12 py-content">
                    <div className="pt-5 pr-12 divide-y divide-gray-200">
                        {filtersActive && (
                            <>
                                <div className="py-6">
                                    <FiltersList
                                        filtersActive={filtersActive}
                                        setFiltersActive={setFiltersActive}
                                        filtersInitialise={filtersInitialise}
                                    />
                                </div>
                                <div className="py-6">
                                    <FilterCheckbox
                                        items={categories}
                                        filtersActive={filtersActive}
                                        setFiltersActive={setFiltersActive}
                                        nameInputs="categories"
                                        title="Categorias"
                                    />
                                </div>

                                <div className="py-6">
                                    <FilterPrice filtersActive={filtersActive} setFiltersActive={setFiltersActive} />
                                </div>

                                <div className="py-6">
                                    <FilterRadio
                                        items={offers}
                                        filtersActive={filtersActive}
                                        setFiltersActive={setFiltersActive}
                                        nameInputs="offers"
                                        title="Ofertas"
                                    />
                                </div>

                                <div className="py-6">
                                    <FilterCheckbox
                                        items={brands}
                                        filtersActive={filtersActive}
                                        setFiltersActive={setFiltersActive}
                                        nameInputs="brands"
                                        title="Marcas"
                                    />
                                </div>
                            </>
                        )}
                        <div className="py-6 ">
                            <a target="_black" href="https://www.logitechstore.com.ar/Gaming/Volantes">
                                <img className="rounded-lg" src="/img/banner-sidebar-search.jpg" alt="" />
                            </a>

                        </div>
                    </div>
                </div>
                <div className="w-full md:w-9/12 py-content">
                    <div className=" space-y-4 relative md:p-4">
                        <div className="flex items-center justify-between">
                            <h2 className="font-bold text-2xl" ref={titleRef}>
                                Busqueda
                            </h2>
                            <div className="flex flex-col-reverse items-end md:flex-row md:items-center">
                                <span className="font-light text-sm">{products.total} artículos</span>
                                <select onChange={handleChangeSort} className="ml-7 py-2 font-semibold text-sm" name="sortBy" id="">
                                    <option disabled>Ordenar Por:</option>
                                    <option value="">Mas relevantes</option>
                                    <option value="price_asc">Menor precio</option>
                                    <option value="price_desc">Mayor precio</option>
                                </select>
                            </div>
                        </div>
                        {products.data.length ? (
                            <div className="py-content relative">
                                <>
                                    <div className="grid grid-cols-2 gap-2 md:grid-cols-3 md:gap-4 ">
                                        {products.data.map((item) => (
                                            <ListCardProducts key={item.id} img={"/img/home/" + item.img} product={item} />
                                        ))}
                                    </div>
                                    {products.total > products.per_page && (
                                        <div className="mt-8">
                                            <Pagination paginator={products} handleClickChangePage={handleClickChangePage} />
                                        </div>
                                    )}
                                </>
                            </div>
                        ) : (
                            <div className="text-center mt-10 pt-10">No se encontraron registros</div>
                        )}
                        <Transition
                            show={isFetching}
                            enter="transition-opacity duration-500"
                            enterFrom="opacity-0"
                            enterTo="opacity-100"
                            leave="transition-opacity duration-500"
                            leaveFrom="opacity-100"
                            leaveTo="opacity-0"
                            className="absolute inset-0 backdrop-filter backdrop-blur-md z-10"
                        >

                        </Transition>

                    </div>
                </div>
            </div>
        </div>
    )
}

export default Search
