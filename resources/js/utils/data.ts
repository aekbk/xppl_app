export function subset(data: Array<any>, startDateString: string, endDateString: string) {
    const startDate = new Date(startDateString);
    const endDate = new Date(endDateString);

    return data.filter(item => {
        const date = new Date(item.date);
        return date >= startDate && date <= endDate;
    });
}