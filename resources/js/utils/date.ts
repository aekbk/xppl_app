export function isSameDate(date1: Date, date2: Date): boolean {
    return (
        date1.getFullYear() === date2.getFullYear() &&
        date1.getMonth() === date2.getMonth() &&
        date1.getDate() === date2.getDate()
    );
}

export function isSameMonthAndYear(date1: Date, date2: Date): boolean {
    return (
        date1.getFullYear() === date2.getFullYear() &&
        date1.getMonth() === date2.getMonth()
    );
}

export function isSameYear(date1: Date, date2: Date): boolean {
    return date1.getFullYear() === date2.getFullYear();
}

export function formatDateToDayMonth(date: Date): string {
  const formatter = new Intl.DateTimeFormat("en-GB", {
    day: "numeric",
    month: "short",
  });
  return formatter.format(date);
}

export function formatDateToMonthYear(date: Date): string {
  const formatter = new Intl.DateTimeFormat("en-GB", {
    month: "short",
    year: "numeric",
  });
  return formatter.format(date);
}