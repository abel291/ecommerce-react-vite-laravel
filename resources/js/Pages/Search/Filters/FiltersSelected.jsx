import Badge from "@/Components/Badge";
import { formatCurrency } from "@/Helpers/helpers";
import { AdjustmentsVerticalIcon, XMarkIcon } from "@heroicons/react/24/outline";
import { Link, router, usePage } from "@inertiajs/react";
import { FilterTitle } from "./Filters";

const FiltersList = ({ data, setData, changeFilterAttributes }) => {


    const handleClickRemoveItemFilter = (filterName, value) => {
        let newDepartments = data[filterName].filter((item) => item != value);
        setData(filterName, newDepartments);
    };
    const removeAttribute = (attributeName, value) => {
        let newAttributeValues = { ...data.attributes };
        delete newAttributeValues[attributeName]
        // console.log(newAttributeValues)
        setData('attributes', newAttributeValues)
    };

    return (
        <>
            <div className="flex items-center justify-between ">

                <h3 className="font-medium flex items-center gap-x-1 text-gray-700 ">
                    <AdjustmentsVerticalIcon className="w-5 h-5" />
                    Filtros
                </h3>

                <Link className="text-xs font-light" preserveScroll href={route("search")}>
                    Borrar todo
                </Link>
            </div>

            <div className="flex flex-wrap text-xs gap-2.5 mt-4">
                {data.q && (
                    <Badge color="gray">
                        <span className="mr-2 ">"{data.q}"</span>
                        <button onClick={() => setData("q", "")}>
                            <XMarkIcon className="w-3 h-3" />
                        </button>
                    </Badge>
                )}
                {data.departments &&
                    data.departments.map((department, index) => (
                        <Badge color="gray" key={"department" + index}>
                            <span className="mr-2 up">{department}</span>
                            <button
                                onClick={() => handleClickRemoveItemFilter("departments", department)}
                            >
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    ))}
                {data.categories &&
                    data.categories.map((category, index) => (
                        <Badge color="gray" key={"category" + index}>
                            <span className="mr-2 up">{category}</span>
                            <button
                                onClick={() => handleClickRemoveItemFilter("categories", category)}>
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    ))}


                {data.attributes && (
                    Object.entries(data.attributes).map(([attribute, value], index) => (
                        <Badge color="gray" key={"attribute_value" + value}>
                            <span className="mr-2 up">
                                {attribute} {value}
                            </span>
                            <button onClick={() => removeAttribute(attribute, value)}>
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    ))
                )}





                {/* {data.brands.length > 0 &&
                    data.brands.map((item) => (
                        <Badge color='gray' key={item}>
                            <span className="mr-2 up">{item}</span>
                            <button onClick={() => handleClickRemoveFilter("brands", item)}>
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    ))
                } */}
                {
                    data.price_min && (
                        <Badge color="gray">
                            <span className="mr-2 capitalize">
                                Desde {formatCurrency(data.price_min)}
                            </span>
                            <button
                                onClick={() => setData("price_min", '')}
                            >
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    )
                }
                {
                    data.price_max && (
                        <Badge color="gray">
                            <span className="mr-2 capitalize">
                                Hasta {formatCurrency(data.price_max)}
                            </span>
                            <button
                                onClick={() => setData("price_max", '')}
                            >
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    )
                }
                {
                    data.sortBy && (
                        <Badge color="gray">
                            <span className="mr-2 capitalize">{data.sortBy}</span>
                            <button
                                onClick={() => setData("sortBy", null)}
                            >
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    )
                }
                {
                    data.offer && (
                        <Badge color="gray">
                            <span className="mr-2 ">
                                Descuentos desde {data.offer}%
                            </span>
                            <button
                                onClick={() => setData("offer", null)}
                            >
                                <XMarkIcon className="w-3 h-3" />
                            </button>
                        </Badge>
                    )
                }
            </div>

        </>
    );
};

export default FiltersList;
