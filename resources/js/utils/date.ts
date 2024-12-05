import moment from 'moment';

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

// Return list key date such as beginning of the year, beginning of the month, end of the year, end of the month, beginning of the next year, beginning of the next month in yyyy-mm-dd format in key pair value
export function getKeyDateFromSelectedDate(selectedDate: Date) {
  return {
    beginningOfYear: moment(selectedDate).startOf('year').format('YYYY-MM-DD'),
    beginningOfMonth: moment(selectedDate).startOf('month').format('YYYY-MM-DD'),
    endOfYear: moment(selectedDate).endOf('year').format('YYYY-MM-DD'),
    endOfMonth: moment(selectedDate).endOf('month').format('YYYY-MM-DD'),
    beginningOfNextYear: moment(selectedDate).add(1, 'year').startOf('year').format('YYYY-MM-DD'),
    beginningOfNextMonth: moment(selectedDate).add(1, 'month').startOf('month').format('YYYY-MM-DD'),
    startOfNextMonth: new Date(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 1).toISOString().split('T')[0],
    startOfNextYear: new Date(selectedDate.getFullYear() + 1, 0, 1).toISOString().split('T')[0],
  };
}