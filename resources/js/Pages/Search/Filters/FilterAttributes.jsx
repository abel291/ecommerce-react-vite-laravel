import React from "react";
import FilterContainer from "./FilterContainer";
import { usePage } from "@inertiajs/react";
import FilterCheckbox from "./FilterCheckbox";

const FilterAttributes = ({ data, setData }) => {
    const { listAttributes } = usePage().props;

    const changeFilterAttributes = (filterName, optionsChecked) => {

        setData("attributes", {
            ...data.attributes,
            [filterName]: optionsChecked,
        });
    };

    return
};

export default FilterAttributes;
