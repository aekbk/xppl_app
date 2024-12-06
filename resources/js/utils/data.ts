import moment from "moment";

export function subset(
    data: Array<{ date: string }>, // Array of objects with a "date" property as a string
    startDateString: string, // Start date in string format
    endDateString: string // End date in string format
): Array<{ date: string }> {
    // Parse the start and end dates with moment, including the time factor
    const startDate = moment(startDateString).startOf("day"); // Start of the day
    const endDate = moment(endDateString).endOf("day"); // End of the day

    return data.filter(item => {
        const date = moment(item.date); // Parse item.date using moment
        return date.isBetween(startDate, endDate, null, "[]"); // Inclusive range
    });
}