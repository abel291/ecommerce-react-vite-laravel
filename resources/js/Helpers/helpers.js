const currencyFormat = Intl.NumberFormat("de-DE", {
    //minimumFractionDigits: 2,
    maximumFractionDigits: 0,
});
export const formatCurrency = (n) => {
    n = n ? n : 0; // number NaN = 0
    return "$ " + currencyFormat.format(parseFloat(n));
};
export const formatDate = (date) => {
    const dtf = new Intl.DateTimeFormat("es", {
        weekday: "long",
        day: "2-digit",
        year: "numeric",
        month: "short",

    });

    let dateFormat = dtf.format(new Date(date));

    return dateFormat;
};


export const formatDateRelative = (date) => {
    const dtfr = new Intl.RelativeTimeFormat("es");
    const DAY_MILLISECONDS = 1000 * 60 * 60 * 24;
    const daysDifference = Math.round(
        (new Date(date).getTime() - new Date().getTime()) / DAY_MILLISECONDS,
    );

    let dateRelative = dtfr.format(daysDifference, 'day');
    return dateRelative;
};
